
 <section class="section-padding mt--30">
            <h2 class="sr-only">Home Tab Slider Section</h2>
            <div class="container">
                <div class="sb-custom-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                       


@php
$i=1;
$slider='';
@endphp
 @foreach ($cats as $categoriesdate)

                        <li class="nav-item">
                            <a class="nav-link active" id="shop-tab" data-bs-toggle="tab" href="#producttab-1" role="tab"
                                aria-controls="shop" aria-selected="true">
                                {{($categoriesdate->name)}}
                            </a>
                            <span class="arrow-icon"></span>
                        </li>


                         <div class="tab-pane show active" id="producttab-$i" role="tabpanel" aria-labelledby="shop-tab">
                            <div class="product-slider multiple-row  slider-border-multiple-row  sb-slick-slider"
                                data-slick-setting='{
                            "autoplay": true,
                            "autoplaySpeed": 8000,
                            "slidesToShow": 5,
                            "rows":1,
                            "dots":true }' data-slick-responsive='[
                            {"breakpoint":1200, "settings": {"slidesToShow": 3} },
                            {"breakpoint":768, "settings": {"slidesToShow": 2} },
                            {"breakpoint":480, "settings": {"slidesToShow": 1} },
                            {"breakpoint":320, "settings": {"slidesToShow": 1} } ]'>
                        @php

                        $sub_cats = App\Models\SubCategory::where('category_id',$categoriesdate->id)->orderBy('orderno')->first();
                        $i++;
                        @endphp
                         <<<<--- Loop -->>>
                        @foreach ($sub_cats as $subcatdata)
                           @php
                                $slider.='<div class="single-slide">
                                    <div class="product-card">
                                        <div class="product-header">
                                            <a href="" class="author">
                                                jpple
                                            </a>
                                                <h3><a href="product-details.html">Rpple iPad with Retina Display
                                                        MD510LL/A</a></h3>
                                        </div>
                                        <div class="product-card--body">
                                            <div class="card-image">
                                                <img src="image/products/product-1.jpg" alt="">
                                                <div class="hover-contents">
                                                    <a href="product-details.html" class="hover-image">
                                                        <img src="image/products/product-1.jpg" alt="">
                                                    </a>
                                                    <div class="hover-btns">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">£51.20</span>
                                                <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>'
                                @endphp
                                 @endforeach
                            <<<---LLOP End -->>>
                            </div>
                        </div>


        <!--  <div class="col">
            <div class="roundcd">
               <a class="text-dark" href="{{ route('category.products',['id'=>$categoriesdate->id,'name'=>slug($categoriesdate->name)]) }}">
                  <img class="card-img-top roundcd_imgs" src="{{ getImage(imagePath()['category']['path'].'/'. $categoriesdate ->image,imagePath()['category']['size']) }}" alt="Card image cap">
                  <div class="card-body">
                     <p class="card-text">{{($categoriesdate->name)}}</p>
                  </div>
               </a>
            </div>
         </div> -->
         @endforeach


                       
                    </ul>
                    <div class="tab-content" id="myTabContent">
                   
                           @php
                          echo $slider;
                           @endphp

                      
                    </div>
                </div>
            </div>
        </section>


