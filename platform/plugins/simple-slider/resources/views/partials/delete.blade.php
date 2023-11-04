<div class="modal-box-container">
    <form
        class="form-xs"
        action="{{ route('simple-slider-item.destroy', $slider->id) }}"
        method="post"
    >
        @csrf
        @method('DELETE')
        <div class="modal-title">
            <i class="til_img"></i> <strong>{{ trans('core/base::tables.confirm_delete') }}</strong>
        </div>
        <div class="modal-body">
            <div class="form-body">
                <p>
                    {{ trans('core/base::tables.confirm_delete_msg') }}
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <a
                class="btn btn-primary"
                data-fancybox-close
                href="javascript:;"
            >{{ trans('core/base::tables.cancel') }}</a>
            <button
                class="btn btn-info btn-delete-slider"
                type="submit"
            >{{ trans('core/base::tables.delete') }}</button>
        </div>
    </form>
</div>
