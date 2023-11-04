<div class="gallery-images-wrapper list-images">
    @php
        $values = $values == '[null]' ? '[]' : $values;
        $attributes = $attributes ?? [];
        $allowThumb = Arr::get($attributes, 'allow_thumb', true);
    @endphp
    @php $images = array_filter((array) old($name, !is_array($values) ? json_decode($values ?: '', true) : $values)); @endphp
    <div class="images-wrapper">
        <div
            class="text-center cursor-pointer js-btn-trigger-add-image default-placeholder-gallery-image @if (!empty($images)) hidden @endif"
            data-name="{{ $name }}"
        >
            <img
                src="{{ RvMedia::getDefaultImage() }}"
                alt="{{ trans('core/base::base.image') }}"
                width="120"
            >
            <br>
            <p style="color:#c3cfd8">{{ trans('core/base::base.using_button') }}
                <strong>{{ trans('core/base::base.select_image') }}</strong>
                {{ trans('core/base::base.to_add_more_image') }}.
            </p>
        </div>
        <input
            name="{{ $name }}"
            type="hidden"
        >
        <ul
            class="list-unstyled list-gallery-media-images @if (empty($images)) hidden @endif"
            data-name="{{ $name }}"
            data-allow-thumb="{{ $allowThumb }}"
        >
            @if (!empty($images))
                @foreach ($images as $image)
                    @if (!empty($image))
                        <li class="gallery-image-item-handler">
                            <div class="list-photo-hover-overlay">
                                <ul class="photo-overlay-actions">
                                    <li>
                                        <a
                                            class="mr10 btn-trigger-edit-gallery-image"
                                            data-bs-toggle="tooltip"
                                            data-placement="bottom"
                                            data-bs-original-title="{{ trans('core/base::base.change_image') }}"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            class="mr10 btn-trigger-remove-gallery-image"
                                            data-bs-toggle="tooltip"
                                            data-placement="bottom"
                                            data-bs-original-title="{{ trans('core/base::base.delete_image') }}"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="custom-image-box image-box">
                                <input
                                    class="image-data"
                                    name="{{ $name }}"
                                    type="hidden"
                                    value="{{ $image }}"
                                >
                                <div
                                    class="preview-image-wrapper @if (!$allowThumb) preview-image-wrapper-not-allow-thumb @endif">
                                    <img
                                        class="preview_image"
                                        src="{{ RvMedia::getImageUrl($image, $allowThumb ? 'thumb' : null) }}"
                                        alt="{{ trans('core/base::base.preview_image') }}"
                                    >
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
    <a
        class="add-new-gallery-image js-btn-trigger-add-image"
        data-name="{{ $name }}"
        href="#"
    >{{ trans('core/base::base.add_image') }}
    </a>
</div>
