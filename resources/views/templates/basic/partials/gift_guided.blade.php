<style>
    .bt-width{width: 100% !important;};
@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
.promo-wrapper.promo-type-three{height: 70px !important;}

}</style>


@php

$brands = App\Models\Brand::where('status',1)->where('featured',1)->latest()->take(8)->get();

@endphp

 <!--=================================
  Brands Slider
===================================== -->
    <section class="section-margin">
        <h2 class="sr-only">Brand Slider</h2>
        <div class="container">
            <div class="brand-slider sb-slick-slider" data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 3000,
                                            "slidesToShow": 5
                                            }' data-slick-responsive='[
                {"breakpoint":992, "settings": {"slidesToShow": 4} },
                {"breakpoint":768, "settings": {"slidesToShow": 3} },
                {"breakpoint":575, "settings": {"slidesToShow": 3} },
                {"breakpoint":480, "settings": {"slidesToShow": 2} },
                {"breakpoint":320, "settings": {"slidesToShow": 1} }
            ]'>

               @foreach ($brands as $brand)
                <div class="single-slide">
                    <a href="{{ route('brand.products',['id'=>$brand->id,'name'=>slug($brand->name)]) }}"><img src="{{ getImage(imagePath()['brand']['path'].'/'. $brand->image,imagePath()['brand']['size']) }}" alt=""></a>
                </div>
               @endforeach
            </div>
        </div>
    </section>




