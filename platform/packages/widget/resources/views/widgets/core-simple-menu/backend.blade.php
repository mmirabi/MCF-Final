<div class="form-group mb-3">
    <label for="widget-name">{{ trans('core/base::forms.name') }}</label>
    <input
        class="form-control"
        name="name"
        type="text"
        value="{{ $config['name'] }}"
    >
</div>
<div class="form-group mb-3">

    <label for="content">{{ trans('core/base::forms.content') }}</label>

    {!! Form::repeater('items', $config['items'], $fields) !!}
</div>
