<div class="sidebar-widget mb-30">
    <h5 class="section-title style-1 mb-30">{{ __('By :name', ['name' => $set->title]) }}</h5>
    <div class="list-filter">
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