<section class="section-padding mt--30">
     <h2 class="sr-only">Home Tab Slider Section</h2>
        <div class="container">
             <div class="sb-custom-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    @foreach ($cats as  $key  => $row)

                        <li class="nav-item ">
                            <a
                                class="nav-link {{ $key == 0 ? 'active' : ''}}" id="shop-tab" 
                                data-bs-toggle="tab" href="#producttab-{{$key}}" role="tab"
                                aria-controls="shop" aria-selected="true"
                            >{{$row->name}} </a>
                            <span class="arrow-icon"></span>
                        </li>
                       
                


                     @endforeach

                   
                    </ul>

                  <div class="tab-content" id="myTabContent">

                  @foreach ($cats as  $key  => $row)

                    @include('templates.basic.partials.gift_guided_html', [
                        'category' => $row , 'index' => $key
                    ])

                  @endforeach
        
                    </div>

                       
           

                </div>
            </div>
        </section>

           @php

            $sub_cats = App\Models\SubCategory::where('best_seller','1')->where('status',1)->first();
                       
            @endphp

        <section class="section-margin bg-image section-padding-top section-padding" data-bg="/image/bg-images/best-seller-bg.jpg" style="background-size: contain;background-position: inherit;background-image:url(/image/bg-images/best-seller-bg.jpg)">
	
            <div class="container">
                <div class="section-title section-title--bordered mb-0">
                    <h2>BEST SELLER</h2>
                </div>
                <div class="best-seller-block">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="author-image">
                                <a href="{{ route('subcategory.products',['id'=>$sub_cats->id,'name'=>slug($sub_cats->name)]) }}">
                                <img src="{{ getImage(imagePath()['category']['path'] . '/' . $sub_cats->image, imagePath()['category']['size']) }}" alt="">
                            </a>

                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="sb-slick-slider product-slider product-list-slider multiple-row slider-border-multiple-row"
                                data-slick-setting='{
                                    "autoplay": true,
                                    "autoplaySpeed": 3000,
                                    "slidesToShow":2,
                                    "rows":2,
                                    "dots":true
                                }' data-slick-responsive='[
                                    {"breakpoint":1200, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":992, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":768, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                ]'>

                                   @php

                                 $prods = App\Models\Product::where('subcategory_id',$sub_cats->id)->where('status',1)->get();
                       
                                 @endphp
                                    @foreach($prods as $item)
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <a href="{{ route('product.detail', ['id' => $item->id, 'name' => slug($item->slug)]) }}">
                                        <div class="card-image">
                                            <img src="{{ getImage(imagePath()['product']['thumb']['path'] . '/' . $item->image, imagePath()['product']['thumb']['size']) }}" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <!-- a href="#" class="author">
                                                    Rpple
                                                </a> -->
                                                <h3>{{$item->name}} {{$item->model_no}}
                                  </a></h3>
                                            </div>
                                            <div class="price-block">
                                                <a target="_blank" rel="noreferrer" href="/public/pdf?link={{  $sub_cats->pdf }}" class="btn btn--primary submenu-btn bt-width">PDF</a>
                                                 @auth
                                                 <span class="price">{{ $general->cur_sym }}{{ showAmount($item->price) - userDiscountWeb($item->price)}}</span>
                                                 @else
                                                <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn bt-width" >Price</a>
                                                 @endauth
                                              
                                               <!--  <del class="price-old">{{(int)$item->price}}</del>
                                                <span class="price-discount">{{(int)$item->discount}}%</span> -->
                                            </div>
                                        </div>
                                    </a>
                                    </div>
                                </div>

                                 @endforeach

                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


@php

$advertise = getContent('advertise.element',false,null,true);

@endphp
        <section class="section-margin">
            <h1 class="sr-only">Promotion Section</h1>
            <div class="container">
                <div class="row">
                   
                     @foreach ($advertise as $slider)
                    
                    
                    <div class="col-lg-6">
                        <div class="promotion-new">
                        <a href="{{ $slider->data_values->url }}" class="promo-image promo-overlay" style="height:100%;">
                            <img src="{{ getImage('assets/images/frontend/advertise/'.$slider->data_values->image,'900x302') }}" alt="" style="height:100%;">
                        </a>
                    </div>

                    </div>
                       @endforeach
                </div>
            </div>
        </section>

            @php

            $s_offer = App\Models\SubCategory::where('special_offer','1')->where('status',1)->orderBy('orderno')->take(3)->get();
                       
            @endphp

           <section class="bg-gray section-padding-top section-padding-bottom section-margin">
            <h1 class="sr-only">Promotion Section</h1>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="home-left-side text-center text-lg-left">
                       
                            <div class="single-block text-center">
                                <h3 class="home-sidebar-title style-2">
                                    Special offer
                                </h3>
                                <div class="product-slider countdown-single with-countdown sb-slick-slider product-border-reset"
                                    data-slick-setting='{
                                                "autoplay": true,
                                                "autoplaySpeed": 3000,
                                                "slidesToShow": 1,
                                                "dots":true
                                            }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":768, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                        ]'>

                                        @foreach($s_offer as $offer)
                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <!-- <a href="" class="author">
                                                    Ypple
                                                </a> -->
                                                <h3><a href="{{ route('subcategory.products',['id'=>$offer->id,'name'=>slug($offer->name)]) }}">{{$offer->name}}</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <img src="{{ getImage(imagePath()['category']['path'] . '/' . $offer->image, imagePath()['category']['size']) }}" alt="">
                                                    <div class="hover-contents">
                                                        <a href="{{ route('subcategory.products',['id'=>$offer->id,'name'=>slug($offer->name)]) }}" class="hover-image">
                                                            <img src="{{ getImage(imagePath()['category']['path'] . '/' . $offer->image, imagePath()['category']['size']) }}" alt="">
                                                        </a>
                                                       <!--  <div class="hover-btns">
                                                            <a href="add-to-cart.html" class="single-btn">
                                                                <i class="fas fa-shopping-basket"></i>
                                                            </a>
                                                            <a href="wishlist.html" class="single-btn">
                                                                <i class="fas fa-heart"></i>
                                                            </a>
                                                            <a href="compare.html" class="single-btn">
                                                                <i class="fas fa-random"></i>
                                                            </a>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quickModal"
                                                                class="single-btn">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                   <a target="_blank" rel="noreferrer" href="/public/pdf?link={{$offer->pdf }}" class="btn btn--primary submenu-btn">PDF</a>
                                                    @auth
                                                 <span class="price">{{ $general->cur_sym }}{{ showAmount($offer->price) - userDiscountWeb($offer->price)}}</span>
                                                 @else
                                                <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">Price</a>
                                                 @endauth
                                                  <!--   <del class="price-old">{{$offer->price}}</del>
                                                    <span class="price-discount">{{$offer->discount}}%</span> -->
                                                </div>
                                                <div class="count-down-block">
                                                    <!-- <div class="product-countdown" data-countdown="01/05/2020"></div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-lg-8">
    
                            <div class="single-block">
                                <div class="home-right-block bg-white">
                                    <div class="sb-custom-tab text-lg-left text-center">
                                        <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                                             @foreach($s_offer as  $key  => $offer)
                                            <li class="nav-item">

                                                <a class="nav-link {{ $key == 0 ? 'active' : ''}}" id="shop-tab2" data-bs-toggle="tab"
                                                    href="#shop{{$key}}" role="tab" aria-controls="shop2" aria-selected="true">
                                                    {{$offer->name}}
                                                </a>
                                            </li>
                                            @endforeach
                                            
                                        </ul>
                                        <div class="tab-content" id="myTabContent2">
                                            @foreach($s_offer as  $key  => $row)
                                            <div class="tab-pane {{ $key == 0 ? 'show active' : ''}}" id="shop{{$key}}" role="tabpanel"
                                                aria-labelledby="shop-tab2">
                                                <div class="product-slider product-list-slider multiple-row slider-border-multiple-row  sb-slick-slider"
                                                    data-slick-setting='{
                                                        "autoplay": true,
                                                        "autoplaySpeed": 3000,
                                                        "slidesToShow": 2,
                                                        "rows":4,
                                                        "dots":true
                                                    }' data-slick-responsive='[
                                                        {"breakpoint":992, "settings": {"slidesToShow": 2,"rows": 3} },
                    
                                                        {"breakpoint":768, "settings": {"slidesToShow": 1} }
                                                    ]'>

                         @include('templates.basic.partials.gift_guided_special', ['row' => $row])
                                             
                                                </div>
                                            </div>
                                            @endforeach
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>



       <section class="mb--70 space-dt--30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="text">
                                <h5>Excellent Quality</h5>
                                <p> 100% replacement</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-redo-alt"></i>
                            </div>
                            <div class="text">
                                <h5>Money Back Guarantee</h5>
                                <p>100% money back</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div class="text">
                                <h5>Accept Payment</h5>
                                <p>Visa, Master Card, UPI</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-life-ring"></i>
                            </div>

			@php
				$headerContent = getContent('contact_us.content',true);
			@endphp
                            <div class="text">
                                <h5>Help & Support</h5>
                                <p>Call us : {{ __(@$headerContent->data_values->contact_number) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=================================-->
      
@php

$bestselling = getContent('bestseller.element',false,null,true);

@endphp






               @foreach ($bestselling as  $key  =>  $slider)

	@if($key==0)
                 <section class="section-margin" style="margin-bottom:0px !important">
            <div class="promo-wrapper promo-type-three">
                <a href="#" class="promo-image promo-overlay bg-image">

                    <img src="{{ getImage('assets/images/frontend/bestseller/'.$slider->data_values->image,'1920x400') }}">


                </a>
                <div class="promo-text w-100 ml-0">
                    <div class="container">
                        <div class="row w-100">
                           <!--  <div class="col-lg-7">
                                <h2>I Love This Idea!</h2>
                                <h3>Cover up front of book and
                                    leave summary</h3>
                                <a href="#" class="btn btn--yellow">$78.09 - Learn More</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
	@endif
                 

                     @endforeach