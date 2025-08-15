<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/arsh/css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/arsh/css/main.css') }}" />
   
     <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
<style>
.topspace{margin-top:20px;}

.btn, .btn--primary{
    
    font-size: 33px;
    padding: 40px;
}
.card-body {
    text-align: center;
}
.card-title {
    font-size: 50px;
    margin-bottom: var(--bs-card-title-spacer-y);
}
.h-100 {
    height: 100% !important;
    font-size: 30px;
}
body {
    font-family: "Open Sans", sans-serif;
    font-weight: 400;
    color: #333;
    font-size: 29px;
    line-height: 1.75;
    width: 100%;
    background: #fff;
}
@media (min-width: 576px) {
    .price {
        font-size: 29px;
    }
}
</style>
</head>
<body>

<div class="row justify-content-left g-4 topspace" >
    @foreach($gatewayCurrency as $data)
    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 co-xxl-6">
        <div class="card card cmn--card bg--body">
            <div class="card-header text-center bg--base">
                <h6 class="card-title">{{__($data->name)}}</h6>
            </div>
            <div class="card-body">
                <img src="{{$data->methodImage()}}" alt="{{__($data->name)}}">
            </div>

            <div class="card-footer text-center">
                <a href="javascript:void(0)" data-id="{{$data->id}}" data-name="{{$data->name}}"
                    data-currency="{{$data->currency}}" data-method_code="{{$data->method_code}}"
                    data-min_amount="{{showAmount($data->min_amount)}}"
                    data-max_amount="{{showAmount($data->max_amount)}}" data-base_symbol="{{$data->baseSymbol()}}"
                    data-fix_charge="{{showAmount($data->fixed_charge)}}"
                    data-percent_charge="{{showAmount($data->percent_charge)}}" data-price="{{ $order->total }}"
                    data-bs-toggle="modal" data-bs-target="#depositModal"
                    class="btn btn--primary custom-success deposit">@lang('Payment Now')</a>
            </div>
        </div>
    </div>
    @endforeach
</div>


<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg--base">
                <strong class="modal-title method-name" id="depositModalLabel"></strong>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{route('api.deposit.insert')}}" method="post">
                @csrf
                <div class="modal-body">
                    <p class="text-danger depositLimit"></p>
                    <p class="text-danger depositCharge"></p>
                    <div class="form-group">
                        <input type="hidden" name="currency" class="edit-currency">
                        <input type="hidden" name="method_code" class="edit-method-code">
                    </div>
                    <div class="form-group">
                        <label class="text-dark">@lang('Order Amount'):</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg price" name="amount"
                                placeholder="@lang('Amount')" required value="{{old('amount')}}" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text h-100">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--primary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>


    <script src="{{ asset($activeTemplateTrue.'js/main.js') }}"></script>

        <!-- Use Minified Plugins Version For Fast Page Load -->
    <script src="{{ asset('assets/arsh/js/plugins.js')}}"></script>
    <script src="{{ asset('assets/arsh/js/ajax-mail.js')}}"></script>
    <script src="{{ asset('assets/arsh/js/custom.js')}}"></script>

<script>
    (function ($) {
            "use strict";
            $('.deposit').on('click', function () {
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');
                var price = $(this).data('price');

                var depositLimit = `@lang('Payment Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;

                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
                $('.price').val(parseFloat(price).toFixed(2));
            });
        })(jQuery);
</script>




<style type="text/css">

</style>
</body>
</html>