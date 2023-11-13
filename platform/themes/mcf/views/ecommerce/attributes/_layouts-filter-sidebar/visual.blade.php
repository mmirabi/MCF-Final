<div class="sidebar-widget mb-30">
    <h5 class="section-title style-1 mb-30" data-title="{{ $set->title }}">{{ __('By :name', ['name' => $set->title]) }}</h5>
    <ul class="list-filter">
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
