<!-- CUSTOM PAGINATE LAYOUT -->

@if ($paginator->hasPages())
    <div class="custom-numbers-pagination">
        <ul class="custom-pagination">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="custom-page-item disabled" aria-disabled="true">
                        <span class="custom-page-link page-circle ellipsis">…</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="custom-page-item active" aria-current="page">
                                <span class="custom-page-link page-circle active-circle">{{ $page }}</span>
                            </li>
                        @else
                            <li class="custom-page-item">
                                <a class="custom-page-link page-circle" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>
@endif

<style>

    /* ==== ONLY NUMBERS PAGINATION ==== */

    .custom-numbers-pagination .custom-pagination {
        display: flex;
        gap: 10px;
        list-style: none;
        padding: 0;
        justify-content: center;
    }
    .custom-numbers-pagination .custom-page-link.page-circle {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 2px solid #cccccc;
        color: white;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
        background-color: #cccccc;
    }
    .custom-numbers-pagination .custom-page-item.active .custom-page-link.page-circle {
        background-color: #212529;
        color: white;
        border-color: #212529;
    }
    .custom-numbers-pagination .custom-page-link.page-circle:hover {
        background-color:rgb(146, 146, 146);
        color: black;
    }
    .custom-numbers-pagination .ellipsis {
        border: none;
        font-weight: normal;
        color: #212529;
    }

</style>