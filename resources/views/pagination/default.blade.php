@if ($paginator->hasPages())
    <ul class="pagination pagination_style1">
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
            <li class="page-item" disabled=""><a class="page-link in" disabled="disabled"><i class="linearicons-arrow-left"></i></a></li>
        @else
                <li class="page-item"><a class="page-link in" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="linearicons-arrow-left"></i></a></li>
                <!--<li>{{ $prev_page_number }}</li>-->
        @endif


        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <!--<li><span class="cur-page"><span>{{ $element }}</span></span></li>-->
            @else
                <!--<li><span class="cur-page"><span>...</span></span></li>-->
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <?php $cur_page_number=$page ?>
                            <li class="page-item active"><a class="page-link" disabled="" href="javascript:{}">{{ $page }}</a></li>
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
        <!--<li>{{ $cur_page_number }}</li>-->

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link rn" rel="next"  href="{{ $paginator->nextPageUrl() }}"><i class="linearicons-arrow-right "></i></a></li>
                <!--<li>{{ $next_page_number }}</li>-->
        @else
            <li class="page-item" disabled=""><a disabled="" class="page-link rn" rel="next"><i class="linearicons-arrow-right "></i></a></li>
        @endif
    </ul>
@endif
