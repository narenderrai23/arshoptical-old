@extends('admin.layouts.app')

@section('panel')
<div class="row mb-none-30">
    <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body p-0">
                <div class="p-3 bg--white">
                    <div class="">
                        <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$order->user->image, imagePath()['profile']['user']['size']) }}"
                            alt="@lang('Profile Image')" class="b-radius--10 w-100">
                    </div>
                    <div class="mt-15">
                        <h4 class="">{{ @$order->user->fullname }}</h4>
                        <p class="">{{ @$order->user->email }}</p>
 <p class="">{{ @$order->user->mobile}}</p>
                        <span class="text--small">@lang('Joined At')
                            <strong>{{ showDateTime(@$order->user->created_at, 'd M, Y h:i A') }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 text-muted">@lang('Action')</h5>
                <a href="{{ route('admin.orders.invoice',$order->id) }}" class="btn btn--primary btn--shadow btn-block btn-lg" target="_blank">
                    @lang('Print Invoice')
                </a>
                <a href="{{ route('admin.users.email.single', @$order->user->id) }}" class="btn btn--info btn--shadow btn-block btn-lg">
                    @lang('Send Email')
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
        <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
    <h5 class="card-title border-bottom pb-3 mb-0">@lang('Order detail of') {{ __($order->order_no) }}</h5>
    <span class="text-right">
        <a class="edit-btn btn btn-link"><i style="font-size: 15px;
    color: blue;" class="fa fa-pencil" aria-hidden="true"></i>
    </a>
    <button class="btn btn-info update-info">Update</button>
</span>
</div>
                <div class="row g-3 my-5">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Order No')
                                <span class="font-weight-bold">{{ __($order->order_no) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Total Price')
                                <span class="font-weight-bold">{{ showAmount($order->total) }} {{ $general->cur_text }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Payment')
                                @if ($order->payment_type == 1)
                                <span class="font-weight-bold">{{ __(@$order->deposit->gateway->name) }} @lang('payment gateway')</span>
                                @else
                                <span class="font-weight-bold">@lang('Advance Payment')</span>
                                @endif  
                            </li>
                            @if (@$order->deposit->trx)   
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Payment Trx')
                                <span class="font-weight-bold">{{ @$order->deposit->trx }}</span>
                            </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Order Date')
                                <span class="font-weight-bold">{{ showDateTime($order->created_at) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Order Status')
                                @php
                                    echo $order->StatusText
                                @endphp
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Shipping Area')
                                <span class="font-weight-bold">{{ __(@$order->shipping->name) }}</span>
                            </li>
                            @if($order->discount != 0) 
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Coupon')
                                <span class="font-weight-bold">{{ __(@$order->coupon->name) }}</span>
                            </li>
                           
                            @endif
                            @php
                                $address = json_decode($order->address);
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Delivery Address')
                                <span class="font-weight-bold label-span">
                                    {{ __($address->address) }}
                                </span>
                                <span class="input-span">
                                <input type="hidden" id="order_id" value="{{ $order->id }}">
                                    <input style="height: 29px; width: 156px;" class="form-control font-weight-bold address" type="text" 
                                value="{{ __($address->address) }}"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Country & State')
                                <span class="font-weight-bold label-span">
                                    {{ __($address->country) }} @lang('&') {{ __($address->state) }}
                                </span>
                                <span class="input-span"> 
                                    <select name="" class="country" style="width: 154px!important; height: 30px; padding: 0px 21px!important;">

                                    @foreach ($countries as $country)
                                    <option value="{{ $country->country }}" @if($country->country=='India') selected="selected" @endif @if(old('country')==$country->country) selected="selected" @endif>
                                            {{__($country->country) }}
                                        </option>
                                        @endforeach
                                       
                                </select> 
                                <span class="input-span">
                                    <input style="height: 29px; width: 156px;" class="form-control font-weight-bold state" type="text" 
                            value="{{ __($address->state) }}"></span>
                            </span>
                            
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('City & Zip')
                                <span class="font-weight-bold">
                                    {{ __($address->city) }} @lang('&') {{ __($address->zip) }}
                                </span>
                                <span class="input-span">
                                    <input style="height: 29px; width: 156px;" class="form-control font-weight-bold city" type="text" 
                                value="{{ __($address->city) }}">
                                <span class="input-span"><input style="height: 29px; width: 156px;" class="form-control font-weight-bold zipcode" type="text" 
                                value="{{ __($address->zip) }}"></span>
                            </span>
                                

                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Payment Status')
                                @php
                                    echo $order->PaymentText
                                @endphp
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Subtotal')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->orderDetail as $detail)
                            <tr>
                                @php
                               
                                @endphp
                                <td data-label="@lang('Product Name')">
                                    <a href="javascript:void(0)" class="text--dark">
                                           {{ __(@$detail->product->name .' '. $detail->product->model_no .' '. $detail->color) }}
                                    </a><br>
                                    @if (@$detail->product->digital_item == 1)
                                        @if(@$detail->product->file_type == 1)
                                        <a href="{{ route('admin.product.digital.file.download', @$detail->product->id) }}" class="text--info">
                                            <i class="las la-file"></i> @lang('Digital file')
                                        </a>
                                        @elseif(@$detail->product->file_type == 2)
                                            <a href="{{ @$detail->product->digi_link }}" target="_blank" class="text--info">@lang('Digital file link')</a>
                                        @endif
                                    @endif
                                </td>
                                <td data-label="@lang('Quantity')">
                                <span class="input-span ">
                                    <input style="height: 29px; width: 46px; padding:6px; 6px!important;" id="{{$detail->id}}" class="cart-increase form-control font-weight-bold" type="number" 
                                value="{{ $detail->quantity }}"></span>
                                    <strong class="label-span">{{ $detail->quantity }}</strong>
                                </td>

                                <td data-label="@lang('Price')">
                                    <strong class="">{{ showAmount($detail->price) }} {{ $general->cur_text }}</strong>
                                    <span class="input-span">
                                   <input type="hidden" class="real-price{{ $detail->id }}" 
                                    value="{{ showAmount($detail->price) }}">

                                    <input type="hidden" id="price{{$detail->id}}" 
                                    value="{{ showAmount($detail->price) }}">
                                    
                                </td>

                                <td data-label="@lang('Subtotal')">
                                    <span style="display:none" class="subtotal-input">{{ showAmount($detail->price * $detail->quantity) }}</span>
                                    <strong class="subtotal-label price-label{{$detail->id}}">{{ showAmount($detail->price * $detail->quantity) }} {{ $general->cur_text }}</strong>
                                    <input type="hidden" class="real-rs" 
                                    value="{{ showAmount($detail->price) }}">
                                    <a href="{{ url('admin/orders/detail-delete/'. $detail->id) }}" style="margin-left: 20px; font-size: 18px; color: red;"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td data-label="@lang('Subtotal')">
                                    <span>@lang('Subtotal :')</span>
                                    <strong class="price-label"> {{ showAmount($order->subtotal) }} {{ $general->cur_text }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td data-label="@lang('Shipping Charge')">
                                    <span>@lang('Shipping Charge :')</span>
                                    <strong class="shipping-text"> {{ showAmount($order->shipping_charge) }} {{ $general->cur_text }}</strong>
                                    <input type="hidden" class="shipping-input" value="{{ showAmount($order->shipping_charge) }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td data-label="@lang('Discount')">
                                    <span>@lang('Discount :')</span>
                                    <strong class="text-dicount"> {{ showAmount($order->discount) }} {{ $general->cur_text }}</strong>
                                    <input type="hidden" class="input-dicpunt" value="{{ showAmount($order->discount) }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td data-label="@lang('Total')">
                                    <span>@lang('GST :')</span>
                                    <strong class="text-gst"> {{ showAmount($order->tax) }} {{ $general->cur_text }}</strong>
                                    <input type="hidden" class="input-gst" value="{{ showAmount($order->tax) }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <input type="hidden" id="total" value="{{ showAmount($order->total) }}">
                                <td data-label="@lang('Total')"><span>@lang('Total :')</span><strong class="total-tex"> {{ showAmount($order->total) }} {{ $general->cur_text }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<a href="{{ route('admin.orders.all') }}" class="btn btn-sm btn--primary"><i class="las la-undo"></i> @lang('Back')</a>
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
function addOrUpdate(dataval, id, qty) {
    const index = dataval.findIndex(item => item.id === id);
    
    if (index !== -1) {
        // Update existing object
        dataval[index].qty = qty;
    } else {
        // Add new object
        dataval.push({ id: id, qty: qty });
    }
}
    $(document).ready(function() {
        $(".input-span").css("display","none");
        $(".update-info").css("display","none");
    $(".edit-btn").on('click', function() { 
        $(".label-span").toggle();
        $(".input-span").toggle();
        $(".update-info").toggle();
    });
var dataval=[];
    $('.cart-increase').change(function(){
        var qty = $(this).val();
        var id = $(this).attr('id');
        var subTotal = 0;

        addOrUpdate(dataval, id, qty);
        var price = $(".real-price"+id).val();

        $(".price-label"+id).text(price*qty+' Rs');
        $(".price-label"+id).closest('td').find('.real-rs').val(price*qty);

        $(".real-rs").each(function(){
            subTotal += parseFloat($(this).val());  
        });
        $(".price-label").text(subTotal.toFixed(2)+' Rs');

        // var subTotalAll = price*qty;

        var shippingcharge = $(".shipping-input").val();
        // shipping-text
        var gstAmount = (subTotal * 12) / 100;
                        $(".text-gst").text(gstAmount.toFixed(2)+' Rs');
                        $(".input-gst").val(gstAmount.toFixed(2));
        var discpunt = $(".input-dicpunt").val();

        var total = parseFloat(subTotal)+parseFloat(shippingcharge)-parseFloat(discpunt)+parseFloat(gstAmount);
        // alert(total);
        $("#total").val(total.toFixed(2));
        $(".total-tex").text(total.toFixed(2)+' Rs');
        });
        
               
        
        $(".update-info").on('click',function(){
            var qty = $(".cart-increase").val();

            var address = $(".address").val();
            var country = $(".country").val();
            var state = $(".state").val();
            var city = $(".city").val();
            var zipcode = $(".zipcode").val();
            var orderId = $("#order_id").val();
    $.ajax({
        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
        method: "POST",
        url: "{{ url('admin/orders/detail-update') }}",
        data: {address:address,qty:qty,country:country,state:state,city:city,zipcode:zipcode,dataqty:dataval,orderId:orderId},
        success: function (response) {
            if(response.success) {
                $(".update-info").css('display','None');
                notify('success', response.success);
            }else{
                notify('error', response.error);
            }
        }
    });

});
});
</script>