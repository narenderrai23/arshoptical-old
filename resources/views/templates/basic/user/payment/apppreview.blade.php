<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/arsh/css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/arsh/css/main.css') }}" />
   
     <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
<style>
.deposit-content{width:100% !important;}
li {
    
    font-size: 30px !important;
   
}
.btn{font-size: 30px !important;}
</style>
</head>
<body>

<div class="deposit-preview cmn--card">
    <div class="">
        <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('Image')">
    </div>
    <div class="deposit-content">
        <ul>
            <li>
                @lang('Amount:') <span class="text--success">{{showAmount($data->amount)}}
                    {{__($general->cur_text)}}</span>
            </li>
            <li>
                @lang('Charge:') <span class="text--danger">{{showAmount($data->charge)}}
                    {{__($general->cur_text)}}</span>
            </li>
            <li>
                @lang('Payable:') <span class="text--warning">{{showAmount($data->amount + $data->charge)}}
                    {{__($general->cur_text)}}</span>
            </li>
            <li>
                @lang('Conversion Rate:')
                <span class="text--info">
                    1 {{__($general->cur_text)}} @lang('=') {{showAmount($data->rate)}}
                    {{__($data->baseCurrency())}}
                </span>
            </li>
            <li>
                @lang('In') {{$data->baseCurrency()}}: <span
                    class="text--primary">{{showAmount($data->final_amo)}}</span>
            </li>
        </ul>
        @if( 1000 >$data->method_code)
        <a href="{{route('api.deposit.confirm')}}" class="btn btn--primary w-100">@lang('pay now')</a>
        @else
        <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn--primary w-100">@lang('Pay Now')</a>
        @endif
    </div>
</div>
<script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>


    <script src="{{ asset($activeTemplateTrue.'js/main.js') }}"></script>

        <!-- Use Minified Plugins Version For Fast Page Load -->
    <script src="{{ asset('assets/arsh/js/plugins.js')}}"></script>
    <script src="{{ asset('assets/arsh/js/ajax-mail.js')}}"></script>
    <script src="{{ asset('assets/arsh/js/custom.js')}}"></script>




<style type="text/css">

</style>
</body>
</html>