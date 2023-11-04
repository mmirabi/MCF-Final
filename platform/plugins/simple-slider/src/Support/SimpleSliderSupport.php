<?php

namespace Botble\SimpleSlider\Support;

use Botble\Base\Facades\MetaBox;
use Botble\SimpleSlider\Models\SimpleSliderItem;

class SimpleSliderSupport
{
    public static function registerResponsiveImageSizes(): void
    {
        add_action(
            [BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT],
            function ($type, $request, $object) {
                if (! $object instanceof SimpleSliderItem) {
                    return;
                }

                if ($request->has('tablet_image')) {
                    MetaBox::saveMetaBoxData($object, 'tablet_image', $request->input('tablet_image'));
                }

                if ($request->has('mobile_image')) {
                    MetaBox::saveMetaBoxData($object, 'mobile_image', $request->input('mobile_image'));
                }
            },
            145,
            3
        );

        add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
            if (! $data instanceof SimpleSliderItem) {
                return $form;
            }

            $form
                ->addAfter('image', 'tablet_image', 'mediaImage', [
                    'label' => __('Tablet Image'),
                    'value' => $data->getMetaData('tablet_image', true),
                    'help_block' => [
                        'text' => __(
                            'For devices with width from 768px to 1200px, if empty, will use the image from the desktop.'
                        ),
                    ],
                ])
                ->addAfter('tablet_image', 'mobile_image', 'mediaImage', [
                    'label' => __('Mobile Image'),
                    'value' => $data->getMetaData('mobile_image', true),
                    'help_block' => [
                        'text' => __(
                            'For devices with width less than 768px, if empty, will use the image from the tablet.'
                        ),
                    ],
                ]);

            return $form;
        }, 127, 3);
    }
}
