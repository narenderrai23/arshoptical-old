@forelse($products as $product)
@php
$price = productPrice($product);
@endphp



<div class="single-slide">
                        <div class="product-card">
                            <div class="product-header">
                              <!--   <a href="{{ route('product.detail',['id'=>$product->id,'name'=>slug($product->slug)]) }}" class="author">
                                    {{($product->name)}}
                                </a> -->
                                <h3><a href="{{ route('product.detail',['id'=>$product->id,'name'=>slug($product->slug)]) }}">{{($product->name)}}</a></h3>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn--primary submenu-btn1">See Prices</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn--yellow submenu-btn1">Preview</a>
                                        </div>
                                    </div>
                                    
                                    <!-- <span class="price">£51.20</span>
                                    <del class="price-old">£51.20</del>
                                    <span class="price-discount">20%</span> -->
                                </div>
                            </div>
                        </div>
                    </div>


@empty
@endforelse