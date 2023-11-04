<tr data-locale="{{ $item['locale'] }}">
    <td class="text-start">
        <span>{{ $item['name'] }}</span>
    </td>
    <td class="text-center">{{ $item['locale'] }}</td>
    <td class="text-center">
        {{ $item['locale'] == app()->getLocale() ? trans('core/base::base.yes') : trans('core/base::base.no') }}</td>
    <td class="text-center">
        <span>
            @if ($item['locale'] != 'en')
                <a
                    class="delete-locale-button text-danger"
                    data-bs-toggle="tooltip"
                    data-url="{{ route('translations.locales.delete', $item['locale']) }}"
                    data-bs-original-title="{{ trans('plugins/translation::translation.delete') }}"
                    href="#"
                    role="button"
                ><i class="icon icon-trash"></i></a>
            @else
                &mdash;
            @endif

            &nbsp;<a
                class="download-locale-button"
                data-bs-toggle="tooltip"
                data-bs-original-title="{{ trans('plugins/translation::translation.download') }}"
                href="{{ route('translations.locales.download', $item['locale']) }}"
                role="button"
            ><i class="icon icon-download"></i></a>
        </span>
    </td>
</tr>
