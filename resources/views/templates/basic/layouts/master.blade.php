@extends($activeTemplate.'layouts.app')
@section('app')
@include($activeTemplate.'partials.header')
<section class="breadcrumb-section">
            <h2 class="sr-only">Site Breadcrumb</h2>
            <div class="container">
                <div class="breadcrumb-contents">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">My Account</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>
<div class="page-section inner-page-sec-padding">
    <div class="container">
        <div class="row">
                    <div class="col-12">
        <div class="row">
            <div class="col-xxl-3 col-lg-4">
                @include($activeTemplate.'partials.dashboard_aside')
            </div>
            <div class="col-xxl-9 col-lg-8">
                @include($activeTemplate.'partials.responsive_nav')
                <div class="dashboard-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

@include($activeTemplate.'partials.footer')

@endsection

@push('script')
<script>
    'use strict';
    (function ($) {
        // fetch cart count
        getCartCount()   
        getWishlistCount()
          
        function getCartCount(){
            $.ajax({
               type: "GET",
               url: "{{ route('get-cart-count') }}",
               success: function (response) {
                   $('.show-cart-count').text(response);
               }
           });
        }
        //  fetch wishlist count
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