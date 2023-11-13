<div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2 widget-filter-item" data-type="text">
    <div class="card">
        <h5 class="mb-30 widget__title" data-title="{{ $set->title }}" >{{ __('By :name', ['name' => $set->title]) }}</h5>
        <div class="sidebar-widget">
            <div class="list-filter size-filter ps-custom-scrollbar">
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
            </div>
        </div>
    </div>
</div>
