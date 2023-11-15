<?php

namespace Botble\Faq\Listeners;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Faq\FaqSupport;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        if (! $event->request->has('content') || ! $event->request->has('faq_schema_config')) {
            return;
        }

        (new FaqSupport())->saveConfigs($event->data, $event->request->input('faq_schema_config'));
    }
}
