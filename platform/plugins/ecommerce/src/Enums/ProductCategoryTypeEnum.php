<?php

namespace Botble\Ecommerce\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Support\HtmlString;

/**
 * @method static ProductCategoryTypeEnum PRODUCT()
 * @method static ProductCategoryTypeEnum ADDITIONAL()
 */
class ProductCategoryTypeEnum extends Enum
{
    public const PRODUCT = 'product';
    public const ADDITIONAL = 'additional';

    public static $langPath = 'plugins/ecommerce::products.types';

    public function toHtml(): HtmlString|string
    {
        return match ($this->value) {
            self::PRODUCT => Html::tag('span', self::DIGITAL()->label(), ['class' => 'label-primary status-label'])
                ->toHtml(),
            self::ADDITIONAL => Html::tag('span', self::DIGITAL()->label(), ['class' => 'label-warning status-label'])
                ->toHtml(),
            default => parent::toHtml(),
        };
    }

    public function toIcon(): string
    {
        if (! EcommerceHelper::isEnabledSupportDigitalProducts()) {
            return '';
        }

        return match ($this->value) {
            self::PRODUCT => Html::tag('i', '', [
                'class' => 'fa-solid fa-microchip text-info',
                'title' => self::DIGITAL()->label(),
            ])->toHtml(),
            self::ADDITIONAL => Html::tag('i', '', [
                'class' => 'fa-solid fa-additional text-info',
                'title' => self::DIGITAL()->label(),
            ])->toHtml(),
            default => Html::tag('i', '', ['class' => 'fa fa-camera'])->toHtml(),
        };
    }
}
