<div class="form-group">
    <label class="control-label">{{ __('Product category') }}</label>
    <div class="ui-select-wrapper form-group">
        <select name="category_id" class="ui-select">
            {!! ProductCategoryHelper::renderProductCategoriesSelect(Arr::get($attributes, 'category_id')) !!}
        </select>
        <svg class="svg-next-icon svg-next-icon-size-16">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
            >
                <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
            </svg>
        </svg>
    </div>
</div>

<div class="form-group">
    <label class="control-label">{{ __('Number of products per row') }}</label>
    {!! Form::customSelect('per_row', array_combine([2, 3, 4, 5, 6], [2, 3, 4, 5, 6]), Arr::get($attributes, 'per_row', 4)) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Total display products') }}</label>
    <input type="number" name="limit" value="{{ Arr::get($attributes, 'limit', 8) }}" class="form-control" placeholder="{{ __('Limit') }}">
</div>
