<ul {!! $options !!}>
    @php $menu_nodes->loadMissing('metadata'); @endphp
    @foreach ($menu_nodes as $key => $row)
        <li @if ($row->css_class) class="{{ $row->css_class }}" @endif>
            <a href="{{ url($row->url) }}" @if ($row->active) class="active" @endif target="{{ $row->target }}">
                @if ($iconImage = $row->getMetaData('icon_image', true))
                    <img src="{{ RvMedia::getImageUrl($iconImage) }}" alt="icon image" width="15" height="15" style="vertical-align: top; margin-top: 2px"/>
                @elseif ($row->icon_font)<i class="menu-icon {{ trim($row->icon_font) }}"></i>&nbsp;@endif{!! BaseHelper::clean($row->title) !!}
                @if ($row->has_child)
                    @if ($row->parent_id) <i class="fi-rs-angle-right"></i> @else <i class="fi-rs-angle-down"></i> @endif
                @endif
            </a>
            @if ($row->has_child)
                {!!
                    Menu::generateMenu([
                        'menu'       => $menu,
                        'view'       => 'main-menu',
                        'options'    => ['class' => $row->parent_id ? 'level-menu level-menu-modify' : 'sub-menu'],
                        'menu_nodes' => $row->child,
                    ])
                !!}
            @endif
        </li>
    @endforeach
</ul>
