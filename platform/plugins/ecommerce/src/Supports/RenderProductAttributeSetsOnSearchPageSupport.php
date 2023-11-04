<?php

namespace Botble\Ecommerce\Supports;

use Botble\Base\Models\BaseQueryBuilder;
use Botble\Ecommerce\Facades\EcommerceHelper as EcommerceHelperFacade;
use Botble\Ecommerce\Models\ProductAttributeSet;
use Illuminate\Support\Arr;

class RenderProductAttributeSetsOnSearchPageSupport
{
    public function render(array $params = []): string
    {
        if (! EcommerceHelperFacade::isEnabledFilterProductsByAttributes()) {
            return '';
        }

        $params = array_merge(['view' => 'plugins/ecommerce::themes.attributes.attributes-filter-renderer'], $params);

        $with = ['attributes', 'categories:id'];

        if (is_plugin_active('language') && is_plugin_active('language-advanced')) {
            $with[] = 'attributes.translations';
        }

        $attributeSetQuery = ProductAttributeSet::query()
            ->where('is_searchable', true)
            ->wherePublished();

        $request = request();

        if ($categoryIds = (array) $request->input('categories', [])) {
            $attributeSetQuery = $attributeSetQuery
                ->where(function (BaseQueryBuilder $query) use ($categoryIds) {
                    $query
                        ->whereDoesntHave('categories')
                        ->orWhereHas('categories', function (BaseQueryBuilder $query) use ($categoryIds) {
                            $query->whereIn('id', $categoryIds);
                        });
                });
        }

        $attributeSets = $attributeSetQuery
            ->orderBy('order')
            ->with($with)
            ->get();

        $selectedAttrs = [];

        $attributesInput = (array) $request->input('attributes', []);

        if (! array_is_list($attributesInput)) {
            foreach ($attributeSets as $attributeSet) {
                $selectedAttrs[$attributeSet->slug] = Arr::get($attributesInput, $attributeSet->slug, []);
            }
        } else {
            $selectedAttrs = $attributesInput;
        }

        return view($params['view'], array_merge($params, compact('attributeSets', 'selectedAttrs')))->render();
    }
}
