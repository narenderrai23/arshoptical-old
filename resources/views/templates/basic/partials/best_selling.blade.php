 @php

$cats = App\Models\Category::active()->where('home',1)->orderBy('orderno')->take(4)->get();

@endphp


 @foreach ($cats as  $key  => $row)
<section class="section-margin">
            <div class="container">
                <div class="section-title section-title--bordered">
                    <h2>{{$row->name}}</h2>
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

                     @php

$subcats = App\Models\SubCategory::where('category_id',$row->id)->where('status',1)->orderBy('orderno')->take(12)->get();

@endphp
                     @foreach($subcats as $item)
                    <div class="single-slide">
                        
                        <div class="product-card">
                            <div class="product-header">
                                <!-- <a href="" class="author">
                                    Lpple
                                </a> -->
                                <h3><a href="{{ route('subcategory.products',['id'=>$item->id,'name'=>slug($item->name)]) }}">{{$item->name}}</a></h3>
                            </div>
                            <div class="product-card--body">
                                <div class="card-image">
                                    <img src="{{ getImage(imagePath()['category']['path'] . '/' . $item->image, imagePath()['category']['size']) }}" alt="">
                                    <div class="hover-contents">
                                        <a href="{{ route('subcategory.products',['id'=>$item->id,'name'=>slug($item->name)]) }}" class="hover-image">
                                            <img src="{{ getImage(imagePath()['category']['path'] . '/' . $item->image, imagePath()['category']['size']) }}" alt="">
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
                                          <a target="_blank" href="/public/pdf?link={{$item->pdf }}" class="btn btn--primary submenu-btn">PDF</a>
                                               
                                                 @auth
                                               
                                                   <span class="price">{{ $general->cur_sym }} {{ showAmount($item->price - userDiscountWeb($item->price)) }}</span> 
                                                @else
                                                    <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">Price</a>
                                                @endauth
                                               <!--  <del class="price-old">{{(int)$item->price}}</del>
                                                <span class="price-discount">{{(int)$item->discount}}%</span> -->
                                      
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    @endforeach
                   
            </div>
        </section>


@endforeach
        <!--=================================-->








 







 <!--best selling ends here-->




@php

$bestselling = getContent('bestseller.element',false,null,true);

@endphp



               @foreach ($bestselling as  $key  =>  $slider)

	@if($key>0)
                 <section class="section-margin">
            <div class="promo-wrapper promo-type-three">
                <a href="#" class="promo-image promo-overlay bg-image" data-bg="{{ getImage('assets/images/frontend/bestseller/'.$slider->data_values->image,'1920x400') }}">
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
                
         

        <br/><br/>










  <section class="section-margin">
            <div class="container">
                <div class="section-title">
                    <h2>LATEST BLOGS</h2>
                </div>
                <div class="blog-slider sb-slick-slider" data-slick-setting='{
                "autoplay": true,
                "autoplaySpeed": 8000,
                "slidesToShow": 2,
                "dots": true
            }' data-slick-responsive='[
                {"breakpoint":1200, "settings": {"slidesToShow": 1} }
            ]'>


@php

$blogs = App\Models\Blogs::where('status',0)->orderBy('id')->take(8)->get();

@endphp



               @foreach ($blogs as  $blog)

                    <div class="single-slide">
                        <div class="blog-card">
                            <div class="image">
                                <img src="{{ getImage(imagePath()['blogs']['path'] . '/' . $blog->image, imagePath()['blogs']['size']) }}" alt="">
                            </div>
                            <div class="content">
                                <div class="content-header">
                                    <div class="date-badge">
                                        <span class="date">
                                            {{$blog->created_at->format('d')}}
                                        </span>
                                        <span class="month">
                                           {{$blog->created_at->format('M')}}
                                        </span>
                                    </div>
                                    <h3 class="title"><a href="{{ route('blog-details',$blog->id) }}">{{$blog->title}}</a>
                                    </h3>
                                </div>
