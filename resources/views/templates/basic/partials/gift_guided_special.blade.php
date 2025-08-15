@php

$products = App\Models\Product::active()->where('subcategory_id',$row->id)->latest()->take(16)->get();

@endphp
                @foreach ($products as  $key  => $product)
                                <div class="single-slide">
                                        <div class="product-card card-style-list">
                                            <div class="card-image">
                                                <img src="{{ getImage(imagePath()['product']['thumb']['path'].'/'. $product->image,imagePath()['product']['thumb']['size']) }}" alt="">
                                            </div>
                                            <div class="product-card--body">
                                                <div class="product-header">
                                                    <!-- <a href="" class="author">
                                                                        Fpple
                                                    </a> -->
                                                        <h3><a href="{{ route('product.detail',['id'=>$product->id,'name'=>slug($product->slug)]) }}">{{$product->name}} {{$product->model_no}}</a></h3>
                                                </div>
                                                <div class="price-block">
                                                    
                                                    @auth
                                               <span class="price">{{ $general->cur_sym }}{{ showAmount($product->price) - userDiscountWeb($product->price)}}</span>
                                                 @else
                                                <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">See Price</a>
                                                 @endauth
                                                    <!-- <del class="price-old">{{(int)$product->price}}</del>
                                                    <span class="price-discount">{{(int)$product->discount}}%</span> -->
                                                </div>
                                             </div>
                                        </div>
                                </div>

                    @endforeach