@php
    if (!isset($groupedCategories)) {
        $groupedCategories = $categories->groupBy('parent_id');
    }
    
    $currentCategories = $groupedCategories->get($parentId = $parentId ?? 0);
@endphp

@if ($currentCategories)
    <ul class="{{ $className ?? '' }}">
        @foreach ($currentCategories as $category)
            @php
                $hasChildren = $groupedCategories->has($category->id);
            @endphp
            <li
                class="folder-root open"
                data-id="{{ $category->id }}"
            >
                <a
                    class="fetch-data category-name"
                    href="{{ $canEdit && $editRoute ? route($editRoute, $category->id) : '' }}"
                >
                    @if ($hasChildren)
                        <i class="far fa-folder"></i>
                    @else
                        <i class="far fa-file"></i>
                    @endif

                    <span>{{ $category->name }}</span>
                    @if ($category->badge_with_count)
                        {!! $category->badge_with_count !!}
                    @endif
                </a>
                @if ($category->url)
                    <a
                        class="text-info"
                        data-bs-toggle="tooltip"
                        data-bs-original-title="{{ trans('core/base::forms.view_new_tab') }}"
                        href="{{ $category->url }}"
                        target="_blank"
                    >
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                @endif
                @if ($canDelete)
                    <a
                        class="btn btn-icon btn-danger deleteDialog"
                        data-section="{{ route($deleteRoute, $category->id) }}"
                        data-bs-toggle="tooltip"
                        data-bs-original-title="{{ trans('core/table::table.delete') }}"
                        href="#"
                        role="button"
                    >
                        <i class="fa fa-trash"></i>
                    </a>
                @endif
                @if ($hasChildren)
                    <i class="far fa-minus-square file-opener-i"></i>

                    @include('core/base::forms.partials.tree-category', [
                        'groupedCategories' => $groupedCategories,
                        'parentId' => $category->id,
                        'className' => '',
                    ])
                @endif
            </li>
        @endforeach
    </ul>
@endif
