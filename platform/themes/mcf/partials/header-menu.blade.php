<ul {!! $options !!}>
    @php $menu_nodes->loadMissing('metadata'); @endphp
    @foreach ($menu_nodes as $key => $row)
        <li @if ($row->css_class || $row->active) class="@if ($row->css_class) {{ $row->css_class }} @endif @if ($row->active) current @endif" @endif>
            <a href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif title="{{ $row->title }}">
                @if ($iconImage = $row->getMetaData('icon_image', true))
                    <img src="{{ RvMedia::getImageUrl($iconImage) }}" alt="icon image" width="15" height="15" style="vertical-align: top; margin-top: -1px"/>
                @elseif ($row->icon_font)<i class="menu-icon {{ trim($row->icon_font) }}"></i> @endif
                <span>{!! BaseHelper::clean($row->title) !!}</span>
            </a>
            @if ($row->has_child)
                {!! Menu::generateMenu([
                    'menu'       => $menu,
                    'menu_nodes' => $row->child
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