<!--==================BEST SELLER SECTION=================================================================-->
        <section class="section-margin bg-image section-padding-top section-padding"
            data-bg="image/bg-images/best-seller-bg.jpg">
            <div class="container">
                <div class="section-title section-title--bordered mb-0">
                    <h2>Best SELLER </h2>
                </div>
                <div class="best-seller-block">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="author-image">
                                <img src="image/others/best-seller-author.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="sb-slick-slider product-slider product-list-slider multiple-row slider-border-multiple-row"
                                data-slick-setting='{
                                    "autoplay": false,
                                    "autoplaySpeed": 8000,
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
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <div class="card-image">
                                            <img src="image/products/product-6.jpg" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <a href="#" class="author">
                                                    Rpple
                                                </a>
                                                <h3><a href="product-details.html">Do You Really Need It? This
                                                        Will Help You
                                  </a></h3>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">£51.20</span>
                                                <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <div class="card-image">
                                            <img src="image/products/product-1.jpg" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <a href="#" class="author">
                                                    Epple
                                                </a>
                                                <h3><a href="product-details.html">Here Is Quick Cure BOOK This
                                                        Will Help
                                                       
                                  </a></h3>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">£51.20</span>
                                                <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <div class="card-image">
                                            <img src="image/products/product-2.jpg" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <a href="#" class="author">
                                                    Wpple
                                                </a>
                                                <h3><a href="product-details.html">Do You Really Need It? This
                                                        Will Help You
                                                       
                                  </a></h3>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">£51.20</span>
                                                <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <div class="card-image">
                                            <img src="image/products/product-3.jpg" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <a href="#" class="author">
                                                    Ypple
                                                </a>
                                                <h3><a href="product-details.html">Very Simple Things You
                                                        Can Save BOOK
                                                       
                                  
                                                       
                                  </a>
                                                </h3>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">£51.20</span>
                                                <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <div class="card-image">
                                            <img src="image/products/product-5.jpg" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <a href="#" class="author">
                                                    Mople
                                                </a>
                                                <h3><a href="product-details.html">What You Can Learn From Bill Gates
                                                       
                                  </a></h3>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">£51.20</span>
                                                <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-slide">
                                    <div class="product-card card-style-list">
                                        <div class="card-image">
                                            <img src="image/products/product-4.jpg" alt="">
                                        </div>
                                        <div class="product-card--body">
                                            <div class="product-header">
                                                <a href="#" class="author">
                                                    Cpple
                                                </a>
                                                <h3><a href="product-details.html">3 Ways Create Better BOOK With
                                                        Help
                                                       
                                  </a></h3>
                                            </div>
                                            <div class="price-block">
                                                <span class="price">£51.20</span>
                                                <del class="price-old">£51.20</del>
                                                <span class="price-discount">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!--==================BEST SELLER SECTION ENDS=================================================================-->


