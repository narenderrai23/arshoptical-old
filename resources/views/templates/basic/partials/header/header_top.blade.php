@php

$headerContent = getContent('contact_us.content',true);

@endphp



<div class="site-wrapper" id="top">
        <div class="site-header header-3  d-none d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-8 flex-lg-right">
                        <ul class="header-top-list">
                            <!-- <li><a href=""><i class="icons-left fas fa-random"></i>My Compare</a>
                            </li> -->
                            <li class="dropdown-trigger language-dropdown"><a href="{{ route('wishlist') }}"><i
                                        class="icons-left fas fa-heart"></i>
                                    wishlist (0)</a>
                            </li>
                             @auth
                            <li class="dropdown-trigger language-dropdown"><a href="{{ route('user.home') }}"><i
                                        class="icons-left fas fa-user"></i>
                                    My Account</a><i class="fas fa-chevron-down dropdown-arrow"></i>
                                <ul class="dropdown-box">
                                    <li> <a href="{{ route('user.home') }}">My Account</a></li>
                                   
                                </ul>
                            </li>
                            @endauth
                            <li><a href="{{ route('contact') }}"><i class="icons-left fas fa-phone"></i> Contact</a>
                            </li>
                            <li><a href="{{ route('user.checkout') }}"><i class="icons-left fas fa-share"></i> Checkout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="header-middle pt--10 pb--10">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <a href="/" class="site-brand">
                                <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="" >
                            </a>
                        </div>
                        <div class="col-lg-5">
                             <form action="{{ route('products') }}" method="GET">
                                 <div class="header-search-block">
                                 <input type="text" name="search" placeholder="@lang('Search here')" value="{{ request()->search ?? null }}">
                                 <button type="submit">@lang('Search') </button>
                                </div>
                            </form> 
                        </div>
                        <div class="col-lg-4">
                            <div class="main-navigation flex-lg-right">
                                <div class="cart-widget">
                                    <div class="login-block">



                                        @auth
                                        <a class="font-weight-bold" href="{{ route('user.home') }}">{{ __(auth()->user()->username) }}</a>
                                        @else
                                        <a class="font-weight-bold" href="{{ route('user.login') }}">@lang('Login')</a><br>
                                        <span>or</span><a  href="{{ route('user.register') }}">@lang('Register')</a>
                                        @endauth
                                
                                    </div>
                                    <div class="cart-block">
                                        <div class="cart-total">
                                            <span class="text-number qty show-cart-count">
                                                1
                                            </span>
                                            <span class="text-item">
                                              <a href="{{ route('cart') }}">  View Cart </a>

                                            </span>
                                            <!-- <span class="price">
                                                £0.00
                                                <i class="fas fa-chevron-down"></i>
                                            </span> -->
                                        </div>
                                        <!-- <div class="cart-dropdown-block">
                                            <div class=" single-cart-block ">
                                                <div class="cart-product">
                                                    <a href="product-details.html" class="image">
                                                        <img src="image/products/cart-product-1.jpg" alt="">
                                                    </a>
                                                    <div class="content">
                                                        <h3 class="title"><a href="product-details.html">Kodak PIXPRO
                                                                Astro Zoom AZ421 16 MP</a></h3>
                                                        <p class="price"><span class="qty">1 ×</span> £87.34</p>
                                                        <button class="cross-btn"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" single-cart-block ">
                                                <div class="btn-block">
                                                    <a href="{{ route('cart') }}" class="btn">View Cart <i
                                                            class="fas fa-chevron-right"></i></a>
                                                    <a href="{{ route('user.checkout') }}" class="btn btn--primary">Check Out <i
                                                            class="fas fa-chevron-right"></i></a>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <nav class="category-nav">
                                <div>
                                    <a href="javascript:void(0)" class="category-trigger"><i class="fa fa-bars"></i>Browse Categories </a>
                                    <ul class="category-menu">

                                  @foreach ($categories as $category)

                                        <li class="cat-item has-children mega-menu"><a href="{{ route('category.products',['id'=>$category->id,'name'=>slug($category->name)]) }}">{{ __($category->name) }}</a>
                                            <ul class="sub-menu">
                                                @foreach ($category->subcategories as $subcategory)
                                                <li class="single-block">
                                                    <!-- <h3 class="title">Braun Metal Frames</h3> -->
                                                    <ul>
                                                        <li><a target="_blank" href="{{ route('subcategory.products',['id'=>$subcategory->id,'name'=>slug($subcategory->name)]) }}">{{ __($subcategory->name) }}</a></li>
                                                    </ul>
                                                     <!--  @auth
                                                 <span class="price">{{ $general->cur_sym }}{{ showAmount($subcategory->price) }}</span>
                                                 @else
                                                <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">See Price</a>
                                                 @endauth -->
                                                    
                                                </li>
                                                 @endforeach
                                                
                                            </ul>
                                        </li>

                                @endforeach
  <!--   <li>

        <li class="cat-item"><a href="{{ route('all.category') }}"> @lang('View All Categories')</a>
      
    </li>  -->
