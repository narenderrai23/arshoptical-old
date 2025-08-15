
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






<!-- @php

$brands = App\Models\Brand::where('status',1)->where('featured',1)->latest()->take(8)->get();

@endphp

<section class="top-brands-section pb-60">

    <div class="container-fluid">


        <div class="row">
            <div class="col-md-6">
                <div class="card bgsnonbs">
                  <img class="card-img-top" src="public/assets/images/frontend/banner/titanium_Banner_Desktop.jpg" alt="Card image cap">
                  <div class="card-body vvCdasr text-center">
                    <h5 class="card-title">TITANIUM COLLECTION </h5>
                        <br> MADE IN JAPAN.  </h5>
                    <p class="card-text">Even lighter,even stronger,equally timeless. <br>Discover our collection made in Japan.  </p> -->
                <!--     <br>
                    <a href="#" class=" smaeButtonsSp">Shop Titanium</a>
                  </div>
                </div>
            </div>
             <div class="col-md-6">
                <div class="card bgsnonbs">
                  <img class="card-img-top" src="https://india.ray-ban.com/pub/media/wysiwyg/Rb_home_opti/09_RB_Website_HomePage_Kids_Banner_Desktop.jpg" alt="Card image cap">
                  <div class="card-body vvCdasr text-center">
                    <h5 class="card-title">KIDS, YOU'RE ON </h5> 
                    <br> MADE IN JAPAN.  </h5>
                    <p class="card-text">Even lighter,even stronger,equally timeless. <br>Discover our collection made in Japan.  </p> -->
                  <!--   <br>
                    <a href="#" class=" smaeButtonsSp">Shop Titanium</a>
                  </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="row gy-5">

           <div class="col-lg-12">

                <div class="section__header1">

                    <h5 class="title">@lang('Our Brands')</h5>

                   

                </div>

                <div class="row g-3">

                    @foreach ($brands as $brand)

                    <div class="col-sm-3">

                        <a class="brand__item"

                            href="{{ route('brand.products',['id'=>$brand->id,'name'=>slug($brand->name)]) }}">

                            <div class="brand__item-img">

                                <img src="{{ getImage(imagePath()['brand']['path'].'/'. $brand->image,imagePath()['brand']['size']) }}" alt="products">

                            </div>

                            <div class="brand__item-cont">

                                <span>{{ __($brand->name) }}</span>

                                <span><i class="las la-angle-right"></i></span>

                            </div>

                        </a>

                    </div>

                    @endforeach

                </div>

                 <div class="view-all">

                        <a href="{{ route('all.brands') }}" class="view--all">@lang('Show All')</a>

                    </div>

            </div>

           

        </div> -->

<!--     </div>

</section>  -->