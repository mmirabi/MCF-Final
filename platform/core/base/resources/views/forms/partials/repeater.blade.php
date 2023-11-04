@php
    Assets::addScriptsDirectly('vendor/core/core/base/js/repeater-field.js');
    
    $values = array_values(is_array($value) ? $value : (array) json_decode($value ?: '[]', true));
    
    $added = [];
    
    if (count($values) > 0) {
        for ($i = 0; $i < count($values); $i++) {
            $group = '';
            foreach ($fields as $key => $field) {
                $item = Form::hidden($name . '[' . $i . '][' . $key . '][key]', $field['attributes']['name']);
                $field['attributes']['name'] = $name . '[' . $i . '][' . $key . '][value]';
                $field['attributes']['value'] = Arr::get($values, $i . '.' . $key . '.value');
                $field['attributes']['options']['id'] = $id = 'repeater_field_' . md5($field['attributes']['name']);
                Arr::set($field, 'attributes.id', $id);
                Arr::set($field, 'label_attr.for', $id);
                $item .= Form::customLabel(Arr::get($field, 'attr.name'), $field['label'], Arr::get($field, 'label_attr')) . call_user_func_array([Form::class, $field['type']], array_values($field['attributes']));
    
                $group .= '<div class="form-group mb-3">' . $item . '</div>';
            }
    
            $added[] = '<div class="repeater-item-group form-group mb-3">' . $group . '</div>';
        }
    }
    
    $group = '';
    
    foreach ($fields as $key => $field) {
        $item = Form::hidden($name . '[__key__][' . $key . '][key]', $field['attributes']['name']);
        $field['attributes']['name'] = $name . '[__key__][' . $key . '][value]';
        $field['attributes']['options']['id'] = 'repeater_field_' . md5($field['attributes']['name']) . '__key__';
        Arr::set($field, 'label_attr.for', $field['attributes']['options']['id']);
        $item .= Form::customLabel(Arr::get($field, 'attr.name'), $field['label'], Arr::get($field, 'label_attr')) . call_user_func_array([Form::class, $field['type']], array_values($field['attributes']));
        $group .= '<div class="form-group mb-3">' . $item . '</div>';
    }
    
    $defaultFields = ['<div class="repeater-item-group form-group mb-3">' . $group . '</div>'];
    
    $repeaterId = 'repeater_field_' . md5($name) . '_' . uniqid();
@endphp

<input
    name="{{ $name }}"
    type="hidden"
    value="[]"
>

<div
    class="repeater-group"
    id="{{ $repeaterId }}_group"
    data-next-index="{{ count($added) }}"
>
    @foreach ($added as $field)
        <div
            class="form-group mb-3"
            data-id="{{ $repeaterId }}_{{ $loop->index }}"
            data-index="{{ $loop->index }}"
        >
            <div>{!! $field !!}</div>

            <label
                class="remove-item-button"
                data-target="repeater-remove"
                data-id="{{ $repeaterId }}_{{ $loop->index }}"
                type="button"
            ><i class="fa fa-times"></i></label>
        </div>
    @endforeach
</div>

<button
    class="btn btn-info"
    data-target="repeater-add"
    data-id="{{ $repeaterId }}"
    type="button"
>
    {{ __('Add new') }}
</button>

<script type="text/x-custom-template" id="{{ $repeaterId }}_template">
    @foreach($defaultFields as $defaultFieldIndex => $defaultField)
        <div class="form-group mb-3" data-id="{{ $repeaterId }}___key__" data-index="__key__">
            <div data-target="fields">__fields__</div>

            <label
                class="remove-item-button"
                type="button"
                data-target="repeater-remove"
                data-id="{{ $repeaterId }}___key__"
            ><i class="fa fa-times"></i></label>
        </div>
    @endforeach
</script>

<script type="text/x-custom-template" id="{{ $repeaterId }}_fields">
    {{ $defaultField }}
</script>
