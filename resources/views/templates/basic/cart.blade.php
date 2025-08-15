@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- Cart Page Start -->
    <main class="cart-page-main-block inner-page-sec-padding-bottom">
        <div class="cart_area cart-area-padding  ">
            <div class="container">
                <div class="page-section-title">
                    <h1>Shopping Cart</h1>
                </div>
                <div class="row">
                    <div class="col-12">
                        <form action="#" class="">
                            <!-- Cart Table -->
                            <div class="cart-table table-responsive mb--40">
                                <table class="table align-middle table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">@lang('Image')</th>
                                            <th scope="col">@lang('Product')</th>
                                            <th scope="col">@lang('Color')</th>
                                            <th scope="col">@lang('Unit Price')</th>
                                            <th scope="col">@lang('Quantity')</th>
                                            <th scope="col">@lang('Subtotal')</th>
                                            <th scope="col">@lang('Remove')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                         @php
                                            $tax = 0;
                                            $atotal = 0;
                                        @endphp

                                        @forelse ($carts as $cart)
                                            @php
                                                $user = auth()->user();
                                                $product = $cart->product;
                                                $product_id = $cart->product_id;
                                                $color = $cart->color;
                                                $color_id = $cart->color_id;

                                                $imagePath = \App\Models\ProductGallery::find($color_id);
                                                $image = $imagePath ? getImage(
                                                    imagePath()['product']['gallery']['path'] . '/' . $imagePath->image,
                                                    imagePath()['product']['gallery']['size']
                                                ) : asset('assets/images/default.png');

                                                $name = $user && $product
                                                    ? $product->name . ' ' . $product->model_no
                                                    : $cart->name;

                                                $price = $user && $product
                                                    ? productPriceWeb($product)
                                                    : showDiscountPrice($cart->price, $cart->discount, $cart->discount_type);

                                                $subTotal = $price * $cart->quantity;
                                                $atotal += $subTotal;

                                                $productQty = optional($product)->quantity ?? 0;
                                                $tax += (($price * $productQty) / 100) * $cart->quantity;
                                            @endphp

                                            <tr>
                                                <td class="pro-thumbnail" data-label="@lang('Image')">
                                                    <img src="{{ getImage(imagePath()['product']['gallery']['path'] . '/' . $imagePath->image, imagePath()['product']['gallery']['size']) }}" alt="Product Image">
                                                </td>
                                                <td data-label="@lang('Product')">
                                                    <div class="product-item">
                                                        <div class="product-content">
                                                            <h6 class="productName" data-product_id="{{ $product_id }}" data-color_id="{{ $color_id }}">
                                                                {{ __($name) }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="@lang('Color')">
                                                    <span class="price">{{ __($color) }}</span>
                                                </td>

                                                <td data-label="@lang('Unit Price')">
                                                    <span class="price">{{ $general->cur_sym }}{{ getAmount($price) }}</span>
                                                </td>

                                                <td data-label="@lang('Quantity')" class="pro-qty">
                                                    @if($imagePath && $imagePath->qty)
                                                        <div class="input-group input-group-sm justify-content-center">
                                                            <input type="number" name="quantity" value="{{ $cart->quantity }}"
                                                                class="form-control text-center w-50" min="1">
                                                            <button class="btn btn-outline-secondary cart-increase qtybutton inc" type="button">
                                                                <i class="las la-sync"></i>
                                                            </button>
                                                        </div>
                                                        <div class="form-text text-danger small"></div>
                                                    @else
                                                        <input type="hidden" name="quantity" value="{{ $cart->quantity }}">
                                                        <span class="text-danger fw-bold">@lang('Out Of Stock')</span>
                                                    @endif
                                                </td>

                                                <td data-label="@lang('Subtotal')">
                                                    @if($imagePath && $imagePath->qty)
                                                        <span class="subtotal">
                                                         {{ $general->cur_sym }}{{ getAmount($subTotal) }}
                                                        </span>
                                                    @else
                                                        --
                                                    @endif
                                                </td>

                                                <td data-label="@lang('Remove')">
                                                    
                                                    <button type="button" class="btn btn-sm btn--danger remove-btn" data-id="{{ $cart->id }}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <div class="alert alert-warning m-0 text-center">
                                                        {{ __($emptyMessage) }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse

                                        @php
                                            $ttax = $tax;
                                            $totalAmount = $atotal + $ttax;
                                            session()->put('total', [
                                                'coupon_name' => '',
                                                'coupon_id' => '',
                                                'discount_type' => '',
                                                'subtotal' => $atotal,
                                                'totaltax' => $ttax,
                                                'discount' => 0,
                                                'totalAmount' => $totalAmount,
                                            ]);
                                        @endphp
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($carts->isNotEmpty())
            <div class="cart-section-2">
                <div class="container">
                    <div class="row">
                        <!-- Coupon Form -->
                        <div class="col-lg-6 col-12 d-flex align-items-start mb-3 mb-lg-0">
                            <form class="coupon-form w-100">
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        name="coupon"
                                        class="form-control form--control coupon"
                                        placeholder="@lang('Enter your coupon code')"
                                    >
                                    <button type="submit" class="btn btn--base coupon-apply">
                                        @lang('Apply')
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Cart Summary -->
                        <div class="col-lg-6 col-12 d-flex justify-content-lg-end">
                            <div class="cart-summary w-100 bg-white p-4 rounded-3 shadow-sm">
                                <div class="cart-summary-wrap">
                                    <h4 class="mb-4"><strong>@lang('Cart Summary')</strong></h4>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>@lang('Sub Total')</span>
                                        <span class="text-primary subtotal-price">
                                            {{ $general->cur_sym }}0.00
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>@lang('Discount')</span>
                                        <span class="text-primary discount-price">
                                            {{ $general->cur_sym }}0.00
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span>@lang('GST')</span>
                                        <span class="text-primary tax-amount" data-tax="{{ number_format((float) $tax, 2, '.', '') }}">
                                            {{ $general->cur_sym }}{{ number_format((float) $tax, 2, '.', '') }}
                                        </span>
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="mb-0">@lang('Grand Total')</h5>
                                        <h5 class="text-primary total-price mb-0">
                                            {{ $general->cur_sym }}0.00
                                        </h5>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('user.checkout') }}" class="btn btn--primary w-100">
                                        @lang('Proceed to Checkout')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
    <!-- Cart Page End -->

    <div class="modal fade" id="removeCartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg--base">
                    <strong class="modal-title">@lang('Confirmation Alert!')</strong>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to remove this product?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn--base remove-product">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use script";
            let currentRow;
            let quantity
            $('.cart-decrease').click(function() {
                currentRow = $(this).closest("tr");
                quantity = currentRow.find('input[name="quantity"]').val();
                if (quantity > 0) {
                    CartCalculation(currentRow)
                } else {
                    currentRow.find('input[name="quantity"]').val(1)
                    notify('error', 'You have to order a minimum amount of one.');
                }
            });
            
            $('input[name="quantity"]').on('focusout', function() {
                currentRow = $(this).closest("tr");
                quantity = currentRow.find('input[name="quantity"]').val();
                if (quantity == 0) {
                    currentRow.find('input[name="quantity"]').val(1)
                    notify('error', 'You have to order a minimum amount of one.');
                }
                
                CartCalculation(currentRow);
                cartSummary()

            });

            $('.cart-increase').click(function () {
                const currentRow = $(this).closest("tr");
                CartCalculation(currentRow);
                cartSummary();
            });

            function cartSummary() {
                console.log("cartSummary")
                const currencySymbol = "{{ $general->cur_sym }}";
                let subtotal = 0;

                // Loop through all product rows and sum the subtotals
                $('tr').each(function () {
                    const row = $(this);
                    const subtotalText = row.find('.subtotal').text().trim();
                    if (subtotalText.includes(currencySymbol)) {
                        const amount = parseFloat(subtotalText.replace(currencySymbol, '').replace(/,/g, '')) || 0;
                        subtotal += amount;
                    }
                });

                // Get tax from data attribute
                const taxElement = $('.tax-amount');
                const tax = parseFloat(taxElement.data('tax')) || 0;

                // Get discount from DOM
                const discountText = $('.discount-price').text().trim();
                const discount = parseFloat(discountText.replace(currencySymbol, '').replace(/,/g, '')) || 0;

                // Final calculation
                const grandTotal = subtotal + tax - discount;

                // Update values in the summary
                $('.subtotal-price').text(currencySymbol +  subtotal.toFixed(2));
                $('.tax-amount').text(currencySymbol + tax.toFixed(2));
                $('.discount-price').text(currencySymbol + discount.toFixed(2));
                $('.total-price').text(currencySymbol + grandTotal.toFixed(2));
            }

            function CartCalculation(currentRow) {
                const productNameEl = currentRow.find('.productName');
                const productId = productNameEl.data('product_id');
                const colorId = productNameEl.data('color_id');
                const quantity = parseInt(currentRow.find('input[name="quantity"]').val(), 10) || 1;

                // Extract price value safely
                const priceText = currentRow.find('.price').text().trim();
                const currencySymbol = "{{ $general->cur_sym }}";
                const priceParts = priceText.split(currencySymbol);

                if (priceParts.length < 2) {
                    console.warn("Invalid price format:", priceText);
                    return;
                }

                const unitPrice = parseFloat(priceParts[1]) || 0;
                const totalPrice = (quantity * unitPrice).toFixed(2);

                // Update subtotal in UI
                currentRow.find('.subtotal').text(currencySymbol + totalPrice);

                // Hide coupon and reset
                $('.coupon-show, .total-show').addClass('d-none');
                $('.coupon').val('');

                // Update subtotal summary
                subTotal();

                // AJAX call to update cart in backend
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('update-cart') }}",
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        color_id: colorId
                    },
                    success: function (response) {
                        if (response.success) {
                            currentRow.find('.error').hide();
                            notify('success', response.success);
                        } else {
                            notify('error', response.error);
                            currentRow.addClass('border border-danger');
                            currentRow.find('.error')
                                .text("Maximum " + response.maxQty + " quantity allowed")
                                .show();
                            currentRow.find('input[name="quantity"]').val(response.maxQty);
                            currentRow.find('.subtotal').text(currencySymbol + (response.maxQty * unitPrice).toFixed(2));

                        }
                    },
                    error: function (xhr) {
                        console.error("Cart update failed:", xhr);
                        notify('error', 'An error occurred while updating the cart.');
                    }
                });
            }

            getCartCount();

            function getCartCount() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-cart-count') }}",
                    success: function(response) {
                        $('.show-cart-count').text(response);
                    }
                });
            }
            subTotal();

            function subTotal() {
                console.log("subTotal");
                var totalArr = [];
                var subtotal = 0;
                
                $('.cart-table tr').each(function(index, tr) {
                    $(tr).find('td').each(function(index, td) {
                        $(td).find('.subtotal').each(function(index, value) {
                            var productPrice = $(value).text();
                            var splitPrice = productPrice.split("{{ $general->cur_sym }}");
                            console.log(parseFloat(splitPrice[1]));
                            var price = parseFloat(splitPrice[1]);
                            totalArr.push(price);
                        });
                    });
                });
                for (var i = 0; i < totalArr.length; i++) {
                    subtotal += totalArr[i];
                }
                var tax = $('.cart-summary').find('.tax-amount').data('tax');
                var carttotal = (parseInt(subtotal) + parseInt(tax)).toFixed(2);
                $('.subtotal-price').text("{{ $general->cur_sym }}" + subtotal.toFixed(2));
                $('.total-price').text("{{ $general->cur_sym }}" + carttotal);
            }

            let removeableItem = null;
            let modal = $('#removeCartModal');

            $('.remove-btn').on('click', function() {
                removeableItem = $(this).closest("tr");
                modal = $('#removeCartModal');
                modal.modal('show');
            });

            $(".remove-product").on('click', function() {
                let product_id = removeableItem.find('.productName').data('product_id');
                let color_id = removeableItem.find('.productName').data('color_id');
                $('.coupon-show').addClass('d-none')
                $('.total-show').addClass('d-none')
                $('.coupon').val('');
                $.ajax({
                    method: "GET",
                    url: "{{ route('delete-cart') }}",
                    data: {
                        product_id: product_id,
                        color_id: color_id
                    },
                    success: function(response) {
                        if (response.success) {
                            subTotal();
                            getCartCount();
                            notify('success', response.success);
                            removeableItem.remove();
                            $(".cart-section-2").css("display", "none");
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
                modal.modal('hide');
            });

            $('.coupon-apply').click(function(e) {
                e.preventDefault();
                let coupon = $('.coupon').val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('coupon-apply') }}",
                    data: {
                        coupon: coupon
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response)
                            notify('success', response.success);
                            $('.coupon-show').removeClass('d-none')
                            $('.total-show').removeClass('d-none')
                            let total = parseFloat(response.totalAmount).toFixed(2);
                            let subtotal = parseFloat(response.subtotal).toFixed(2);
                            let discount = parseFloat(response.discount).toFixed(2);
                            let totaltax = parseFloat(response.totaltax).toFixed(2);
                            $('.discount-price').text("{{ $general->cur_sym }}" + discount);
                            $('.subtotal-price').text("{{ $general->cur_sym }}" + subtotal);
                            $('.tax-amount').text("{{ $general->cur_sym }}" + totaltax);
                            $('.total-price').text("{{ $general->cur_sym }}" + total);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });

            })
        })(jQuery);
    </script>
@endpush