@if ($paginator->hasPages())
    <div class="row pt--30">
        <div class="col-md-12">
            <div class="pagination-block">
                <ul class="pagination-btns flex-center">
                    
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="single-btn prev-btn">
                                |<i class="zmdi zmdi-chevron-left"></i>
                            </span>
                        </li>

                        <li class="page-item disabled">
                            <span class="single-btn prev-btn">
                                <i class="zmdi zmdi-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->url(1) }}" class="single-btn prev-btn pagination-link">
                                |<i class="zmdi zmdi-chevron-left"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" class="single-btn prev-btn pagination-link">
                                <i class="zmdi zmdi-chevron-left"></i>
                            </a>
                        </li>
                    @endif
        
                    @foreach ($elements as $element)
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="active">
                                        <span class="single-btn">{{ $page }}</span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" class="single-btn pagination-link">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" class="single-btn prev-btn pagination-link">
                                <i class="zmdi zmdi-chevron-left"></i>
                            </a>
                        </li>

                        <li>
                            <a  href="{{$paginator->url($paginator->lastPage())}}" class="single-btn prev-btn pagination-link">
                                <i class="zmdi zmdi-chevron-left"></i>|
                            </a>
                        </li>

                    @else
                        <li class="page-item disabled">
                            <span class="single-btn prev-btn">
                                <i class="zmdi zmdi-chevron-left"></i>
                            </span>
                        </li>

                        <li class="page-item disabled">
                            <span class="single-btn prev-btn">
                                <i class="zmdi zmdi-chevron-left"></i>|
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif

