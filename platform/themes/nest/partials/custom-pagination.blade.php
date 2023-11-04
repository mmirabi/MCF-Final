@if ($paginator->hasPages())
    <div class="pagination-area mt-20 mb-20 pagination-page">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                @if (!$paginator->onFirstPage())
                    <li class="page-item">
                        <a class="prev page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fi-rs-arrow-small-left"></i></a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="next page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fi-rs-arrow-small-right"></i></a></li>
                @endif
            </ul>
        </nav>
    </div>
@endif
