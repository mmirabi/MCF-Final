<div class="wrapper-filter">
    <p>{{ trans('core/table::table.filters') }}</p>

    <input
        class="filter-data-url"
        type="hidden"
        value="{{ isset($table) ? $table->getFilterInputUrl() : route('tables.get-filter-input') }}"
    >

    <div class="sample-filter-item-wrap hidden">
        <div class="filter-item form-filter">
            {!! Form::customSelect(
                'filter_columns[]',
                array_combine(array_keys($columns), array_column($columns, 'title')),
                null,
                ['class' => 'filter-column-key', 'wrapper_class' => 'mb-0'],
            ) !!}

            {!! Form::customSelect(
                'filter_operators[]',
                [
                    'like' => trans('core/table::table.contains'),
                    '=' => trans('core/table::table.is_equal_to'),
                    '>' => trans('core/table::table.greater_than'),
                    '<' => trans('core/table::table.less_than'),
                ],
                null,
                ['class' => 'filter-operator filter-column-operator', 'wrapper_class' => 'mb-0'],
            ) !!}
            <span class="filter-column-value-wrap">
                <input
                    class="form-control filter-column-value"
                    name="filter_values[]"
                    type="text"
                    placeholder="{{ trans('core/table::table.value') }}"
                >
            </span>
            <span
                class="btn-remove-filter-item"
                title="{{ trans('core/table::table.delete') }}"
            >
                <i class="fa fa-trash text-danger"></i>
            </span>
        </div>
    </div>

    {{ Form::open(['method' => 'GET', 'class' => 'filter-form']) }}
    <input
        class="filter-data-table-id"
        name="filter_table_id"
        type="hidden"
        value="{{ $tableId }}"
    >
    <input
        class="filter-data-class"
        name="class"
        type="hidden"
        value="{{ $class }}"
    >
    <div class="filter_list inline-block filter-items-wrap">
        @foreach ($requestFilters as $filterItem)
            <div class="filter-item form-filter @if ($loop->first) filter-item-default @endif">
                {!! Form::customSelect(
                    'filter_columns[]',
                    ['' => trans('core/table::table.select_field')] +
                        array_combine(array_keys($columns), array_column($columns, 'title')),
                    $filterItem['column'],
                    ['class' => 'filter-column-key', 'wrapper_class' => 'mb-0'],
                ) !!}

                {!! Form::customSelect(
                    'filter_operators[]',
                    [
                        'like' => trans('core/table::table.contains'),
                        '=' => trans('core/table::table.is_equal_to'),
                        '>' => trans('core/table::table.greater_than'),
                        '<' => trans('core/table::table.less_than'),
                    ],
                    $filterItem['operator'],
                    ['class' => 'filter-operator filter-column-operator', 'wrapper_class' => 'mb-0'],
                ) !!}
                <span class="filter-column-value-wrap">
                    <input
                        class="form-control filter-column-value"
                        name="filter_values[]"
                        type="text"
                        value="{{ $filterItem['value'] }}"
                        placeholder="{{ trans('core/table::table.value') }}"
                    >
                </span>
                @if ($loop->first)
                    <span
                        class="btn-reset-filter-item"
                        title="{{ trans('core/table::table.reset') }}"
                    >
                        <i
                            class="fa fa-eraser text-info"
                            style="font-size: 13px;"
                        ></i>
                    </span>
                @else
                    <span
                        class="btn-remove-filter-item"
                        title="{{ trans('core/table::table.delete') }}"
                    >
                        <i class="fa fa-trash text-danger"></i>
                    </span>
                @endif
            </div>
        @endforeach
    </div>
    <div style="margin-top: 10px;">
        <a
            class="btn btn-secondary add-more-filter"
            href="javascript:;"
        >{{ trans('core/table::table.add_additional_filter') }}</a>
        <a
            class="btn btn-info @if (!request()->has('filter_table_id')) hidden @endif"
            href="{{ URL::current() }}"
        >{{ trans('core/table::table.reset') }}</a>
        <button
            class="btn btn-primary btn-apply"
            type="submit"
        >{{ trans('core/table::table.apply') }}</button>
    </div>

    {{ Form::close() }}
</div>
