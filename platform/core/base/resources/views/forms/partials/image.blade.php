<div class="image-box">
    <input
        class="image-data"
        name="{{ $name }}"
        type="hidden"
        value="{{ $value }}"
        {!! Html::attributes(Arr::except((array) $attributes, ['action'])) !!}
    >
    @if (!is_in_admin(true) || !auth()->check())
        <input
            class="media-image-input"
            type="file"
            style="display: none;"
            @if ($name) name="{{ $name }}_input" @endif
            @if (!isset($attributes['action']) || $attributes['action'] == 'select-image') accept="image/*" @endif
            {!! Html::attributes(Arr::except((array) $attributes, ['action'])) !!}
        >
    @endif
    <div class="preview-image-wrapper @if (!($allowThumb = Arr::get($attributes, 'allow_thumb', true))) preview-image-wrapper-not-allow-thumb @endif">
        <img
            class="preview_image"
            data-default="{{ $defaultImage = Arr::get($attributes, 'default_image', RvMedia::getDefaultImage()) }}"
            src="{{ $image ?? RvMedia::getImageUrl($value, $allowThumb ? 'thumb' : null, false, $defaultImage) }}"
            alt="{{ trans('core/base::base.preview_image') }}"
            @if ($allowThumb) width="150" @endif
        >
        <a
            class="btn_remove_image"
            title="{{ trans('core/base::forms.remove_image') }}"
        >
            <i class="fa fa-times"></i>
        </a>
    </div>
    <div class="image-box-actions">
        <a
            class="@if (is_in_admin(true) && auth()->check()) btn_gallery @else media-select-image @endif"
            data-result="{{ $name }}"
            data-action="{{ $attributes['action'] ?? 'select-image' }}"
            data-allow-thumb="{{ $allowThumb == true }}"
            href="#"
        >
            {{ trans('core/base::forms.choose_image') }}
        </a>
    </div>
</div>