<p></p>
<p></p>
<p></p>
                                <p class="meta-para"><i class="fas fa-user-edit"></i>Post by <a href="#">Arsh Optical</a></p>
                                <article class="blog-paragraph">
                                    <h2 class="sr-only">blog-paragraph</h2>
                                    <!--<p>{{!! html_entity_decode(\Illuminate\Support\Str::limit($blog->desciption, 50, $end='...')) !!}}</p>-->
                                </article>
                                <a href="{{ route('blog-details',$blog->id) }}" class="card-link">Read More <i
                                        class="fas fa-chevron-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

 @endforeach

                   





                </div>
            </div>
        </section>
        <!--=================================
        CLIENT TESTIMONIALS
    ===================================== -->
 
        <!-- Modal -->
        <div class="modal fade modal-quick-view" id="quickModal" tabindex="-1" role="dialog"
            aria-labelledby="quickModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="product-details-modal">
                        <div class="row">
                            <div class="col-lg-5">
                                <!-- Product Details Slider Big Image-->
                                <div class="product-details-slider sb-slick-slider arrow-type-two" data-slick-setting='{
                                    "slidesToShow": 1,
                                    "arrows": false,
                                    "fade": true,
                                    "draggable": false,
                                    "swipe": false,
                                    "asNavFor": ".product-slider-nav"
                                    }'>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-1.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-2.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-3.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-4.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-5.jpg" alt="">
                                    </div>
                                </div>
                                <!-- Product Details Slider Nav -->
                                <div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two"
                                    data-slick-setting='{
            "infinite":true,
              "autoplay": true,
              "autoplaySpeed": 8000,
              "slidesToShow": 4,
              "arrows": true,
              "prevArrow":{"buttonClass": "slick-prev","iconClass":"fa fa-chevron-left"},
              "nextArrow":{"buttonClass": "slick-next","iconClass":"fa fa-chevron-right"},
              "asNavFor": ".product-details-slider",
              "focusOnSelect": true
              }'>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-1.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-2.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-3.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-4.jpg" alt="">
                                    </div>
                                    <div class="single-slide">
                                        <img src="image/products/product-details-5.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 mt--30 mt-lg--30">
                                <div class="product-details-info pl-lg--30 ">
                                    <p class="tag-block">Tags: <a href="#">Movado</a>, <a href="#">Omega</a></p>
                                    <h3 class="product-title">Beats EP Wired On-Ear Headphone-Black</h3>
                                    <ul class="list-unstyled">
                                        <li>Ex Tax: <span class="list-value"> £60.24</span></li>
                                        <li>Brands: <a href="#" class="list-value font-weight-bold"> Canon</a></li>
                                        <li>Product Code: <span class="list-value"> model1</span></li>
                                        <li>Reward Points: <span class="list-value"> 200</span></li>
                                        <li>Availability: <span class="list-value"> In Stock</span></li>
                                    </ul>
                                    <div class="price-block">
                                        <span class="price-new">£73.79</span>
                                        <del class="price-old">£91.86</del>
                                    </div>
                                    <div class="rating-widget">
                                        <div class="rating-block">
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star star_on"></span>
                                            <span class="fas fa-star "></span>
                                        </div>
                                        <div class="review-widget">
                                            <a href="">(1 Reviews)</a> <span>|</span>
                                            <a href="">Write a review</a>
                                        </div>
                                    </div>
                                    <article class="product-details-article">
                                        <h4 class="sr-only">Product Summery</h4>
                                        <p>Long printed dress with thin adjustable straps. V-neckline and wiring under
                                            the Dust with ruffles
                                            at the bottom
                                            of the
                                            dress.</p>
                                    </article>
                                    <div class="add-to-cart-row">
                                        <div class="count-input-block">
                                            <span class="widget-label">Qty</span>
                                            <input type="number" class="form-control text-center" value="1">
                                        </div>
                                        <div class="add-cart-btn">
                                            <a href="" class="btn btn-outlined--primary"><span
                                                    class="plus-icon">+</span>Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="compare-wishlist-row">
                                        <a href="" class="add-link"><i class="fas fa-heart"></i>Add to Wish List</a>
                                        <a href="" class="add-link"><i class="fas fa-random"></i>Add to Compare</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="widget-social-share">
                            <span class="widget-label">Share:</span>
                            <div class="modal-social-share">
                                <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                                <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=================================
    Footer
===================================== -->
    </div>
   
    <!--=================================
    Footer Area
===================================== -->