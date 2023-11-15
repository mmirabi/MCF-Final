<?php

namespace Botble\Translation\Models;

use Botble\Base\Models\BaseModel;
use Botble\Translation\Models\QueryBuilders\TranslationQueryBuilder;

class Translation extends BaseModel
{
    public const STATUS_SAVED = 0;
    public const STATUS_CHANGED = 1;

    protected $table = 'translations';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function newEloquentBuilder($query): TranslationQueryBuilder
    {
        return new TranslationQueryBuilder($query);
    }
}
