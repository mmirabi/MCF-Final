<div class="image-box attachment-wrapper">
    <input
        class="attachment-url"
        name="{{ $name }}"
        type="hidden"
        value="{{ $value }}"
    >
    @if (!is_in_admin(true) || !auth()->guard()->check())
        <input
            class="media-file-input"
            type="file"
            style="display: none;"
            @if ($name) name="{{ $name }}_input" @endif
        >
    @endif
    <div class="attachment-details">
        <a
            href="{{ $url ?? $value }}"
            target="_blank"
        >{{ $value }}</a>
    </div>
    <div class="image-box-actions">
        <a
            class="@if (is_in_admin(true) && auth()->guard()->check()) btn_gallery @else media-select-file @endif"
            data-result="{{ $name }}"
            data-action="{{ $attributes['action'] ?? 'attachment' }}"
            href="#"
        >
            {{ trans('core/base::forms.choose_file') }}
        </a> |
        <a
            class="text-danger btn_remove_attachment"
            href="#"
        >
            {{ trans('core/base::forms.remove_file') }}
        </a>
    </div>
</div>
