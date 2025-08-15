@extends($activeTemplate . 'layouts.frontend')
@section('title') {{$catmeta->metatitle}} @endsection
@section('description') {{$catmeta->metadescription}} @endsection
@section('keywords') {{$catmeta->metakeywords}} @endsection
@section('content')
@if($subcategories) 

 @include($activeTemplate.'sections.categorybanner',['categoryId' => $categoryId])
@else
 @include($activeTemplate.'sections.productbanner',['subcategoryId' => $subcategoryId])
@endif

<style>
@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
.promo-wrapper.promo-type-three{height: 120px !important;}
.section-margin{margin-bottom:0px !important;}
.product-view-mode{display:none !important;}
}</style>
    <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Category Products</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <main class="mainProduct-panel inner-page-sec-padding-bottom">
        @include('templates.basic.products.partials.mainProduct')
    </main>

    @include('templates.basic.products.partials.productModal')
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            getWishlistCount();
            let page = null;
            $('.loader-wrapper').addClass('d-none')
            $('.sortProduct, .sortBrand, .productPaginate, .sortCategory').on('change', function() {
                $('.loader-wrapper').removeClass('d-none')
                if ($('#cate-0').is(':checked')) {
                    $("[name=subcategory]").not(this).prop('checked', false);
                }
                if ($('#brand0').is(':checked')) {
                    $("[name=brand]").not(this).prop('checked', false);
                }
                fetchProduct();
            });

            $("#slider-range").slider({
                range: true,
                min: {{ $minPrice }},
                max: {{ $maxPrice }},
                values: [{{ $minPrice }}, {{ $maxPrice }}],
                slide: function(event, ui) {
                    $("#amount").val("{{ $general->cur_sym }}" + ui.values[0] +
                        " - {{ $general->cur_sym }}" + ui.values[1]);
                    $('input[name=min_price]').val(ui.values[0]);
                    $('input[name=max_price]').val(ui.values[1]);
                },
                change: function() {
                    $('.loader-wrapper').removeClass('d-none')
                    fetchProduct();
                }
            });
            $("#amount").val("{{ $general->cur_sym }}" + $("#slider-range").slider("values", 0) +
                " - {{ $general->cur_sym }}" + $("#slider-range").slider("values", 1));

            function fetchProduct() {

                let data = {};
                data.min = $('input[name="min_price"]').val();
                data.max = $('input[name="max_price"]').val();
                data.paginate = $('.productPaginate').find(":selected").val();
                data.sort = $('.sortProduct').find(":selected").val();
                data.categoryId = "{{ $categoryId }}";
                data.subcategoryId = "{{ $subcategoryId }}";

                data.subcategories = [];
                $.each($("[name=subcategory]:checked"), function() {
                    if ($(this).val()) {
                        data.subcategories.push($(this).val());
                    }
                });

                data.brands = [];
                $.each($("[name=brand]:checked"), function() {
                    if ($(this).val()) {
                        data.brands.push($(this).val());
                    }
                });

                let url = `{{ route('all.products.filter') }}`;
                if (page) {
                    url = `{{ route('all.products.filter') }}?page=${page}`;
                }

                $.ajax({
                    method: "GET",
                    url: url,
                    data: data,
                    success: function(response) {
                        getWishlistCount();
                        $('#products').html(response);
                    }
                }).done(function() {
                    $('.loader-wrapper').addClass('d-none')
                });
            }

           

            function getWishlistCount() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-wishlist-count') }}",
                    success: function(response) {
                        var total = Object.keys(response).length;
                        $.each(response, function(indexInArray, value) {
                            $(document).find(`[data-product_id='${value.product_id}']`).closest(
                                '.add-wishlist').addClass('active');
                        });
                        $('.show-wishlist-count').text(total);
                    }
                });
            }

        })(jQuery);
    </script>
@endpush
@section('footerJs')
    <script>

        $(document).on('click', 'ul.pagination-btns li a.pagination-link', function(e) {
            e.preventDefault(0);
            let url=$(this).attr('href');
            loadContent(url);
        });


        $(document).on('change', '.sort-using-page', function(e) {
            e.preventDefault(0);
            let url=$(this).val();
            loadContent(url);
        });

        $(document).on('change', '.sort-using-column', function(e) {
            e.preventDefault(0);
            let orderBy=$(this).val();
            if(!orderBy) {
                return;
            }

            let url=$('.sort-using-page').val();
            loadContent(url + '&orderBy=' + orderBy);
        });

        function loadContent(url)
        { 
            $.get(url, function(response) {
                $('.mainProduct-panel').html(response);
                $(".nice-select").niceSelect();
            });
        }
        
    </script>
@endsection