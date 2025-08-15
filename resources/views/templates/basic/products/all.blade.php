@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate.'sections.banner')

<style>
    .sorting-selection .nice-select{width: 100%;}
</style>
    <section class="breadcrumb-section">
            <h2 class="sr-only">Site Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Shop</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>


<main class="inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row">
            @if($products->count() > 0)


<div class="col-lg-3  mt--40 mt-lg--0">
                        <div class="inner-page-sidebar">
                            <!-- Accordion -->
                            <div class="single-block">
                                <h3 class="sidebar-title">@lang('Filter by categories')</h3>
                                <ul class="sidebar-menu--shop">
                                    <li><a href=""><input class="form-check-input sortCategory" name="category" type="checkbox"
                                    id="cate-0" value="" checked>
                                <label class="form-check-label" for="cate-0">
                                    <span>@lang('All Categories')</span>
                                </label></a></li>
                                    <li><a href="">@foreach ($categoryList as $category)
                            <div class="form-check form--check">
                                <input class="form-check-input sortCategory" type="checkbox" name="category"
                                    id="cate{{ $category->id }}" value="{{ $category->id }}">
                                <label class="form-check-label" for="cate{{ $category->id }}">
                                    <span>{{ __($category->name) }}</span>
                                </label>
                            </div>
                            @endforeach</a></li>
                                    
                                </ul>
                            </div>
                            <!-- Price -->
                            <!-- <div class="single-block">
                                <h3 class="sidebar-title">Fillter By Price</h3>
                                <div class="range-slider pt--30">
                                    <div class="sb-range-slider"></div>
                                    <div class="slider-price">
                                        <p>
                                            <input type="text" id="amount" readonly="">
                                        </p>
                                    </div>
                                </div>
                            </div> -->
                            <!-- Size -->
                            <div class="single-block">
                                <h3 class="sidebar-title">@lang('Filter by brands')</h3>
                                <ul class="sidebar-menu--shop menu-type-2">
                                    <li><a href=""><input class="form-check-input sortBrand" name="brand" type="checkbox"
                                    id="brand0" value="" checked>
                                    <label class="form-check-label" for="brand0">
                                        <span>@lang('All Brands')</span>
                                    </label></a></li>
                                    <li><a href="">@foreach ($brands as $brand)
                            <div class="form-check form--check">
                                <input class="form-check-input sortBrand" name="brand" type="checkbox"
                                    id="brand{{ $brand->id }}" value="{{ $brand->id }}">
                                <label class="form-check-label" for="brand{{ $brand->id }}">
                                    <span>{{ __($brand->name) }}</span>
                                </label>
                            </div>
                            @endforeach</a></li>

                                </ul>
                            </div>
                            <!-- Color -->
                            <!-- <div class="single-block">
                                <h3 class="sidebar-title">Select By Color</h3>
                                <ul class="sidebar-menu--shop menu-type-2">
                                    <li><a href="">Black <span>(5)</span></a></li>
                                    <li><a href="">Blue <span>(6)</span></a></li>
                                    <li><a href="">Brown <span>(4)</span></a></li>
                                    <li><a href="">Green <span>(7)</span></a></li>
                                    <li><a href="">Pink <span>(6)</span></a></li>
                                    <li><a href="">Red <span>(5)</span></a></li>
                                    <li><a href="">White <span>(8)</span></a></li>
                                    <li><a href="">Yellow <span>(11)</span> </a></li>
                                </ul>
                            </div> -->
                            <!-- Promotion Block -->
                            <!-- <div class="single-block">
                                <a href="" class="promo-image sidebar">
                                    <img src="image/others/home-side-promo.jpg" alt="">
                                </a>
                            </div> -->
                        </div>
                        <div class="col-lg-3" style="display: :none;">
                                           <!--  <div class="filter__widget">
                                                <h5 class="filter__widget-title">@lang('Filter by price')</h5>
                                                <div class="filter__widget-body">
                                                    <div class="filter-price-widget pt-2">
                                                        <div id="slider-range"></div>
                                                        <div class="price-range">
                                                            <label for="amount">@lang('Price :')</label>
                                                            <input type="text" id="amount" readonly>
                                                            <input type="hidden" name="min_price" value="{{ getAmount($minPrice) }}">
                                                            <input type="hidden" name="max_price" value="{{ getAmount($maxPrice) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                    </div>
                    </div>
                                    

            @endif
            <div class="@if($products->count() >0) col-lg-9  @else col-lg-12 @endif">

                        <div class="shop-toolbar with-sidebar mb--30">
                            <div class="row align-items-center">
                                <!-- <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="product-view-mode">
                                        <a href="#" class="sorting-btn" data-target="grid"><i class="fas fa-th"></i></a>
                                        <a href="#" class="sorting-btn" data-target="grid-four">
                                            <span class="grid-four-icon">
                                                <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="sorting-btn  active" data-bs-target="list"><i
                                                class="fas fa-list"></i></a>
                                    </div>
                                </div> -->
                                <!-- <div class="col-xl-6 col-md-6 col-sm-6  mt--10 mt-sm--0">
                                    <span class="toolbar-status">
                                        @if(request()->search)
                                            <div class="top_bar mb-3">
                                                <strong>
                                                    @lang('Search results for ')
                                                    <span class="text--base">{{ __(request()->search) }}</span>
                                                    @lang('total')
                                                    <span class="text--base">{{ $products->count() }}</span>
                                                    @lang('products found')</strong>
                                            </div>
                                        @endif
                                    </span>
                                </div> -->
                                <div class="col-lg-6 col-md-6 col-sm-6  mt--10 mt-md--0">
                                    <div class="sorting-selection">
                                        <select class="productPaginate form-control nice-select sort-select">
                                            <option value="" selected disabled>@lang('Select One')</option>
                                            <option value="5">@lang('5 items per page')</option>
                                            <option value="10">@lang('10 items per page')</option>
                                            <option value="20" selected>@lang('20 items per page')</option>
                                            <option value="40">@lang('40 items per page')</option>
                                            <option value="60">@lang('60 items per page')</option>
                                            <option value="80">@lang('80 items per page')</option>
                                            <option value="100">@lang('100 items per page')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                                    <div class="sorting-selection">
                                        <select class="sortProduct form-control nice-select sort-select mr-0 wide">
                                            <option value="" selected disabled>@lang('Sort By')</option>
                                            <option value="id_desc">@lang('Latest')</option>
                                            <option value="price_asc">@lang('From low to high')</option>
                                            <option value="price_desc">@lang('From high to low')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                <div class="products-wrapper">
                    
                    <div class="loader-wrapper">
                        <div class="loader"></div>
                    </div>
                    <div class="row justify-content-center g-3" id="products">
                        @include($activeTemplate.'products.show_products')
                    </div>
                </div>




            </div>
        </div>
    </div>
