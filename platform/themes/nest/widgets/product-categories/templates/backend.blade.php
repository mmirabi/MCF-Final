<div class="form-group">
    <label for="widget-name">{{ __('Name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>

<div class="form-group">
    <label for="number_display">{{ __('Number categories to display') }}</label>
    <input type="number" class="form-control" name="number_display" value="{{ $config['number_display'] }}">
</div>

<div class="form-group product-categories-select">
    <div class="multi-choices-widget list-item-checkbox">
        <ul>
            @foreach ($categories as $category)
                <li>
                    <label>
                        <input
                            name="categories[]"
                            type="checkbox"
                            value="{{ $category->id }}"
                            @if (in_array($category->id, $config['categories'])) checked="checked" @endif
                        >
                        {{ $category->name }}
                    </label>
                    @if ($category->activeChildren->isNotEmpty())
                        <ul style="padding-left: 20px">
                            @foreach ($category->activeChildren as $child)
                                <li>
                                    <label>
                                        <input
                                            name="categories[]"
                                            type="checkbox"
                                            value="{{ $child->id }}"
                                            @if (in_array($child->id, $config['categories'])) checked="checked" @endif
                                        >
                                        {{ $child->name }}
                                    </label>
                                    @if ($child->activeChildren->isNotEmpty())
                                        <ul style="padding-left: 20px">
                                            @foreach ($child->activeChildren as $item)
                                                <li>
                                                    <label>
                                                        <input
                                                            name="categories[]"
                                                            type="checkbox"
                                                            value="{{ $item->id }}"
                                                            @if (in_array($item->id, $config['categories'])) checked="checked" @endif
                                                        >
                                                        {{ $item->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>
    .product-categories-select .list-item-checkbox {
        background: #f1f1f1;
        margin-bottom: 20px;
        padding-left: 15px !important;
    }

    .product-categories-select .list-item-checkbox ul {
        min-height: 0 !important;
    }

    .product-categories-select .list-item-checkbox li:last-child {
        margin-bottom: 0 !important;
    }

    .product-categories-select .list-item-checkbox input[type=checkbox] {
        margin-left: 2px;
    }
</style>
