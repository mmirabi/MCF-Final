@foreach(!$more ? $categories->take(10)->chunk(5) : $categories->skip(10)->chunk(ceil((count($categories) - 10) / 2)) as $chunk)
    <ul @if ($loop->last) class="end" @endif>
        @foreach($chunk as $category)
            <li>
                <a href="{{ route('public.single', $category->url) }}">
                    @if ($categoryImage = $category->icon_image)
                        <img src="{{ RvMedia::getImageUrl($categoryImage) }}" alt="{{ $category->name }}" width="30" height="30">
                    @elseif ($categoryIcon = $category->icon)
                        <i class="{{ $categoryIcon }}"></i>
                    @endif {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endforeach
