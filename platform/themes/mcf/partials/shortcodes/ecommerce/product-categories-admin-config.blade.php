<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="Title">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Scroll display items') }}</label>
    {!! Form::customSelect('scroll_items', array_combine([6, 7, 8, 9, 10], [6, 7, 8, 9, 10]), Arr::get($attributes, 'scroll_items', 8)) !!}
</div>

{!! Theme::partial('shortcodes.includes.autoplay-settings', compact('attributes')) !!}

<div class="form-group">
    <label class="control-label">{{ __('Selected categories (uncheck to show all)') }}</label>
    <ul class="mt-2">
        @foreach (ProductCategoryHelper::getActiveTreeCategories() as $category)
            <li>
                <label>
                    <input type="checkbox"
                           name="categories[]"
                           value="{{ $category->id }}"
                           @if (in_array($category->id, $categoryIds)) checked="checked" @endif>
                    {!! BaseHelper::clean($category->name) !!}
                </label>
                @if ($category->activeChildren->isNotEmpty())
                    <ul style="padding-left: 20px">
                        @foreach ($category->activeChildren as $child)
                            <li>
                                <label>
                                    <input type="checkbox"
                                           name="categories[]"
                                           value="{{ $child->id }}"
                                           @if (in_array($child->id, $categoryIds)) checked="checked" @endif>
                                    {{ $child->name }}
                                </label>
                                @if ($child->activeChildren->isNotEmpty())
                                    <ul style="padding-left: 20px">
                                        @foreach ($child->activeChildren as $item)
                                            <li>
                                                <label>
                                                    <input type="checkbox"
                                                           name="categories[]"
                                                           value="{{ $item->id }}"
                                                           @if (in_array($item->id, $categoryIds)) checked="checked" @endif>
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
