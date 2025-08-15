@extends($activeTemplate.'layouts.frontend')

@section('title') {{'Arsh Opticals : '. __($product->name).' '. __($product->model_no).' Explore Wholesale Price For Eyeglasses and Sunglasses' }} @endsection
@section('description') {{'Arsh Optical is Delhi leading wholesale supplier of eyeglasses find our model '. __($product->name).' '. __($product->model_no).' committed to providing retailers with top-notch products and service. Explore our collection and transform your eyewear offerings.'}} @endsection
@section('keywords') {{'Arsh Optical is Delhi leading wholesale supplier of eyeglasses find our model '. __($product->name).' '. __($product->model_no).' committed to providing retailers with top-notch products and service. Explore our collection and transform your eyewear offerings.'}} @endsection
@section('content')
@php
$subcategoryId=$product->subcategory->id;
@endphp
@include($activeTemplate.'sections.productbanner',['subcategoryId' =>  $subcategoryId])

<!---Main template starts-->
<style>
    .product-details-info {
   height: auto;
    overflow-y: hidden;
    overflow-x: hidden;
}
</style>

    <main class="inner-page-sec-padding-bottom">
            <div class="container">
                <div class="row  mb--60">
                    <div class="col-lg-5 mb--30">
                        <!-- Product Details Slider Big Image-->
                        <div class="product-details-slider sb-slick-slider arrow-type-two new-class" >
                    @foreach ($product->productGallery as $gallery)
                        <div class="single-slide">
                            <div class="image-container">
                                <img src="{{ getImage(imagePath()['product']['gallery']['path'].'/'. $gallery->image,imagePath()['product']['gallery']['size']) }}" alt="">
                            </div>
                        </div>
                    @endforeach         
                </div>
                        <!-- Product Details Slider Nav -->
                        <div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two" data-slick-setting='{ "infinite":true,  "autoplay": false, "autoplaySpeed": 2000, "slidesToShow": 4, "arrows": true, "prevArrow":{"buttonClass": "slick-prev","iconClass":"fa fa-chevron-left"}, "nextArrow":{"buttonClass": "slick-next","iconClass":"fa fa-chevron-right"}, "asNavFor": ".product-details-slider", "focusOnSelect": true}'>
                             @foreach ($product->productGallery as $gallery)
                            <div class="single-slide">
                                <img src="{{ getImage(imagePath()['product']['gallery']['path'].'/'. $gallery->image,imagePath()['product']['gallery']['size']) }}" alt="">
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="col-lg-7">



                                @php
                                    $price = productPrice($product);
                                    $features = json_decode($product->features);
                                @endphp


                        <div class="product-details-info pl-lg--30 ">
                          <!--   <p class="tag-block">Tags: <a href="#">Movado</a>, <a href="#">Omega</a></p> -->
                            <h3 class="product-title">{{ __($product->name).' '. __($product->model_no) }}</h3>
                            <ul class="list-unstyled">

                                               


                               
                                <li>Category: <a href="#" class="list-value font-weight-bold"> {{ $product->category->name }}</a></li>
                                <li>Product Code: <span class="list-value"> {{__($product->model_no) }}</span></li>
                                <li>Availability: <span class="list-value">   {{$product->quantity == 0 ? 'Out of Stock' : 'In Stock' }}</span></li>
                            </ul>
                            <div class="price-block">
                                

                                                @auth
                                                <span class="price-new">{{ $general->cur_sym }}{{ showAmount($price) }}</span>
                                                  @php
                                            //|| $product->today_deals == 1
                                            if($product->discount != 0 ){
                                                $discount = discountText($product,$general);
                                                echo $discount;
                                            }
                                        @endphp
                                                 @else
                                                <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">Price</a>
                                                 @endauth
                            <!--     <del class="price-old">£91.86</del> -->
                            </div>
                            <br/>
                            <div class="product-card--body">{{$product->summary}}</div>
                            <br/>
                            <div class="rating-widget">
                                <div class="rating-block">
                                    <span class="fas fa-star star_on"></span>
                                    <span class="fas fa-star star_on"></span>
                                    <span class="fas fa-star star_on"></span>
                                    <span class="fas fa-star star_on"></span>
                                    <span class="fas fa-star "></span>
                                </div>
                                <div class="review-widget">
                                    <a href="">({{count($product->reviews)}} Reviews)</a> <span>|</span>
                                    <a href="">Write a review</a>
                                </div>
                            </div>

         
                        </div>
                    </div>
                </div>


                <div class="shop-product-wrap with-pagination row space-db--30 shop-border grid-four">
                     @foreach ($product->productGallery as $key=> $gallery)
                    <div class="col-lg-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-grid-content">
                                <div class="product-header">
                                    <a href="" class="author">
                                         {{$gallery->color_code}}
                                    </a>
                                    
                                </div>
                                <div class="product-card--body">
                                    <div class="card-image">
                                        <img src="{{ getImage(imagePath()['product']['gallery']['path'].'/'. $gallery->image,imagePath()['product']['gallery']['size']) }}" alt="">
                                        <div class="hover-contents">
                                            <a href="product-details.html" class="hover-image">
                                                <img src="{{ getImage(imagePath()['product']['gallery']['path'].'/'. $gallery->image,imagePath()['product']['gallery']['size']) }}" alt="">
                                            </a> 
                                        </div>      
                                    </div>
                                      @auth
                    @if($gallery->qty>0)
                                    <div class="product-details-info"> 
                            
                                        <div class="add-to-cart-row">

                                            <div class="count-input-block">
                                                <span class="widget-label">Qty</span>
                                                <input type="number" class="productQuantity{{$key +1}}" class="form-control text-center" value="1">
                                                <input type="hidden" class="qty{{$key +1}}" value="{{$gallery->qty}}">
                                            </div>
                                            <div class="add-cart-btn" style="width:22px;margin-top:6px">

                                                
                                                   <a href="" class="btn btn-outlined--primary add-to-cart" data-color-id="{{$gallery->id}}" data-key-id="{{$key +1}}" data-qty="{{$gallery->qty}}" data-color-code="{{$gallery->color_code}}" data-product_id="{{ $product->id }}"><span class="plus-icon">+</span>@lang('Add')</a>
                                                

                                               
                                            </div>
                                        </div>
                                    </div>
                     @else
                     <a href="javascript:void()" class="btn btn--primary submenu-btn">Out Of Stock</a>
                     @endif
                                                @else
                                                <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">Price</a>
                                                 @endauth
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    @endforeach
                </div>


                <div class="sb-custom-tab review-tab section-padding mt-5" style="margin-top: 100px !important;padding-bottom: 0 !important;">
                    <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist" style="margin-bottom: 0px !important;">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#tab-1" role="tab"
                                aria-controls="tab-1" aria-selected="true">
                                @lang('Description')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="tab2" data-bs-toggle="tab" href="#tab-2" role="tab"
                                aria-controls="tab-2" aria-selected="true">
                                @lang('Specification')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#tab-3" role="tab"
                                aria-controls="tab-3" aria-selected="true">
                               @lang('Reviews')
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content space-db--20" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab1">
                            <article class="review-article">
                              <!--   <h1 class="sr-only">Tab Specification</h1> -->
                                <p>@php echo $product->description; @endphp</p>
                            </article>
                        </div>
                         <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab2">
                            <article class="review-article">
                                <!-- <h1 class="sr-only"></h1> -->
                                <table>
                                             @foreach ($features as $feature)
                                            <tr>
                                                <th>{{ $feature->feature_title }}</th>
                                                <td>{{ $feature->feature_desc }}</td>
                                            </tr>
                                            @endforeach
                                </table>
                            </article>
                        </div>
                        <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tab3">
                            <div class="review-wrapper">
                                <h2 class="title-lg mb--20">Product Reviews</h2>
                                 @forelse ($product->reviews as $review)
                                <div class="review-comment mb--20">
                                    <div class="avatar">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. @$review->user->image) }}" alt="review">
                                    </div>
                                    <div class="text">
                                        <div class="rating-block mb--15">
                                            <span class="ion-android-star-outline star_on"></span>
                                            <span class="ion-android-star-outline star_on"></span>
                                            <span class="ion-android-star-outline star_on"></span>
                                            <span class="ion-android-star-outline"></span>
                                            <span class="ion-android-star-outline"></span>
                                        </div>
                                        <h6 class="author">{{ __(@$review->user->username)}} – <span class="font-weight-400">@lang('Posted on') {{ showDateTime($review->create_at)}}</span>
                                        </h6>
                                                        @for($i = 1; $i <= $review->stars; $i++)
                                                            <i class="las la-star"></i>
                                                        @endfor

                                                        @for($k = 1; $k <= 5-$review->stars; $k++)
                                                            <i class="lar la-star"></i>
                                                        @endfor
                                        <p>{{ __($review->review_comment) }}</p>
                                    </div>
                                </div>
                                 @empty
                                        <div class="review-item">
                                            <strong class="text--danger">{{ __($emptyMessage) }}</strong>
                                        </div>
                                @endforelse
                                <h2 class="title-lg mb--20 pt--15">ADD A REVIEW</h2>
                                <div class="rating-row pt-2">
                                    <p class="d-block">Your Rating</p>
                                    <span class="rating-widget-block">
                                        <input type="radio" name="star" id="star1">
                                        <label for="star1"></label>
                                        <input type="radio" name="star" id="star2">
                                        <label for="star2"></label>
                                        <input type="radio" name="star" id="star3">
                                        <label for="star3"></label>
                                        <input type="radio" name="star" id="star4">
                                        <label for="star4"></label>
                                        <input type="radio" name="star" id="star5">
                                        <label for="star5"></label>
                                    </span>
                                    <form action="./" class="mt--15 site-form ">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="message">Comment</label>
                                                    <textarea name="message" id="message" cols="30" rows="10"
                                                        class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="name">Name *</label>
                                                    <input type="text" id="name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="email">Email *</label>
                                                    <input type="text" id="email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="website">Website</label>
                                                    <input type="text" id="website" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="submit-btn">
                                                    <a href="#" class="btn btn-black">Post Comment</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<div style="clear: both; margin-top: 30px;">