<!--==================PROMOTION SECTION BEGINS=================================================================-->

        <section class="section-margin">
            <h1 class="sr-only">Promotion Section</h1>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <a href="" class="promo-image promo-overlay">
                            <img src="image/bg-images/s1.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a href="" class="promo-image promo-overlay" style="height:100%;">
                            <img src="image/bg-images/s2.jpg" alt="" style="height:100%;">
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="" class="promo-image promo-overlay">
                            <img src="image/bg-images/s3.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>



           <section class="section-margin">
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
                                                "autoplaySpeed": 8000,
                                                "slidesToShow": 1,
                                                "dots":true
                                            }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":768, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                        ]'>
                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <a href="" class="author">
                                                    Ypple
                                                </a>
                                                    <h3><a href="product-details.html">BOOK: Do You Really Need It? This
                                                            Will Help You</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <img src="image/products/product-2.jpg" alt="">
                                                    <div class="hover-contents">
                                                        <a href="product-details.html" class="hover-image">
                                                            <img src="image/products/product-1.jpg" alt="">
                                                        </a>
                                                        <div class="hover-btns">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">£51.20</span>
                                                    <del class="price-old">£51.20</del>
                                                    <span class="price-discount">20%</span>
                                                </div>
                                                <div class="count-down-block">
                                                    <div class="product-countdown" data-countdown="01/05/2020"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <a href="" class="author">
                                                    Upple
                                                </a>
                                                    <h3><a href="product-details.html">Here Is A Quick Cure For BOOK
                                                            This Will Help</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <img src="image/products/product-2.jpg" alt="">
                                                    <div class="hover-contents">
                                                        <a href="product-details.html" class="hover-image">
                                                            <img src="image/products/product-1.jpg" alt="">
                                                        </a>
                                                        <div class="hover-btns">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">£51.20</span>
                                                    <del class="price-old">£51.20</del>
                                                    <span class="price-discount">20%</span>
                                                </div>
                                                <div class="count-down-block">
                                                    <div class="product-countdown" data-countdown="01/05/2020"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <a href="" class="author">
                                                    Ypple
                                                </a>
                                                    <h3><a href="product-details.html">Simple Things
                                                            You Can Do Save BOOK save money</a>
                                                    </h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <img src="image/products/product-3.jpg" alt="">
                                                    <div class="hover-contents">
                                                        <a href="product-details.html" class="hover-image">
                                                            <img src="image/products/product-2.jpg" alt="">
                                                        </a>
                                                        <div class="hover-btns">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">£51.20</span>
                                                    <del class="price-old">£51.20</del>
                                                    <span class="price-discount">20%</span>
                                                </div>
                                                <div class="count-down-block">
                                                    <div class="product-countdown" data-countdown="01/05/2020"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <a href="" class="author">
                                                    Epple
                                                </a>
                                                    <h3><a href="product-details.html">What You Can Learn From Bill
                                                            Gates reading a book</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <img src="image/products/product-5.jpg" alt="">
                                                    <div class="hover-contents">
                                                        <a href="product-details.html" class="hover-image">
                                                            <img src="image/products/product-4.jpg" alt="">
                                                        </a>
                                                        <div class="hover-btns">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">£51.20</span>
                                                    <del class="price-old">£51.20</del>
                                                    <span class="price-discount">20%</span>
                                                </div>
                                                <div class="count-down-block">
                                                    <div class="product-countdown" data-countdown="01/05/2020"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <a href="" class="author">
                                                    Rpple
                                                </a>
                                                    <h3><a href="product-details.html">3 Ways Create Better BOOK With
                                                            The Help Of Your Dog</a>
                                                    </h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <img src="image/products/product-6.jpg" alt="">
                                                    <div class="hover-contents">
                                                        <a href="product-details.html" class="hover-image">
                                                            <img src="image/products/product-4.jpg" alt="">
                                                        </a>
                                                        <div class="hover-btns">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">£51.20</span>
                                                    <del class="price-old">£51.20</del>
                                                    <span class="price-discount">20%</span>
                                                </div>
                                                <div class="count-down-block">
                                                    <div class="product-countdown" data-countdown="01/05/2020"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-slide">
                                        <div class="product-card">
                                            <div class="product-header">
                                                <a href="" class="author">
                                                    Tpple
                                                </a>
                                                    <h3><a href="product-details.html">Turn Your BOOK Into A High
                                                            Performing Machine</a></h3>
                                            </div>
                                            <div class="product-card--body">
                                                <div class="card-image">
                                                    <img src="image/products/product-8.jpg" alt="">
                                                    <div class="hover-contents">
                                                        <a href="product-details.html" class="hover-image">
                                                            <img src="image/products/product-7.jpg" alt="">
                                                        </a>
                                                        <div class="hover-btns">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-block">
                                                    <span class="price">£51.20</span>
                                                    <del class="price-old">£51.20</del>
                                                    <span class="price-discount">20%</span>
                                                </div>
                                                <div class="count-down-block">
                                                    <div class="product-countdown" data-countdown="01/05/2020"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-lg-8">
    
                            <div class="single-block">
                                <div class="home-right-block bg-white">
                                    <div class="sb-custom-tab text-lg-left text-center">
                                        <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="shop-tab2" data-bs-toggle="tab"
                                                    href="#shop2" role="tab" aria-controls="shop2" aria-selected="true">
                                                    ARTS & PHOTOGRAPHY
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="men-tab2" data-bs-toggle="tab" href="#men2"
                                                    role="tab" aria-controls="men2" aria-selected="true">
                                                    CHILDREN'S BOOKS
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="woman-tab2" data-bs-toggle="tab" href="#woman2"
                                                    role="tab" aria-controls="woman2" aria-selected="false">
                                                    BIOGRAPHIES
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent2">
                                            <div class="tab-pane show active" id="shop2" role="tabpanel"
                                                aria-labelledby="shop-tab2">
                                                <div class="product-slider product-list-slider multiple-row slider-border-multiple-row  sb-slick-slider"
                                                    data-slick-setting='{
                                                        "autoplay": true,
                                                        "autoplaySpeed": 8000,
                                                        "slidesToShow": 2,
                                                        "rows":4,
                                                        "dots":true
                                                    }' data-slick-responsive='[
                                                        {"breakpoint":992, "settings": {"slidesToShow": 2,"rows": 3} },
                    
                                                        {"breakpoint":768, "settings": {"slidesToShow": 1} }
                                                    ]'>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-1.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">5 Ways To Get
                                                                            Through To Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-2.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">What Can You Do
                                                                            To Save Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-3.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Hpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">From Destruction
                                                                            By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-4.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                            About BOOK ?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-5.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Dpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">
                                                                            Controversial BOOK By Social Media?</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-6.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Cpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Koss
                                                                            Lightweight Portable Headphone</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-7.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Ways To Have
                                                                            Appealing BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-8.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Xpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Ways To Have
                                                                            Appealing BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-9.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Tpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">In 10 Minutes,
                                                                            I'll Give Truth About</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-10.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">What Can You Do
                                                                            To Save Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-11.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">From Destruction
                                                                            By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-12.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Spple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Lorem ipsum dolor
                                                                            sit amet reasons</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-13.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Kpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                            About BOOK ?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-1.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">
                                                                            Controversial BOOK By Social Media?</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-2.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">iPad with
                                                                            Retina ready Display </a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-5.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Koss
                                                                            Lightweight Portable Headphone</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="men2" role="tabpanel" aria-labelledby="men-tab2">
                                                <div class="product-slider product-list-slider multiple-row slider-border-multiple-row  sb-slick-slider"
                                                    data-slick-setting='{
                                                        "autoplay": true,
                                                        "autoplaySpeed": 8000,
                                                        "slidesToShow": 2,
                                                        "rows":4,
                                                        "dots":true
                                                    }' data-slick-responsive='[
                                                        {"breakpoint":992, "settings": {"slidesToShow": 2,"rows": 3} },
                    
                                                        {"breakpoint":768, "settings": {"slidesToShow": 1} }
                                                    ]'>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-1.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">5 Ways To Get
                                                                            Through To Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-2.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">What Can You Do
                                                                            To Save Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-3.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Hpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">From Destruction
                                                                            By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-4.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                            About BOOK ?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-5.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Dpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">
                                                                            Controversial BOOK By Social Media?</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-6.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Cpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Koss
                                                                            Lightweight Portable Headphone</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-7.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Ways To Have
                                                                            Appealing BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-8.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Xpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Ways To Have
                                                                            Appealing BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-9.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Tpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">In 10 Minutes,
                                                                            I'll Give Truth About</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-10.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">What Can You Do
                                                                            To Save Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-11.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">From Destruction
                                                                            By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-12.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Spple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                        About BOOK By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-13.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Kpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                            About BOOK ?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-1.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">
                                                                            Controversial BOOK By Social Media?</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-2.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">iPad with
                                                                            Retina ready Display </a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-5.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Koss
                                                                            Lightweight Portable Headphone</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="woman2" role="tabpanel"
                                                aria-labelledby="woman-tab2">
                                                <div class="product-slider product-list-slider multiple-row slider-border-multiple-row  sb-slick-slider"
                                                    data-slick-setting='{
                                                            "autoplay": true,
                                                            "autoplaySpeed": 8000,
                                                            "slidesToShow": 2,
                                                            "rows":4,
                                                            "dots":true
                                                        }' data-slick-responsive='[
                                                            {"breakpoint":992, "settings": {"slidesToShow": 2,"rows": 3} },
                        
                                                            {"breakpoint":768, "settings": {"slidesToShow": 1} }
                                                        ]'>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-1.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">5 Ways To Get
                                                                            Through To Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-2.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">What Can You Do
                                                                            To Save Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-3.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Hpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">From Destruction
                                                                            By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-4.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                            About BOOK ?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-5.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Dpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">
                                                                            Controversial BOOK By Social Media?</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-6.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Cpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Koss
                                                                            Lightweight Portable Headphone</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-7.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Ways To Have
                                                                            Appealing BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-8.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Xpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Ways To Have
                                                                            Appealing BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-9.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Tpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">In 10 Minutes,
                                                                            I'll Give Truth About</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-10.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">What Can You Do
                                                                            To Save Your BOOK</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-11.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Fpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">From Destruction
                                                                            By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-12.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Spple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                        About BOOK By Social Media?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-13.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Kpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Find Out More
                                                                            About BOOK ?</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-1.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">
                                                                            Controversial BOOK By Social Media?</a>
                                                                    </h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-2.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Apple
                                                                    </a>
                                                                    <h3><a href="product-details.html">iPad with
                                                                            Retina ready Display </a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="single-slide">
                                                        <div class="product-card card-style-list">
                                                            <div class="card-image">
                                                                <img src="image/products/product-5.jpg" alt="">
                                                            </div>
                                                            <div class="product-card--body">
                                                                <div class="product-header">
                                                                    <a href="" class="author">
                                                                        Gpple
                                                                    </a>
                                                                    <h3><a href="product-details.html">Koss
                                                                            Lightweight Portable Headphone</a></h3>
                                                                </div>
                                                                <div class="price-block">
                                                                    <span class="price">£51.20</span>
                                                                    <del class="price-old">£51.20</del>
                                                                    <span class="price-discount">20%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>


