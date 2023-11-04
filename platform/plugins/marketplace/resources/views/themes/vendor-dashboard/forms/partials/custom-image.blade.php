<div class="image-box">
    <input
        class="image-data"
        name="{{ $name }}"
        type="hidden"
        value="{{ $value }}"
    >
    <input
        class="image_input"
        name="{{ $name }}_input"
        type="file"
        style="display: none;"
        accept="image/*"
    >
    <div class="preview-image-wrapper">
        <img
            class="preview_image"
            data-default-image="{{ RvMedia::getDefaultImage() }}"
            src="{{ RvMedia::getImageUrl($value, 'thumb', false, RvMedia::getDefaultImage()) }}"
            alt="{{ trans('core/base::base.preview_image') }}"
            width="150"
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
            class="custom-select-image"
            href="#"
        >
            {{ trans('core/base::forms.choose_image') }}
        </a>
    </div>
</div>
