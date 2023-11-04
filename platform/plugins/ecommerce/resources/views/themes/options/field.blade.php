<div
    class="form-group mb-3 option-field product-option-{{ Str::slug($option->name) }} product-option-{{ $option->id }}"
    style="margin-bottom: 10px"
>
    <div class="product-option-item-wrapper">
        <div class="product-option-item-label">
            <label class="{{ $option->required ? 'required' : '' }}">
                {{ $option->name }}
            </label>
        </div>
        <div class="product-option-item-values">
            <div class="form-radio">
                @foreach ($option->values as $value)
                    <input
                        name="options[{{ $option->id }}][option_type]"
                        type="hidden"
                        value="field"
                    />
                    <input
                        class="form-control"
                        id="option-{{ $option->id }}-value-{{ Str::slug($option->values[0]['option_value']) }}"
                        name="options[{{ $option->id }}][values]"
                        data-extra-price="0"
                        type="text"
                        {{ $option->required ? 'required' : '' }}
                    >
                @endforeach
            </div>
        </div>
    </div>
</div>
