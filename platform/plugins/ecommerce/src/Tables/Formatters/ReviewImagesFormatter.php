<?php

namespace Botble\Ecommerce\Tables\Formatters;

use Botble\Base\Facades\Html;
use Botble\Media\Facades\RvMedia;
use Botble\Table\Formatter;

class ReviewImagesFormatter implements Formatter
{
    public function format($value, $row): string
    {
        if (! is_array($value)) {
            return '&mdash;';
        }

        $count = count($value);

        if ($count == 0) {
            return '&mdash;';
        }

        $galleryID = 'images-group-' . $row->getKey();

        $html = Html::image(
            RvMedia::getImageUrl($value[0], 'thumb'),
            RvMedia::getImageUrl($value[0]),
            [
                'width' => 60,
                'class' => 'fancybox m-1 rounded-top rounded-end rounded-bottom rounded-start border d-inline-block',
                'href' => RvMedia::getImageUrl($value[0]),
                'data-fancybox' => $galleryID,
            ]
        );

        if (isset($value[1])) {
            if ($count == 2) {
                $html .= Html::image(
                    RvMedia::getImageUrl($value[1], 'thumb'),
                    RvMedia::getImageUrl($value[1]),
                    [
                        'width' => 60,
                        'class' => 'fancybox m-1 rounded-top rounded-end rounded-bottom rounded-start border d-inline-block',
                        'href' => RvMedia::getImageUrl($value[1]),
                        'data-fancybox' => $galleryID,
                    ]
                );
            } elseif ($count > 2) {
                $html .= Html::tag(
                    'a',
                    Html::image(
                        RvMedia::getImageUrl($value[1], 'thumb'),
                        RvMedia::getImageUrl($value[1]),
                        [
                            'width' => 60,
                            'class' => 'm-1 rounded-top rounded-end rounded-bottom rounded-start border',
                            'src' => RvMedia::getImageUrl($value[1]),
                        ]
                    )->toHtml() . Html::tag('span', '+' . ($count - 2))->toHtml(),
                    [
                        'class' => 'fancybox more-review-images',
                        'href' => RvMedia::getImageUrl($value[1]),
                        'data-fancybox' => $galleryID,
                    ]
                );
            }
        }

        if ($count > 2) {
            foreach ($value as $index => $image) {
                if ($index > 1) {
                    $html .= Html::image(
                        RvMedia::getImageUrl($value[$index], 'thumb'),
                        RvMedia::getImageUrl($value[$index]),
                        [
                            'width' => 60,
                            'class' => 'fancybox d-none',
                            'href' => RvMedia::getImageUrl($value[$index]),
                            'data-fancybox' => $galleryID,
                        ]
                    );
                }
            }
        }

        return $html;
    }
}
