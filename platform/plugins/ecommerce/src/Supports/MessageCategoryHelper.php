<?php

namespace Botble\Ecommerce\Supports;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Models\MessageCategory;
use Botble\Language\Facades\Language;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MessageCategoryHelper
{
    protected Collection $allCategories;

    protected Collection $treeCategories;

    public function getAllMessageCategories(array $params = [], bool $onlyParent = false): Collection
    {
        if (! isset($this->allCategories)) {
            $query = MessageCategory::query();

            if (! empty($conditions = Arr::get($params, 'condition', []))) {
                $query = $query->where($conditions);
            }

            if (! empty($with = Arr::get($params, 'with', []))) {
                $query = $query->with($with);
            }

            if (! empty($withCount = Arr::get($params, 'withCount', []))) {
                $query = $query->withCount($withCount);
            }

            if ($onlyParent) {
                $query = $query->where(function ($query) {
                    $query
                        ->whereNull('parent_id')
                        ->orWhere('parent_id', 0);
                });
            }

            $query = $query
                ->orderBy('order')
                ->orderByDesc('created_at');

            if ($select = Arr::get($params, 'select', [
                'id',
                'name',
                'status',
                'is_featured',
                'image',
            ])) {
                $query = $query->select($select);
            }

            $this->allCategories = $query->get();
        }

        return $this->allCategories;
    }

    /**
     * @deprecated
     */
    public function getAllMessageCategoriesSortByChildren(): Collection
    {
        return $this->getTreeCategories();
    }

    /**
     * @deprecated
     */
    public function getAllMessageCategoriesWithChildren(): array
    {
        return $this->getTreeCategories()->toArray();
    }

    /**
     * @deprecated
     */
    public function getMessageCategoriesWithIndent(): Collection
    {
        return $this->getActiveTreeCategories();
    }

    public function getActiveTreeCategories(): Collection
    {
        return $this->getTreeCategories(true);
    }

    public function getTreeCategories(bool $activeOnly = false): Collection
    {
        if (! isset($this->treeCategories)) {
            $this->treeCategories = $this->getAllMessageCategories(
                [
                    'condition' => $activeOnly ? ['status' => BaseStatusEnum::PUBLISHED] : [],
                    'with' => [$activeOnly ? 'activeChildren' : 'children'],
                ],
                true
            );
        }

        return $this->treeCategories;
    }

    public function getTreeCategoriesOptions(array|Collection $categories, array $options = [], string $indent = null): array
    {
        if (! $categories instanceof Collection) {
            foreach ($categories as $category) {
                $options[$category['id']] = $indent . $category['name'];

                if (! empty($category['active_children']) || ! empty($category['children'])) {
                    $options = $this->getTreeCategoriesOptions($category['active_children'] ?? $category['children'], $options, $indent . '&nbsp;&nbsp;');
                }
            }

            return $options;
        }

        foreach ($categories as $category) {
            $options[$category->id] = $indent . $category->name;

            if (! empty($category->activeChildren)) {
                $options = $this->getTreeCategoriesOptions(
                    $category->activeChildren,
                    $options,
                    $indent . '&nbsp;&nbsp;'
                );
            }
        }

        return $options;
    }

    public function renderMessageCategoriesSelect(int|string $selected = null): string
    {
        $query = MessageCategory::query()
            ->toBase()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->select([
                'ec_message_categories.id',
                'ec_message_categories.name',
                'parent_id',
            ])
            ->orderBy('order')
            ->orderByDesc('created_at');

        $categories = $this->applyQuery($query)->get();

        return view('core/base::forms.partials.nested-select-option', [
            'options' => $categories,
            'indent' => null,
            'selected' => $selected,
        ])->render();
    }

    public function getMessageCategoriesWithUrl(array $categoryIds = []): Collection
    {
        $query = MessageCategory::query()
            ->toBase()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->select([
                'ec_message_categories.id',
                'ec_message_categories.name',
                'parent_id',
                DB::raw('CONCAT(slugs.prefix, "/", slugs.key) as url'),
                'icon',
                'icon_image',
            ])
            ->leftJoin('slugs', function (JoinClause $join) {
                $join
                    ->on('slugs.reference_id', 'ec_message_categories.id')
                    ->where('slugs.reference_type', MessageCategory::class);
            });

        if ($this->isEnabledMultiLanguages()) {
            $query = $query
                ->leftJoin('slugs_translations as st', function (JoinClause $join) {
                    $join
                        ->on('st.slugs_id', 'slugs.id')
                        ->where('st.lang_code', Language::getCurrentLocale());
                })
                ->addSelect(DB::raw('IF(st.key IS NOT NULL, CONCAT(st.prefix, "/", st.key), CONCAT(slugs.prefix, "/", slugs.key)) as url'));
        }

        $query = $query
            ->orderBy('ec_message_categories.order')
            ->orderByDesc('ec_message_categories.created_at')
            ->when(
                ! empty($categoryIds),
                fn (Builder $query) => $query->whereIn('ec_message_categories.id', $categoryIds)
            );

        $query = $this->applyQuery($query);

        return $query->get();
    }

    public function applyQuery(Builder $query): Builder
    {
        if ($this->isEnabledMultiLanguages()) {
            return $query
                ->leftJoin('ec_message_categories_translations as ct', function (JoinClause $join) {
                    $join
                        ->on('ec_message_categories_id', 'ec_message_categories.id')
                        ->where('ct.lang_code', Language::getCurrentLocale());
                })
                ->addSelect(DB::raw('IF(ct.name IS NOT NULL, ct.name, ec_message_categories.name) as name'));
        }

        return $query;
    }

    protected function isEnabledMultiLanguages(): bool
    {
        return is_plugin_active('language') &&
            is_plugin_active('language-advanced') &&
            Language::getCurrentLocale() !== Language::getDefaultLocale();
    }
}
