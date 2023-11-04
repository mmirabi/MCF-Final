<div class="float-start">
    <a
        class="btn btn-info"
        data-fancybox
        data-type="ajax"
        data-src="{{ route('simple-slider-item.create') }}?simple_slider_id={{ BaseHelper::stringify(request()->route('simple_slider')->id) }}"
        href="javascript:void(0);"
    ><i class="fa fa-plus-circle"></i> {{ trans('plugins/simple-slider::simple-slider.add_new') }}</a>
    <button
        class="btn-success btn btn-save-sort-order"
        style="display: none;"
    ><i class="fa fa-save"></i> {{ trans('plugins/simple-slider::simple-slider.save_sorting') }}</button>
</div>
<div class="clearfix"></div>
<br>

@include('core/table::simple-table')
