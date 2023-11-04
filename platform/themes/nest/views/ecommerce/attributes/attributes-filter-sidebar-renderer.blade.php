@foreach ($attributeSets as $attributeSet)
    @php($selected = Arr::get($selectedAttrs, $attributeSet->slug, $selectedAttrs))

    @if (view()->exists($viewPath = Theme::getThemeNamespace('views.ecommerce.attributes._layouts-filter-sidebar.' . $attributeSet->display_layout)))
        @include($viewPath, [
            'set' => $attributeSet,
            'attributes' => $attributeSet->attributes,
        ])
    @else
        @include(Theme::getThemeNamespace('views.ecommerce.attributes._layouts-filter.dropdown'), [
            'set' => $attributeSet,
            'attributes' => $attributeSet->attributes,
        ])
    @endif
@endforeach
