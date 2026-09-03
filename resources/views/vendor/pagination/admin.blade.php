@if ($paginator->hasPages())
    <nav class="admin-pagination">
        @if ($paginator->onFirstPage())
            <span class="admin-pagination__btn is-disabled">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="admin-pagination__btn">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="admin-pagination__dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="admin-pagination__btn is-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="admin-pagination__btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="admin-pagination__btn">&raquo;</a>
        @else
            <span class="admin-pagination__btn is-disabled">&raquo;</span>
        @endif
    </nav>
@endif
