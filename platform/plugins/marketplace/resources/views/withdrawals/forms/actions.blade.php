<div class="widget meta-boxes form-actions form-actions-default action-{{ $direction ?? 'horizontal' }}">
    <div class="widget-title">
        <h4>
            <span>{{ trans('core/base::forms.publish') }}</span>
        </h4>
    </div>
    <div class="widget-body">
        <div class="btn-set">
            <button
                class="btn btn-info"
                name="submit"
                type="submit"
                value="save"
            >
                <i class="{{ $saveIcon ?? 'fas fa-money-bill' }}"></i> {{ $saveTitle ?? __('Request') }}
            </button>
        </div>
    </div>
</div>
<div id="waypoint"></div>
<div class="form-actions form-actions-fixed-top hidden">
    <div class="btn-set">
        <button
            class="btn btn-info"
            name="submit"
            type="submit"
            value="save"
        >
            <i class="{{ $saveIcon ?? 'fas fa-money-bill' }}"></i> {{ $saveTitle ?? __('Request') }}
        </button>
    </div>
</div>
