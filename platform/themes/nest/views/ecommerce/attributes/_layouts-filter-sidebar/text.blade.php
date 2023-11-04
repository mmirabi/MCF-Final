<div class="sidebar-widget mb-30">
    <h5 class="section-title style-1 mb-30" data-title="{{ $set->title }}" >{{ __('By :name', ['name' => $set->title]) }}</h5>
    <ul class="list-filter">
        @foreach($attributes->where('attribute_set_id', $set->id) as $attribute)
            <li data-slug="{{ $attribute->slug }}">
                <div class="tags-checkbox">
                    <label>
                        <input class="product-filter-item" type="checkbox" name="attributes[{{ $set->slug }}][]" value="{{ $attribute->id }}" {{ in_array($attribute->id, $selected) ? 'checked' : '' }}>
                        <span><i class="fi-rs- mr-10"></i> {{ $attribute->title }}</span>
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
</div>
