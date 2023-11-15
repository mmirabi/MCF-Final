@php
    $crumbs = Theme::breadcrumb()->getCrumbs();
@endphp

@if(count($crumbs))
    @if (!empty($big))
        <div class="page-header mt-30 mb-75">
            <div class="container">
                <div class="archive-header" @if (!empty($background)) style="background-image: url({{ RvMedia::getImageUrl($background) }}) !important;" @endif>
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <h1 class="mb-15">{{ SeoHelper::getTitle() }}</h1>
                            <div class="breadcrumb">
                                @foreach ($crumbs as $i => $crumb)
                                    @if ($i != (count($crumbs) - 1))
                                        <div class="breadcrumb-item d-inline-block">
                                            <a href="{{ $crumb['url'] }}" title="{{ $crumb['label'] }}">
                                                {!! BaseHelper::clean($crumb['label']) !!}
                                            </a>
                                        </div>
                                        <span></span>
                                    @else
                                        <div class="breadcrumb-item d-inline-block active">
                                            <div itemprop="item">
                                                {!! BaseHelper::clean($crumb['label']) !!}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    @foreach ($crumbs as $i => $crumb)
                        @if ($i != (count($crumbs) - 1))
                            <div class="breadcrumb-item d-inline-block">
                                <a href="{{ $crumb['url'] }}"title="{{ $crumb['label'] }}">
                                    {!! BaseHelper::clean($crumb['label']) !!}
                                </a>
                            </div>
                            <span></span>
                        @else
                            <div class="breadcrumb-item d-inline-block active">
                                <div itemprop="item">
                                    {!! BaseHelper::clean($crumb['label']) !!}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif
