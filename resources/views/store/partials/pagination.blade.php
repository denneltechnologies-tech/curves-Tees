@if ($paginator->hasPages())
    <div class="store-pagination">
        <nav role="navigation" aria-label="Boutique Catalog Pagination" class="store-pagination-nav">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-control disabled" aria-disabled="true" title="Previous Page">
                    &lsaquo; Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-control" title="Previous Page">
                    &lsaquo; Prev
                </a>
            @endif

            {{-- Numeric Page Elements --}}
            <div class="page-numbers">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="page-num dots">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="page-num active" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-num">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-control" title="Next Page">
                    Next &rsaquo;
                </a>
            @else
                <span class="page-control disabled" aria-disabled="true" title="Next Page">
                    Next &rsaquo;
                </span>
            @endif
        </nav>
    </div>
@endif
