<?php

namespace Botble\ACL\Tables;

use Botble\ACL\Enums\UserStatusEnum;
use Botble\ACL\Models\User;
use Botble\ACL\Services\ActivateUserService;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Exceptions\DisabledInDemoModeException;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\EmailColumn;
use Botble\Table\Columns\LinkableColumn;
use Botble\Table\Columns\YesNoColumn;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserTable extends TableAbstract
{
    public function setup(): void
    {
        $this->model(User::class)
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'username',
                        'email',
                        'updated_at',
                        'created_at',
                        'super_user',
                    ])
                    ->with(['roles']);
            });
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('role_name', function (User $item) {
                $role = $item->roles->first();

                if (! $this->hasPermission('users.edit')) {
                    return $role?->name ?: trans('core/acl::users.no_role_assigned');
                }

                return view('core/acl::users.partials.role', compact('item', 'role'))->render();
            })
            ->editColumn('status_name', function (User $item) {
                if ($item->activations()->where('completed', true)->exists()) {
                    return UserStatusEnum::ACTIVATED()->toHtml();
                }

                return UserStatusEnum::DEACTIVATED()->toHtml();
            })
            ->addColumn('operations', function (User $item) {
                $action = null;
                if (Auth::guard()->user()->isSuperUser()) {
                    $action = Html::link(
                        route('users.make-super', $item->getKey()),
                        trans('core/acl::users.make_super'),
                        ['class' => 'btn btn-info']
                    )->toHtml();

                    if ($item->super_user) {
                        $action = Html::link(
                            route('users.remove-super', $item->getKey()),
                            trans('core/acl::users.remove_super'),
                            ['class' => 'btn btn-danger']
                        )->toHtml();
                    }
                }

                return apply_filters(
                    ACL_FILTER_USER_TABLE_ACTIONS,
                    $action . view('core/acl::users.partials.actions', compact('item'))->render(),
                    $item
                );
            });

        return $this->toJson($data);
    }

    public function columns(): array
    {
        return [
            LinkableColumn::make('username')
                ->route('users.profile.view')
                ->title(trans('core/acl::users.username'))
                ->alignStart(),
            EmailColumn::make()->linkable(),
            Column::make('role_name')
                ->title(trans('core/acl::users.role'))
                ->searchable(false)
                ->orderable(false),
            CreatedAtColumn::make(),
            Column::make('status_name')
                ->title(trans('core/base::tables.status'))
                ->width(100)
                ->searchable(false)
                ->orderable(false),
            YesNoColumn::make('super_user')
                ->title(trans('core/acl::users.is_super'))
                ->width(100),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('users.create'), 'users.create');
    }

    public function htmlDrawCallbackFunction(): string|null
    {
        return parent::htmlDrawCallbackFunction() . '$(".editable").editable({mode: "inline"});';
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()
                ->permission('users.destroy')
                ->beforeDispatch(function (User $user, array $ids) {
                    foreach ($ids as $id) {
                        if (Auth::guard()->id() == $id) {
                            abort(403, trans('core/acl::users.delete_user_logged_in'));
                        }

                        /**
                         * @var User $user
                         */
                        $user = User::query()->findOrFail($id);
                        if (! Auth::guard()->user()->isSuperUser() && $user->isSuperUser()) {
                            abort(403, trans('core/acl::users.cannot_delete_super_user'));
                        }
                    }
                }),
        ];
    }

    public function getFilters(): array
    {
        $filters = $this->getAllBulkChanges();
        Arr::forget($filters, 'status');

        return $filters;
    }

    public function getBulkChanges(): array
    {
        return [
            'username' => [
                'title' => trans('core/acl::users.username'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'email' => [
                'title' => trans('core/base::tables.email'),
                'type' => 'text',
                'validate' => 'required|max:120|email',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'customSelect',
                'choices' => UserStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', UserStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }

    public function getOperationsHeading(): array
    {
        return [
            'operations' => [
                'title' => trans('core/base::tables.operations'),
                'width' => '350px',
                'class' => 'text-end',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
            ],
        ];
    }

    public function saveBulkChanges(array $ids, string $inputKey, string|null $inputValue): bool
    {
        if (BaseHelper::hasDemoModeEnabled()) {
            throw new DisabledInDemoModeException();
        }

        if ($inputKey === 'status') {
            $hasWarning = false;

            $service = app(ActivateUserService::class);

            foreach ($ids as $id) {
                if ($inputValue == UserStatusEnum::DEACTIVATED && Auth::guard()->id() == $id) {
                    $hasWarning = true;
                }

                $user = $this->getModel()->query()->findOrFail($id);

                if (! $user instanceof User) {
                    continue;
                }

                if ($inputValue == UserStatusEnum::ACTIVATED) {
                    $service->activate($user);
                } else {
                    $service->remove($user);
                }

                event(new UpdatedContentEvent(USER_MODULE_SCREEN_NAME, request(), $user));
            }

            if ($hasWarning) {
                throw new Exception(trans('core/acl::users.lock_user_logged_in'));
            }

            return true;
        }

        return parent::saveBulkChanges($ids, $inputKey, $inputValue);
    }
}
