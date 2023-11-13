<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input
        class="form-control"
        name="title"
        type="text"
        value="{{ Arr::get($attributes, 'title') }}"
        placeholder="{{ __('Title') }}"
    >
</div>

<div class="form-group">
    <label class="control-label">{{ __('Stores') }}</label>
    <input name="stores" class="form-control list-tagify" data-list="{{ json_encode($stores) }}" value="{{ Arr::get($attributes, 'stores') }}" placeholder="{{ __('Select stores from the list') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Layout') }}</label>
    <div class="ui-select-wrapper form-group">
        <select
            class="form-control ui-select"
            name="layout"
        >
            @foreach (get_store_list_layouts() as $key => $layout)
                <option
                    value="{{ $key }}"
                    @if ($key == Arr::get($attributes, 'layout')) selected @endif
                >{{ $layout }}</option>
            @endforeach
        </select>
        <svg class="svg-next-icon svg-next-icon-size-16">
            <use
                xmlns:xlink="http://www.w3.org/1999/xlink"
                xlink:href="#select-chevron"
            ></use>
        </svg>
    </div>
</div>
