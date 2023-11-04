@php
    $categoriesRequest ??= [];
    $activeCategoryId ??= 0;

    if (!isset($groupedCategories)) {
        $groupedCategories = $categories->groupBy('parent_id');
    }

    $currentCategories = $groupedCategories->get($parentId ?? 0);
@endphp

@if($currentCategories)
    @foreach ($currentCategories as $category)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $categoriesRequest)) id="category-filter-{{ $category->id }}">
            <label class="form-check-label" for="category-filter-{{ $category->id }}">
                {{ $category->name }}
            </label>

            @if ($groupedCategories->has($category->id))
                @include(Theme::getThemeNamespace('views.ecommerce.includes.categories'), [
                    'categories' => $groupedCategories,
                    'parentId' => $category->id,
                ])
            @endif
        </div>
    @endforeach
@endif
