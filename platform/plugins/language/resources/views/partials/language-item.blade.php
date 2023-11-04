<tr data-id="{{ $item->lang_id }}">
    <td class="text-start">
        <a
            class="edit-language-button"
            data-bs-original-title="{{ trans('plugins/language::language.edit_tooltip') }}"
            data-bs-toggle="tooltip"
            data-id="{{ $item->lang_id }}"
            href="#"
        >{{ $item->lang_name }}</a>
    </td>
    <td class="text-center">{{ $item->lang_locale }}</td>
    <td class="text-center">{{ $item->lang_code }}</td>
    <td class="text-center">
        @if ($item->lang_is_default)
            <i
                class="fa fa-star"
                data-id="{{ $item->lang_id }}"
                data-name="{{ $item->lang_name }}"
            ></i>
        @else
            <a
                class="set-language-default"
                data-section="{{ route('languages.set.default') }}?lang_id={{ $item->lang_id }}"
                data-bs-toggle="tooltip"
                data-bs-original-title="{{ trans('plugins/language::language.choose_default_language', ['language' => $item->lang_name]) }}"
            ><i
                    class="fa fa-star"
                    data-id="{{ $item->lang_id }}"
                    data-name="{{ $item->lang_name }}"
                ></i></a>
        @endif
    </td>
    <td class="text-center">{{ $item->lang_order }}</td>
    <td class="text-center">
        {!! language_flag($item->lang_flag, $item->lang_name) !!}
    </td>
    <td class="text-center">
        <span>
            <a
                class="edit-language-button"
                data-bs-original-title="{{ trans('plugins/language::language.edit_tooltip') }}"
                data-bs-toggle="tooltip"
                data-id="{{ $item->lang_id }}"
                href="#"
            >{{ trans('plugins/language::language.edit') }}</a> |
        </span>
        <span>
            <a
                class="deleteDialog text-danger"
                data-bs-toggle="tooltip"
                data-section="{{ route('languages.destroy', $item->lang_id) }}"
                data-bs-original-title="{{ trans('plugins/language::language.delete_tooltip') }}"
                href="#"
                role="button"
            >{{ trans('plugins/language::language.delete') }}</a>
        </span>
    </td>
</tr>
