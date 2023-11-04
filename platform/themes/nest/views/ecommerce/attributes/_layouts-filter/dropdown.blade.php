<div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2 widget-filter-item" data-type="dropdown">
    <div class="card">
        <div class="dropdown-swatches-wrapper widget-filter-item">
            <h4 class="widget__title">{{ __('By :name', ['name' => $set->title]) }}</h4>
            <div class="widget-content ps-custom-scrollbar">
                <div class="attribute-values">
                    <div class="dropdown-swatch">
                        <label>
                            <select class="form-select product-filter-item" name="attributes[{{ $set->slug }}][]">
                                <option value="">{{ __('-- Select --') }}</option>
                                @foreach($attributes->where('attribute_set_id', $set->id) as $attribute)
                                    <option value="{{ $attribute->id }}" {{ in_array($attribute->id, $selected) ? 'selected' : '' }}>{{ $attribute->title }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
