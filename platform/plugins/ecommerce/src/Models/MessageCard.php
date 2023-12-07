<?php

namespace Botble\Ecommerce\Models;

use Botble\ACL\Models\User;
use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

/**
 * @method notOutOfStock()
 */
class MessageCard extends BaseModel
{
    protected $table = 'ec_message_cards';

    protected $fillable = [
        'title',
        'description',
        'content',
        'order',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'title' => SafeContent::class,
        'description' => SafeContent::class,
        'content' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        self::creating(function (self $product) {
        });

        self::deleting(function (self $product) {
            $product->categories()->detach();
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            MessageCategory::class,
            'ec_message_card_category',
            'message_id',
            'category_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function createdBy(): MorphTo
    {
        return $this->morphTo()->withDefault();
    }
}