</ul>
           
                                </div>
                            </nav>
                        </div>
                        <div class="col-lg-3">
                            <div class="header-phone ">
                                <div class="icon">
                                    <i class="fas fa-headphones-alt"></i>
                                </div>
                                <div class="text">
                                    <p>Free Support 24/7</p>
                                    <p class="font-weight-bold number">{{ __(@$headerContent->data_values->contact_number) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="main-navigation flex-lg-right">
                                <ul class="main-menu menu-right li-last-0">
                                    <li class="menu-item has-children">
                                        <a href="/">Home </a>
                                    </li>
                    @php

                    $s_home = App\Models\Category::where('header','1')->orderBy('orderno')->take(4)->get();
                       
            @endphp
         @foreach($s_home as $offer)
                         
                       <li class="menu-item">
                                        <a href="{{ route('category.products',['id'=>$offer->id,'name'=>slug($offer->name)]) }}">{{$offer->name}}</a>
                                    </li>
                @endforeach
                
                                    <li class="menu-item">
                                        <a href="{{ route('contact') }}">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-mobile-menu">
            <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
                <div class="container">
                    <div class="row align-items-sm-end align-items-center">
                        <div class="col-md-4 col-7 mob-header">
                            <a href="/" class="site-brand">
                                <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="">
                            </a>
                        </div>


                        <div class="col-md-3 col-5  order-md-3 text-right mob-header">
                            <div class="mobile-header-btns header-top-widget">
                                <ul class="header-links">
                                    <li class="sin-link">
                                        <a href="{{ route('cart') }}" class="cart-link link-icon"><i class="las la-cart-arrow-down" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="sin-link">
                                        <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i
                                                class="ion-navicon"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        
                        <div class="col-md-5 order-3 order-md-2">
                            <nav class="category-nav   ">
                                <div>
                                    <a href="javascript:void(0)" class="category-trigger"><i
                                            class="fa fa-bars"></i>Browse
                                        Categories</a>
                                    <ul class="category-menu">
                                      

                                                                              @foreach ($categories as $category)

                                        <li class="cat-item has-children mega-menu"><a href="{{ route('category.products',['id'=>$category->id,'name'=>slug($category->name)]) }}">{{ __($category->name) }}</a>
                                            <ul class="sub-menu">
                                                @foreach ($category->subcategories as $subcategory)
                                                <li class="single-block">
                                                  <!--   <h3 class="title">Braun Metal Frames</h3> -->
                                                    <ul>
                                                        <li><a href="{{ route('subcategory.products',['id'=>$subcategory->id,'name'=>slug($subcategory->name)]) }}">{{ __($subcategory->name) }}</a></li>
                                                    </ul>
                                                    <!-- <a href="{{ route('subcategory.products',['id'=>$subcategory->id,'name'=>slug($subcategory->name)]) }}" class="btn btn--primary submenu-btn">See Prices</a> -->
                                                </li>
                                                 @endforeach
                                                
                                            </ul>
                                        </li>

                                @endforeach




                                        
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        
                    </div>
                </div>
            </header>
            <!--Off Canvas Navigation Start-->
            <aside class="off-canvas-wrapper">
                <div class="btn-close-off-canvas">
                    <i class="ion-android-close"></i>
                </div>
                <div class="off-canvas-inner">
                    <!-- search box start -->
                    <div class="search-box offcanvas" style="visibility: visible;">
                             <form action="{{ route('products') }}" method="GET">
                                 <div class="header-search-block">
                                 <input type="text" name="search" placeholder="@lang('Search here')" value="{{ request()->search ?? null }}">
                                 <button type="submit" style="font-size: 15px;">@lang('Search') </button>
                                </div>
                            </form> 
                     <!--    <form>
                            <input type="text" placeholder="Search Here">
                            <button class="search-btn"><i class="ion-ios-search-strong"></i></button>
                        </form> -->
                    </div>
                    <!-- search box end -->
                    <!-- mobile menu start -->
                    <div class="mobile-navigation">
                        <!-- mobile menu navigation start -->
                        <nav class="off-canvas-nav">
                            <ul class="mobile-menu main-mobile-menu">
                                <li class="menu-item has-children">
                                        <a href="/">Home </a>
                                    </li>
                                   @php

                    $s_home = App\Models\Category::where('header','1')->orderBy('orderno')->take(4)->get();
                       
            @endphp
         @foreach($s_home as $offer)
                         
                       <li class="menu-item">
                                        <a href="{{ route('category.products',['id'=>$offer->id,'name'=>slug($offer->name)]) }}">{{$offer->name}}</a>
                                    </li>
                @endforeach
                
                                 
                                    <li class="menu-item">
                                        <a href="{{ route('contact') }}">Contact</a>
                                    </li>
                            </ul>
                        </nav>
                        <!-- mobile menu navigation end -->
                    </div>
                    <!-- mobile menu end -->
                    <nav class="off-canvas-nav">
                        <ul class="mobile-menu menu-block-2">
                          <!--   <li class="menu-item-has-children">
                                <a href="#">Currency - USD $ <i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                    <li> <a href="#">USD $</a></li>
                                    <li> <a href="#">EUR €</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Lang - Eng<i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                    <li>Eng</li>
                                    <li>Ban</li>
                                </ul>
                            </li> -->
                            <li class="menu-item-has-children">
                            @auth
                            
                                <a href="{{ route('user.home') }}">My Account <i class="fas fa-angle-down"></i></a>
               <!--  <a class="font-weight-bold" href="{{ route('user.home') }}">{{ __(auth()->user()->username) }}</a> -->
                @else

                <a class="font-weight-bold" href="{{ route('user.login') }}">@lang('Login')</a><br>
                <span>or</span><a  href="{{ route('user.register') }}">@lang('Register')</a>
                @endauth
            </li>
                            <!-- <li class="menu-item-has-children">
                                <a href="#">My Account <i class="fas fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                    <li><a href="my-account.html">My Account</a></li>
                                    <li><a href="my-account.html#orders">Order History</a></li>
                                    <li><a href="">Transactions</a></li>
                                    <li><a href="">Downloads</a></li>
                                </ul>
                            </li> -->
                        </ul>
                    </nav>


		
                    <div class="off-canvas-bottom">
                        <div class="contact-list mb--10">
                            <a href="" class="sin-contact"><i class="fas fa-mobile-alt"></i>(+91) {{ __(@$headerContent->data_values->contact_number) }}</a>
                            <a href="mailto:{{ __(@$headerContent->data_values->contact_email) }}" class="sin-contact"><i class="fas fa-envelope"></i>{{ __(@$headerContent->data_values->contact_email) }}</a>
                        </div>
                        <div class="off-canvas-social">
                            <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="single-icon"><i class="fas fa-rss"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#" class="single-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </aside>
  <aside>
 <nav>
<div class="row extramenu">

<div class="col-lg-3"></div>
<div class="col-lg-3"></div>
<div class="col-lg-6">
                        <ul class="main-menu menu-right li-last-0">
                         @php
			
                    $s_home = App\Models\Category::where('featured','1')->orderBy('orderno')->take(4)->get();
                       
            @endphp
         @foreach($s_home as $offer)
                         
                       <li class="menu-item">
                                        <a href="{{ route('category.products',['id'=>$offer->id,'name'=>slug($offer->name)]) }}">{{$offer->name}}</a>
                                    </li>
                @endforeach
                </ul>
</div>
</div>
                    </nav>
  </aside>
            <!--Off Canvas Navigation End-->
        </div>
        <div class="sticky-init fixed-header common-sticky">
            <div class="container d-none d-lg-block">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                       <!--  <a href="/" class="site-brand">
                            <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="" >
                        </a> -->



                            <nav class="category-nav   ">
                                <div>
                                    <a href="javascript:void(0)" class="category-trigger"><i
                                            class="fa fa-bars"></i>Browse
                                        Categories</a>
                                    <ul class="category-menu">
                                      

                                                                              @foreach ($categories as $category)

                                        <li class="cat-item has-children mega-menu"><a href="{{ route('category.products',['id'=>$category->id,'name'=>slug($category->name)]) }}">{{ __($category->name) }}</a>
                                            <ul class="sub-menu">
                                                @foreach ($category->subcategories as $subcategory)
                                                <li class="single-block">
                                                  <!--   <h3 class="title">Braun Metal Frames</h3> -->
                                                    <ul>
                                                        <li><a href="{{ route('subcategory.products',['id'=>$subcategory->id,'name'=>slug($subcategory->name)]) }}">{{ __($subcategory->name) }}</a></li>
                                                    </ul>
                                                    <!-- <a href="{{ route('subcategory.products',['id'=>$subcategory->id,'name'=>slug($subcategory->name)]) }}" class="btn btn--primary submenu-btn">See Prices</a> -->
                                                </li>
                                                 @endforeach
                                                
                                            </ul>
                                        </li>

                                @endforeach




                                        
                                    </ul>
                                </div>
                            </nav>
                        
                    </div>



                      <div class="col-lg-4">


             
                        <div class="main-navigation flex-lg-right">
                            <ul class="main-menu menu-right ">
                                <li class="menu-item has-children">
                                        <a href="/">Home</a>
                                    </li>

        @php

                    $s_home = App\Models\Category::where('header','1')->orderBy('orderno')->take(3)->get();
                       
            @endphp
         @foreach($s_home as $offer)
                         
                       <li class="menu-item">
                                        <a href="#">{{$offer->name}}</a>
                                    </li>
                @endforeach


                                    <li class="menu-item">
                                        <a href="{{ route('contact') }}">Contact</a>
                                    </li>
                            </ul>
                        </div>
                    
                           
                        </div>
                        <div class="col-lg-4">
                            <div class="main-navigation flex-lg-right">
                                <div class="cart-widget">
                                    <div class="login-block">



                @auth
                <a class="font-weight-bold" href="{{ route('user.home') }}">{{ __(auth()->user()->username) }}</a>
                @else
                <a class="font-weight-bold" href="{{ route('user.login') }}">@lang('Login')</a><br>
                <span>or</span><a  href="{{ route('user.register') }}">@lang('Register')</a>
                @endauth
        
            


            <!--                             <a href="login-register.html" class="font-weight-bold">Login</a> <br>
                                        <span>or</span><a href="login-register.html">Register</a>


                                        <div class="change-language d-md-none mt-4 fs--16px">
                <<div class="sign-in-up">
                    <span><i class="fas la-user"></i></span>
                    @auth
                    <a href="{{ route('user.home') }}">{{ __(auth()->user()->username) }}</a>
                    @else
                    <a href="{{ route('user.login') }}">@lang('Login')</a>
                    <a href="{{ route('user.register') }}">@lang('Register')</a>
                    @endauth
                </div>
            </div>
             -->
                                    </div>
                                    <div class="cart-block">
                                        <div class="cart-total">
                                            <span class="text-number qty show-cart-count">
                                                1
                                            </span>
                                            <span class="text-item">
                                              <a href="{{ route('cart') }}">  View Cart </a>
                                            </span>
                                           <!--  <span class="price">
                                                £0.00
                                                <i class="fas fa-chevron-down"></i>
                                            </span> -->
                                        </div>
                                        <!-- <div class="cart-dropdown-block">
                                            <div class=" single-cart-block ">
                                                <div class="cart-product">
                                                    <a href="product-details.html" class="image">
                                                        <img src="image/products/cart-product-1.jpg" alt="">
                                                    </a>
                                                    <div class="content">
                                                        <h3 class="title"><a href="product-details.html">Kodak PIXPRO
                                                                Astro Zoom AZ421 16 MP</a></h3>
                                                        <p class="price"><span class="qty">1 ×</span> £87.34</p>
                                                        <button class="cross-btn"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" single-cart-block ">
                                                <div class="btn-block">
                                                    <a href="{{ route('cart') }}" class="btn">View Cart <i
                                                            class="fas fa-chevron-right"></i></a>
                                                    <a href="{{ route('user.checkout') }}" class="btn btn--primary">Check Out <i
                                                            class="fas fa-chevron-right"></i></a>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                  
                </div>
            </div>
        </div>
<!-- 

@php

$headerContent = getContent('contact_us.content',true);

@endphp

<div class="header-top bg--base">

    <div class="container">

        <div class="header__top__wrapper">

            <ul>

                <li>

                    <span class="name text--white">@lang('Email: ')</span>

                    <a href="mailto:{{ __(@$headerContent->data_values->contact_email) }}">{{ __(@$headerContent->data_values->contact_email) }}</a>

                </li> 

                </li>

            </ul>

            <div class="change-language">

                <select class="language langSel">

                    @foreach ($language as $item)

                    <option value="{{ $item->code }}" @if (session('lang')==$item->code) selected @endif>

                        {{ __($item->name) }}

                    </option>

                    @endforeach

                </select>

            </div>

        </div>

    </div>

</div> -->