</main>
@endsection

@push('style-lib')
<link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/custom.css') }}">
@endpush

@push('script')
<script>
    (function($){
    "use strict";
    getWishlistCount() 
        let page = null;
        $('.loader-wrapper').addClass('d-none')
        $('.sortCategory, .sortBrand, .productPaginate, .sortProduct').on('change',function () { 
            $('.loader-wrapper').removeClass('d-none');
            if($('#cate-0').is(':checked')){
                $("input[type='checkbox'][name='category']").not(this).prop('checked', false);
            }
            if($('#brand0').is(':checked')){
                $("input[type='checkbox'][name='brand']").not(this).prop('checked', false);
            }
            fetchProduct();
        });
        
        $("#slider-range").slider({
            range: true,
            min: {{ $minPrice }},
            max: {{ $maxPrice }},
            values: [{{ $minPrice }}, {{ $maxPrice }}],
            slide: function (event, ui) {
                $("#amount").val("{{$general->cur_sym}}" + ui.values[0] + " - {{$general->cur_sym}}" + ui.values[1]);
                $('input[name=min_price]').val(ui.values[ 0 ]);
                $('input[name=max_price]').val(ui.values[ 1 ]);
            },
            change: function(){
                $('.loader-wrapper').removeClass('d-none')
                fetchProduct();
            }
        });
        $("#amount").val("{{$general->cur_sym}}" + $("#slider-range").slider("values", 0) + " - {{$general->cur_sym}}" + $("#slider-range").slider("values", 1));

        function fetchProduct(){  

            let data = {};
            data.min  = $('input[name="min_price"]').val();
            data.max  = $('input[name="max_price"]').val();
            data.sort = $('.sortProduct').find(":selected").val();
            data.paginate = $('.productPaginate').find(":selected").val();        
            data.search = "{{ request()->search }}"; 
            data.route = "{{ request()->route()->getname() }}";
            
            data.categories = [];
            $.each($("[name=category]:checked"), function() {
                if($(this).val()){
                    data.categories.push($(this).val());
                }
            });

            data.brands = [];
            $.each($("[name=brand]:checked"), function() {
                if($(this).val()){
                    data.brands.push($(this).val());
                }
            });

            let url =  `{{ route('all.products.filter') }}`;
            if(page){
                url = `{{ route('all.products.filter') }}?page=${page}`;
            }   

            $.ajax({
                method: "GET",
                url: url,
                data: data,
                success: function (response) {
                    getWishlistCount();
                    $('#products').html(response);
                }
            }).done(function(){
                $('.loader-wrapper').addClass('d-none')
            });
        }
        

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            fetchProduct();
        });
        function getWishlistCount(){
            $.ajax({
               type: "GET",
               url: "{{ route('get-wishlist-count') }}",
               success: function (response) {
                    var total = Object.keys(response).length;
                    $.each(response, function (indexInArray, value) { 
                        $(document).find(`[data-product_id='${value.product_id}']`).closest('.add-wishlist').addClass('active');
                    });
                   $('.show-wishlist-count').text(total);
               }
           });
        }

    })(jQuery);

</script>
@endpush

