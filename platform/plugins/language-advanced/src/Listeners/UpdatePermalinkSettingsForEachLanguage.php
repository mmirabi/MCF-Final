<?php

namespace Botble\LanguageAdvanced\Listeners;

use Botble\Slug\Events\UpdatedPermalinkSettings;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;

class UpdatePermalinkSettingsForEachLanguage
{
    public function handle(UpdatedPermalinkSettings $event): void
    {
        if (! $event->request->filled('ref_lang')) {
            return;
        }

        $slugIds = Slug::query()
            ->where('reference_type', $event->reference)
            ->pluck('id')
            ->all();

        DB::table('slugs_translations')
            ->whereIn('slugs_id', $slugIds)
            ->update(['prefix' => $event->prefix]);
    }
}
