<div class="form-group mb-3">
    <label class="control-label">{{ trans('plugins/blog::base.number_posts_per_page') }}</label>
    {!! Form::number('paginate', Arr::get($attributes, 'paginate', 12), [
        'class' => 'form-control',
        'placeholder' => trans('plugins/blog::base.number_posts_per_page'),
    ]) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Select categories') }}</label>
    <select class="select-full" name="category_ids[]" multiple>
        @include('core/base::forms.partials.nested-select-option', [
             'options' => $categories,
             'indent' => null,
             'selected' => array_filter(explode(',', Arr::get($attributes, 'category_ids'))),
         ])
    </select>
    {{ Form::helper(__('Leave categories empty if you want to show posts from all categories.')) }}
</div>