<!--==================PROMOTION SECTION ENDS=================================================================-->



<!--==================FREE SHIPPING BEGINS=================================================================-->
       <section class="mb--30 space-dt--30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="text">
                                <h5>Free Shipping Item</h5>
                                <p> Orders over $500</p>
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
                                <h5>Cash On Delivery</h5>
                                <p>Lorem ipsum dolor amet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-life-ring"></i>
                            </div>
                            <div class="text">
                                <h5>Help & Support</h5>
                                <p>Call us : + 0123.4567.89</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

 <!--==================FREE SHIPPING ENDS=================================================================-->       
       


        <!--=================================Promotion Section IMAGES===================================== -->
        <section class="section-margin">
            <h1 class="sr-only">Promotion Section</h1>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <a href="" class="promo-image promo-overlay">
                            <img src="image/bg-images/promo-banner-with-text.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a href="" class="promo-image promo-overlay">
                            <img src="image/bg-images/promo-banner-with-text-2.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>



<!--==================PROMOTION SECTION IMAGES ENDS=================================================================-->





<!-- <section class="top-brands-section  pb-60">
   <style type="text/css">
      .roundcd {
         text-align: center;
      }

      .roundcd_imgs {
         width: auto;
         border-radius: 100px;
         border: 2px solid #bfbfbf;
         padding: 2px;
      }

      .titleSty {
         margin-top: 63px;
         /*margin-bottom: 42px;*/
      }

      .busbt {
         margin-bottom: 47px;
      }
   </style>


   
   <div class="container">
      <div class="row">
         <div class="">
            <h2 class="titleSty text-center">Top Categories</h2>
            <p class="text-center">Use the badges below to our browse our most-popular selections.</p>
            <div class="busbt"></div>
         </div>
      </div>
      <div class="row">
         @foreach ($categories as $categoriesdate)
         <div class="col">
            <div class="roundcd">
               <a class="text-dark" href="{{ route('category.products',['id'=>$categoriesdate->id,'name'=>slug($categoriesdate->name)]) }}">
                  <img class="card-img-top roundcd_imgs" src="{{ getImage(imagePath()['category']['path'].'/'. $categoriesdate ->image,imagePath()['category']['size']) }}" alt="Card image cap">
                  <div class="card-body">
                     <p class="card-text">{{($categoriesdate->name)}}</p>
                  </div>
               </a>
            </div>
         </div>
         @endforeach
      </div>
   </div>




   <div class="container-fluid">
      <div class="row gy-5">
         <div class="section__header1">
         </div>
         @foreach ($brands as $brand)
         <div class="col-md-6 gift_guides">
            <div class="col-sm-12">
               <a class="brand__item" href="{{ route('brand.products',['id'=>$brand->id,'name'=>slug($brand->name)]) }}">
                  <div class="brand__item-img1">
                     <img src="{{ getImage(imagePath()['brand']['path'].'/'. $brand->image,imagePath()['brand']['size']) }}" alt="products">
                  </div>
               </a>
            </div>
         </div>
         @endforeach

          @foreach ($brands as $brand)
         <div class="col-md-6 gift_guides">
            <div class="col-sm-12">
               <a class="brand__item"
                  href="{{ route('brand.products',['id'=>$brand->id,'name'=>slug($brand->name)]) }}">
                  <div class="brand__item-img1">
                     <img src="{{ getImage(imagePath()['brand']['path'].'/'. $brand->image,imagePath()['brand']['size']) }}" alt="products">
                  </div>
               </a>
               <div class="brand__item-cont1">
                  <span>{{ __($brand->name) }}</span>
               </div>
            </div>
         </div>
         @endforeach -->
         <!-- <div class="view-all">
            <a href="{{ route('all.brands') }}" class="view--all">@lang('Show All')</a>
         </div> -->
    <!--  </div>
   </div>
</section> -->

