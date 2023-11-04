<div
    class="widget meta-boxes"
    id="{{ $box['id'] }}"
>
    <div class="widget-title">
        <h4><span>{!! BaseHelper::clean($box['title']) !!}</span></h4>
    </div>
    <div class="widget-body">
        {!! $callback !!}
    </div>
</div>
