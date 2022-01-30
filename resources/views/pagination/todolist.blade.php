@if ($paginator->hasPages())

    <ul class="pagination pagination-sm">
        <?php
        $cur_page_number=null;
        $next_page_number=null;
        $prev_page_number=null;
        ?>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                {{-- next page nmber finder --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <?php $prev_page_number=($page-1) ?>
                        @endif
                    @endforeach
                @endif
            @endif
        @endforeach

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li  class="page-item"><a disabled="disabled" class="ln page-link">&laquo;</a></li>
        @else
            <li  class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="ln page-link" rel="prev">&laquo;</a></li>
        @endif


        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            <!--
            @if (is_string($element))
                <li><span class="cur-page"><span>Page {{ $element }}</span></span></li>
            @else
                <li><span class="cur-page"><span>Page 2</span></span></li>

            @endif
            -->

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <?php $cur_page_number=$page ?>
                            <li class="page-item active"><a class="page-link">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif

            {{-- next page nmber finder --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <?php $next_page_number=($page+1) ?>
                    @endif
                @endforeach
            @endif
        @endforeach


        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="rn page-link" rel="next">&raquo;</a></li>
        @else
            <li class="page-item"><a disabled="disabled" class="rn page-link">&raquo;</a></li>
        @endif
    </ul>
@endif
