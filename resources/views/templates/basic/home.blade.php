@extends($activeTemplate.'layouts.frontend')

@section('title') {{'Arsh Optical : Best Eyeglasses Online & Wholesale Sunglasses Provider - Arsh Optical' }} @endsection
@section('description') {{'Welcome to Arsh Optical, your destination for the best eyeglasses online and wholesale sunglasses. Explore our wide selection of high-quality eyewear products at unbeatable prices.'}} @endsection
@section('keywords') {{'Arsh Optical best eyeglasses online, eyeglasses online for women, best online eyeglass company, eyeglasses online for men, wholesale eyeglass frames near me, wholesale sunglasses online, wholesale eyeglass frames online'}} @endsection

@section('content')

@include($activeTemplate.'sections.banner')


    @include($activeTemplate.'partials.gift_guided')
    @include($activeTemplate.'partials.hot_deal')
    
   
    @include($activeTemplate.'partials.featured_product')

   @include($activeTemplate.'partials.category_brands') 

    

    @include($activeTemplate.'partials.best_selling')
    @include($activeTemplate.'partials.our_brands')
  
@endsection