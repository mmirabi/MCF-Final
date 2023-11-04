@php
    $prefix = apply_filters(FILTER_SLUG_PREFIX, $prefix);
    $value = $value ?: old('slug');
    $endingURL = SlugHelper::getPublicSingleEndingURL();
    $previewURL = str_replace('--slug--', (string) $value, url($prefix) . '/' . config('packages.slug.general.pattern')) . $endingURL . (Auth::user() && $preview ? '?preview=true' : '');
@endphp

<div
    id="edit-slug-box"
    data-field-name="{{ SlugHelper::getColumnNameToGenerateSlug($model) }}"
    @class(['hidden' => empty($value) && !$errors->has($name)])
>
    @if (in_array(Route::currentRouteName(), ['pages.create', 'pages.edit']) &&
            BaseHelper::isHomepage(Route::current()->parameter('page.id')))
        <label
            class="control-label me-1"
            for="current-slug"
        >{{ trans('core/base::forms.permalink') }}</label>
        <span
            class="d-inline-block"
            id="sample-permalink"
            dir="ltr"
        >
            : <a
                class="permalink"
                href="{{ route('public.index') }}"
                target="_blank"
            >
                <span class="default-slug">{{ route('public.index') }}</span>
            </a>
        </span>
    @else
        <label
            for="current-slug"
            @class(['control-label me-1', 'required' => $editable])
        >{{ trans('core/base::forms.permalink') }}</label>
        <span
            class="d-inline-block"
            id="sample-permalink"
            dir="ltr"
        >
            : <a
                class="permalink"
                href="{{ $previewURL }}"
                target="_blank"
            >
                <span class="default-slug">{{ url($prefix) }}/<span
                        id="editable-post-name">{{ $value }}</span>{{ $endingURL }}</span>
            </a>
        </span>
        @if ($editable)
            <span id="edit-slug-buttons">
                <button
                    class="btn btn-secondary ms-1"
                    id="change_slug"
                    type="button"
                >{{ trans('core/base::forms.edit') }}</button>
                <button
                    class="save btn btn-secondary ms-1"
                    id="btn-ok"
                    type="button"
                >{{ trans('core/base::forms.ok') }}</button>
                <button
                    class="cancel button-link ms-1"
                    type="button"
                >{{ trans('core/base::forms.cancel') }}</button>
                @if (Auth::user() && $preview && $id)
                    <a
                        class="btn btn-info btn-preview"
                        href="{{ $previewURL }}"
                        target="_blank"
                    >{{ trans('packages/slug::slug.preview') }}</a>
                @endif
            </span>

            <input
                id="current-slug"
                name="{{ $name }}"
                type="hidden"
                value="{{ $value }}"
            >
            <div
                id="slug_id"
                data-url="{{ route('slug.create') }}"
                data-view="{{ rtrim(str_replace('--slug--', '', url($prefix) . '/' . config('packages.slug.general.pattern')), '/') . '/' }}"
                data-id="{{ $id ?: 0 }}"
            ></div>
            <input
                name="slug_id"
                type="hidden"
                value="{{ $id ?: 0 }}"
            >
            <input
                name="is_slug_editable"
                type="hidden"
                value="1"
            >
        @endif
    @endif
</div>