<!------------------------------>
  @if ($relatedProduct->count() > 0)
<section class="section-margin">
            <div class="container">
                <div class="section-title section-title--bordered">
                    <h4>@lang('Related Products')</h4>
                </div>
                <div class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
                        "autoplay": true,
                        "autoplaySpeed": 2000,
                        "slidesToShow":4,
                        "dots":true
                    }' data-slick-responsive='[
                        {"breakpoint":1200, "settings": {"slidesToShow": 4} },
                        {"breakpoint":992, "settings": {"slidesToShow": 3} },
                        {"breakpoint":768, "settings": {"slidesToShow": 2} },
                        {"breakpoint":480, "settings": {"slidesToShow": 1} },
                        {"breakpoint":320, "settings": {"slidesToShow": 1} }
                    ]'>

                 


                     @foreach ($relatedProduct as $product)
                    <div class="single-slide">
                        
                        <div class="product-card">
                            <div class="product-header">
                                <!-- <a href="" class="author">
                                    Lpple
                                </a> -->
                                <h3><a href="{{ route('product.detail',['id'=>$product->id,'name'=>slug($product->slug)]) }}">{{__($product->name.' '. $product->model_no)}}</a></h3>
                            </div>
                            <div class="product-card--body">
                                <div class="card-image">
                                    <img src="{{ getImage(imagePath()['product']['thumb']['path'].'/'. $product->image,imagePath()['product']['thumb']['size']) }}" alt="">
                                    <div class="hover-contents">
                                        <a href="{{ route('product.detail',['id'=>$product->id,'name'=>slug($product->slug)]) }}" class="hover-image">
                                            <img src="{{ getImage(imagePath()['product']['thumb']['path'].'/'. $product->image,imagePath()['product']['thumb']['size']) }}" alt="">
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
                                   @php
                                    $price = productPrice($product);

                                @endphp



                                                @auth
                                                 <span class="price"> {{ $general->cur_sym }}{{ showAmount($price) }}</span>
                                                  @php
                                            //|| $product->today_deals == 1
                                            if($product->discount != 0 ){
                                                $discount = discountText($product,$general);
                                                echo $discount;
                                            }
                                        @endphp
                                                 @else
                                                <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">Price</a>
                                                 @endauth
                                          
                                              
                                      
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    @endforeach
                   
            </div>
        </section>
  @endif
<!---------------------------------->
                
             </div>
            </main>
                <!-- <div class="tab-product-details">

 Main template ends-->
 <script>
    document.querySelectorAll('.image-container').forEach(container => {
    container.addEventListener('mousemove', function(e) {
       
        const img = this.querySelector('img');
        const rect = img.getBoundingClientRect();
        const x = e.clientX - rect.left; // x position within the image
        const y = e.clientY - rect.top; // y position within the image
        
        const xPercent = x / rect.width * 100; // Calculate the percentage
        const yPercent = y / rect.height * 100;

        img.style.transformOrigin = `${xPercent}% ${yPercent}%`; // Set transform origin
        img.style.transform = 'scale(2.5)'; // Scale the image
    });

    container.addEventListener('mouseleave', function() {
        const img = this.querySelector('img');
        img.style.transform = 'scale(1)'; // Reset scale on mouse leave
        
    });
});


 </script>
 @endsection