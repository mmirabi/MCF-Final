<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\Html;
use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Enums\MessageCategoryTypeEnum;
use Botble\Media\Facades\RvMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class MessageCategory extends BaseModel
{
    protected $table = 'ec_message_categories';

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'order',
        'status',
        'image',
        'icon',
        'icon_image',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function cards(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                MessageCard::class,
                'ec_message_card_category',
                'category_id',
                'message_id'
            );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MessageCategory::class, 'parent_id')->withDefault();
    }

    protected function parents(): Attribute
    {
        return Attribute::make(
            get: function (): Collection {
                $parents = collect();

                $parent = $this->parent;

                while ($parent->id) {
                    $parents->push($parent);
                    $parent = $parent->parent;
                }

                return $parents;
            },
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(MessageCategory::class, 'parent_id');
    }

    public function activeChildren(): HasMany
    {
        return $this
            ->children()
            ->wherePublished()
            ->orderBy('order')
            ->with(['activeChildren']);
    }


    protected function iconHtml(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): HtmlString|null {
                if ($attributes['icon_image']) {
                    return RvMedia::image($attributes['icon_image'], attributes: [
                        'alt' => $attributes['name'],
                    ]);
                }

                if ($attributes['icon']) {
                    return Html::tag('i', '', $attributes['icon']);
                }

                return null;
            }
        );
    }

    protected static function booted(): void
    {
        self::deleting(function (MessageCategory $category) {

            $category->children()->each(fn (MessageCategory $child) => $child->delete());

            $category->cards()->detach();
        });
    }
}
