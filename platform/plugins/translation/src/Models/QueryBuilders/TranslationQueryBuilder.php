<?php

namespace Botble\Translation\Models\QueryBuilders;

use Botble\Base\Models\BaseQueryBuilder;
use Illuminate\Support\Facades\DB;

class TranslationQueryBuilder extends BaseQueryBuilder
{
    public function ofTranslatedGroup(string|null $group): static
    {
        // @phpstan-ignore-next-line
        $this->where('group', $group)->whereNotNull('value');

        return $this;
    }

    public function orderByGroupKeys(bool $ordered): static
    {
        if ($ordered) {
            // @phpstan-ignore-next-line
            $this->orderBy('group')->orderBy('key');
        }

        return $this;
    }

    public function selectDistinctGroup(): static
    {
        $select = match (DB::getDefaultConnection()) {
            'mysql' => 'DISTINCT `group`',
            default => 'DISTINCT "group"',
        };

        // @phpstan-ignore-next-line
        $this->select(DB::raw($select));

        return $this;
    }
}
