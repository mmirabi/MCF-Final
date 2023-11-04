<div
    class="tab-pane"
    id="tab_tax_info"
>
    <div class="form-group">
        <div class="ps-form__content">
            <div class="form-group">
                <label for="tax_info_business_name">{{ __('Business Name') }}:</label>
                <input
                    class="form-control"
                    id="tax_info_business_name"
                    name="tax_info[business_name]"
                    type="text"
                    value="{{ Arr::get($model->tax_info, 'business_name') }}"
                    placeholder="{{ __('Business Name') }}"
                >
            </div>
            {!! Form::error('tax_info[business_name]', $errors) !!}

            <div class="form-group">
                <label for="tax_info_tax_id">{{ __('Tax ID') }}:</label>
                <input
                    class="form-control"
                    id="tax_info_tax_id"
                    name="tax_info[tax_id]"
                    type="text"
                    value="{{ Arr::get($model->tax_info, 'tax_id') }}"
                    placeholder="{{ __('Tax ID') }}"
                >
            </div>
            {!! Form::error('tax_info[tax_id]', $errors) !!}

            <div class="form-group">
                <label for="tax_info_address">{{ __('Address') }}:</label>
                <input
                    class="form-control"
                    id="tax_info_address"
                    name="tax_info[address]"
                    type="text"
                    value="{{ Arr::get($model->tax_info, 'address') }}"
                    placeholder="{{ __('Address') }}"
                >
            </div>
            {!! Form::error('tax_info[address]', $errors) !!}

        </div>
    </div>
</div>
