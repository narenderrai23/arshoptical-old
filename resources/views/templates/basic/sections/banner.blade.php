@php

$sliders = getContent('banner.element',false,null,true);

@endphp


<section class="hero-area hero-slider-3">
            <div class="sb-slick-slider" data-slick-setting='{
                                                        "autoplay": true,
                                                        "autoplaySpeed": 8000,
                                                        "slidesToShow": 1,
                                                        "dots":true
                                                        }'>

               @foreach ($sliders as $slider)

                   <div class="single-slide bg-image" data-bg="{{ getImage('assets/images/frontend/banner/'.$slider->data_values->image,'1292x550') }}">
                    <div class="container">
                        <div class="home-content pl--30">
                            <div class="row">
                                <!-- <div class="col-lg-6">
                                    <h1>I Love This Idea!</h1>
                                    <h2>Cover up front of book and
                                        <br>leave summary</h2>
                                    <a href="shop-grid.html" class="btn btn--yellow">
                                        Shop Now
                                    </a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                     @endforeach
                
            </div>
        </section>

