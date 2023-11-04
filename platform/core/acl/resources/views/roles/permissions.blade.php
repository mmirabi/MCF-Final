<ul
    class="list-unstyled list-feature"
    id='auto-checkboxes'
    data-name='foo'
>
    <li id="mainNode">
        <input
            id="expandCollapseAllTree"
            type="checkbox"
        >&nbsp;&nbsp;
        <label
            class="label label-default allTree"
            for="expandCollapseAllTree"
        >{{ trans('core/acl::permissions.all') }}</label>
        <ul>
            @foreach ($children['root'] as $elementKey => $element)
                <li
                    class="collapsed"
                    id="node{{ $elementKey }}"
                >
                    <input
                        id="checkSelect{{ $elementKey }}"
                        name="flags[]"
                        type="checkbox"
                        value="{{ $flags[$element]['flag'] }}"
                        @if (in_array($flags[$element]['flag'], $active)) checked @endif
                    >
                    <label
                        class="label label-warning"
                        for="checkSelect{{ $elementKey }}"
                        style="margin: 5px;"
                    >{{ $flags[$element]['name'] }}</label>
                    @if (isset($children[$element]))
                        <ul>
                            @foreach ($children[$element] as $subKey => $subElements)
                                <li
                                    class="collapsed"
                                    id="node_sub_{{ $elementKey }}_{{ $subKey }}"
                                >
                                    <input
                                        id="checkSelect_sub_{{ $elementKey }}_{{ $subKey }}"
                                        name="flags[]"
                                        type="checkbox"
                                        value="{{ $flags[$subElements]['flag'] }}"
                                        @if (in_array($flags[$subElements]['flag'], $active)) checked @endif
                                    >
                                    <label
                                        class="label label-primary nameMargin"
                                        for="checkSelect_sub_{{ $elementKey }}_{{ $subKey }}"
                                    >{{ $flags[$subElements]['name'] }}</label>
                                    @if (isset($children[$subElements]))
                                        <ul>
                                            @foreach ($children[$subElements] as $subSubKey => $subSubElements)
                                                <li
                                                    class="collapsed"
                                                    id="node_sub_sub_{{ $subSubKey }}"
                                                >
                                                    <input
                                                        id="checkSelect_sub_sub{{ $subSubKey }}"
                                                        name="flags[]"
                                                        type="checkbox"
                                                        value="{{ $flags[$subSubElements]['flag'] }}"
                                                        @if (in_array($flags[$subSubElements]['flag'], $active)) checked @endif
                                                    >
                                                    <label
                                                        class="label label-success nameMargin"
                                                        for="checkSelect_sub_sub{{ $subSubKey }}"
                                                    >{{ $flags[$subSubElements]['name'] }}</label>
                                                    @if (isset($children[$subSubElements]))
                                                        <ul>
                                                            @foreach ($children[$subSubElements] as $grandChildrenKey => $grandChildrenElements)
                                                                <li
                                                                    class="collapsed"
                                                                    id="node_grand_child{{ $grandChildrenKey }}"
                                                                >
                                                                    <input
                                                                        id="checkSelect_grand_child{{ $grandChildrenKey }}"
                                                                        name="flags[]"
                                                                        type="checkbox"
                                                                        value="{{ $flags[$grandChildrenElements]['flag'] }}"
                                                                        @if (in_array($flags[$grandChildrenElements]['flag'], $active)) checked @endif
                                                                    >
                                                                    <label
                                                                        class="label label-danger nameMargin"
                                                                        for="checkSelect_grand_child{{ $grandChildrenKey }}"
                                                                    >{{ $flags[$grandChildrenElements]['name'] }}</label>
                                                                    @if (isset($children[$grandChildrenElements]))
                                                                        <ul>
                                                                            @foreach ($children[$grandChildrenElements] as $grandChildrenKeySub => $greatGrandChildrenElements)
                                                                                <li
                                                                                    class="collapsed"
                                                                                    id="node{{ $grandChildrenKey }}"
                                                                                >
                                                                                    <input
                                                                                        id="checkSelect_grand_child{{ $grandChildrenKeySub }}"
                                                                                        name="flags[]"
                                                                                        type="checkbox"
                                                                                        value="{{ $flags[$grandChildrenElements]['flag'] }}"
                                                                                        @if (in_array($flags[$grandChildrenElements]['flag'], $active)) checked @endif
                                                                                    >
                                                                                    <label
                                                                                        class="label label-info nameMargin"
                                                                                        for="checkSelect_grand_child{{ $grandChildrenKeySub }}"
                                                                                    >{{ $flags[$grandChildrenElements]['name'] }}</label>
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
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </li>
</ul>
