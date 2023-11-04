<div class="dropdown dropdown-hover">
    <a href="javascript:;">{{ trans('core/table::table.bulk_change') }}
        <i class="fa fa-angle-right"></i>
    </a>
    <div class="dropdown-content">
        @foreach ($bulk_changes as $key => $bulk_change)
            <a
                class="bulk-change-item"
                data-key="{{ $key }}"
                data-class-item="{{ $class }}"
                data-save-url="{{ $url }}"
                href="#"
            >{{ $bulk_change['title'] }}</a>
        @endforeach
    </div>
</div>
