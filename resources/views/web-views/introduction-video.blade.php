@extends('layouts.front-end.app')

@section('title','Introduction Video')

@push('css_or_js')
<style>
    .headerTitle {
        font-size: 25px;
        font-weight: 700;
        margin-top: 2rem;
    }

    .for-container {
        width: 91%;
        border: 1px solid #D8D8D8;
        margin-top: 3%;
        margin-bottom: 3%;
    }

    .for-padding {
        padding: 3%;
    }
</style>

<meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}" />
<meta property="og:title" content="About {{$web_config['name']->value}} " />
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

<meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}" />
<meta property="twitter:title" content="about {{$web_config['name']->value}}" />
<meta property="twitter:url" content="{{env('APP_URL')}}">
<meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
@endpush

@section('content')
<div class="container for-container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
    <h2 class="text-center mt-3 headerTitle">Introduction Video</h2>
    <div class="for-padding">
        <div class="px-4 pt-lg-3 pb-3 mb-3 mr-0 mr-md-2" style="background: #ffffff;border-radius:10px;min-height: 817px;">
            <div class="tab-content px-lg-3">
                <!-- Tech specs tab-->
                <div class="tab-pane fade active show" id="overview" role="tabpanel">
                    <div class="row pt-2 specification">
                        <div class="col-12 mb-4">
                            <iframe width="420" height="315" src="https://www.youtube.com/embed/i1HjJda3FvI">
                            </iframe>
                        </div>

                        <div class="text-body col-lg-12 col-md-12" style="overflow: scroll;">
                            <p>Fortune Soyabean Oil is made from high-quality soybeans and is 100% pure and natural. It is a rich source of essential nutrients and has a high smoke point, making it ideal for cooking and frying. The neutral taste and light texture of this oil make it perfect for all types of cooking, from frying to sautéing. It contains polyunsaturated and monounsaturated fats that are beneficial for heart health and help in reducing cholesterol levels. The 1-liter pack of Fortune Soyabean Oil is perfect for regular use in your kitchen. It is also a great option for those who are health-conscious and looking for a healthier cooking oil. Use Fortune Soyabean Oil for a healthy and delicious cooking experience.</p>
                        </div>
                    </div>
                </div>
                <!-- Reviews tab-->
               
            </div>
        </div>
    </div>
</div>
@endsection