<?php

namespace Botble\Faq\Listeners;

use Botble\Base\Events\UpdatedContentEvent;
use Botble\Faq\FaqSupport;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        if (! $event->request->has('content') || ! $event->request->has('faq_schema_config')) {
            return;
        }

        (new FaqSupport())->saveConfigs($event->data, $event->request->input('faq_schema_config'));
    }
}
