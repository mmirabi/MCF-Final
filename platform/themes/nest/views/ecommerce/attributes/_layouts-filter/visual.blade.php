<div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2 widget-filter-item" data-type="visual">
    <div class="card">
        <h5 class="mb-30 widget__title" data-title="{{ $set->title }}">{{ __('By :name', ['name' => $set->title]) }}</h5>
        <ul class="list-filter ps-custom-scrollbar">
            @foreach($attributes->where('attribute_set_id', $set->id) as $attribute)
                <li data-slug="{{ $attribute->slug }}"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="{{ $attribute->title }}"
                    class="mx-1">
                    <div class="custom-checkbox">
                        <label>
                            <input class="form-control product-filter-item" type="checkbox" name="attributes[{{ $set->slug }}][]" value="{{ $attribute->id }}" {{ in_array($attribute->id, $selected) ? 'checked' : '' }}>
			    <span style="{{ $attribute->getAttributeStyle() }}"></span>
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
