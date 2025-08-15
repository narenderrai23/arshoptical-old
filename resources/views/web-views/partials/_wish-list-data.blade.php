<style>
    body {
        font-family: 'Titillium Web', sans-serif
    }

    .card {
        border: none
    }

    .totals tr td {
        font-size: 13px
    }

    .footer span {
        font-size: 12px
    }

    .product-qty span {
        font-size: 12px;
        color: #6A6A6A;
    }

    .font-name {
        font-weight: 600;
        font-size: 15px;
        color: #030303;
    }

    .sellerName {

        font-weight: 600;
        font-size: 14px;
        color: #030303;
    }

    .wishlist_product_img img {
        margin: 15px;
    }

    @media (max-width: 600px) {
        .font-name {
            font-size: 12px;
            font-weight: 400;
        }

        .amount {
            font-size: 12px;
        }
    }

    @media (max-width: 600px) {
        .wishlist_product_img {
            width: 20%;
        }

        .forPadding {
            padding: 6px;
        }

        .sellerName {

            font-weight: 400;
            font-size: 12px;
            color: #030303;
        }

        .wishlist_product_desc {
            width: 50%;
            margin-top: 0px !important;
        }

        .wishlist_product_icon {
            margin-left: 1px !important;
        }

        .wishlist_product_btn {
            width: 30%;
            margin-top: 10px !important;
        }

        .wishlist_product_img img {
            margin: 8px;
        }
    }
</style>
<div class="d-flex justify-content-start mt-2 mb-3">

<button class="btn btn-primary element-center btn-gap-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" onclick="allAddToCart()" type="button" style="width:37%; height: 45px;{{Session::get('direction') === "rtl" ? 'margin-right: 20px;' : 'margin-left: 20px;'}}">
                        <span class="string-limit">Add all items to cart</span>
                    </button>

</div>
@if($wishlists->count()>0)
@foreach($wishlists as $key=>$wishlist)
@php($product = $wishlist->product_full_info)
@if( $wishlist->product_full_info)
<div class="card box-shadow-sm mt-2">
    <div class="product mb-2">
        <div class="card">
   
        <form id="add-to-cart-form<?php echo $key; ?>" class="mb-2">
                @csrf
                <input type="hidden" name="id" value="{{$product['id']}}">
                <input type="hidden" name="quantity" value="1">
            <div class="row forPadding">
                <div class="wishlist_product_img col-md-2 col-lg-2 col-sm-2">
                    <a href="{{route('product',$product->slug)}}">
                        <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}">
                    </a>
                </div>
                <div class="wishlist_product_desc col-md-6 mt-4 {{Session::get('direction') === "rtl" ? 'pr-4' : 'pl-4'}}">
                    <span class="font-name">
                        <a href="{{route('product',$product['slug'])}}">{{$product['name']}}</a>
                    </span>
                    <br>
                    <span class="sellerName"> {{\App\CPU\translate('Brand')}} :{{$product->brand?$product->brand['name']:''}} </span>

                    <div class="">
                        @if($product->discount > 0)
                        <strike style="color: #E96A6A;" class="{{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-3'}}">
                            {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                        </strike>
                        @endif
                        <span class="font-weight-bold amount">{{\App\CPU\Helpers::get_price_range($product) }}</span>
                    </div>
                </div>
                <div class="wishlist_product_btn col-md-4 mt-5 float-right bodytr font-weight-bold" style="color: #92C6FF;">

                    <a href="javascript:" class="wishlist_product_icon ml-2 pull-right mr-3">
                        <i class="czi-close-circle" onclick="removeWishlist('{{$product['id']}}')" style="color: red"></i>
                    </a>
                </div>
            </div>



         

                <div class="row flex-start no-gutters d-none mt-2">

                    <div class="col-12">
                        @if($product['current_stock']<=0) <h5 class="mt-3 text-body" style="color: red">{{\App\CPU\translate('out_of_stock')}}</h5>
                            @endif
                    </div>
                </div>
                <div class="d-flex justify-content-start mt-2 mb-3">
                    <!-- <button class="btn element-center btn-gap-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" onclick="buy_now()" type="button" style="width:37%; height: 45px; background: #FFA825 !important; color: #ffffff;">
                        <span class="string-limit">{{\App\CPU\translate('buy_now')}}</span>
                    </button> -->
                    <button class="btn btn-primary element-center btn-gap-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" onclick="addToCart<?php echo $key; ?>()" type="button" style="width:37%; height: 45px;{{Session::get('direction') === "rtl" ? 'margin-right: 20px;' : 'margin-left: 20px;'}}">
                        <span class="string-limit">{{\App\CPU\translate('add_to_cart')}}</span>
                    </button>

                </div>
            </form>
<script>
    function addToCart<?php echo $key; ?>(form_id = 'add-to-cart-form<?php echo $key; ?>', redirect_to_checkout=false) {       
        if (checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('cart.add') }}',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == 1) {
                        updateNavCart();
                        toastr.success(response.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('.call-when-done').click();
                        if(redirect_to_checkout)
                        {
                            location.href = "{{route('checkout-details')}}";
                        }
                        return false;
                    } else if (response.status == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: response.message
                        });
                        return false;
                    }
                },
                complete: function () {
                    $('#loading').hide();

                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Cart',
                text: '{{\App\CPU\translate('please_choose_all_the_options')}}'
            });
        }
    }
</script>


<script>
    function allAddToCart(redirect_to_checkout=false) {       
        if (checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('cart.allAdd') }}',
                // data: $('#' + form_id).serializeArray(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == 1) {
                        updateNavCart();
                        toastr.success(response.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('.call-when-done').click();
                        if(redirect_to_checkout)
                        {
                            location.href = "{{route('checkout-details')}}";
                        }
                        return false;
                    } else if (response.status == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: response.message
                        });
                        return false;
                    }
                },
                complete: function () {
                    $('#loading').hide();

                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Cart',
                text: '{{\App\CPU\translate('please_choose_all_the_options')}}'
            });
        }
    }
</script>



        </div>
    </div>
</div>
@else
<span class="badge badge-danger">{{\App\CPU\translate('item_removed')}}</span>
@endif
@endforeach
@else
<center>
    <h6 class="text-muted">
        {{\App\CPU\translate('No data found')}}.
    </h6>
</center>
@endif