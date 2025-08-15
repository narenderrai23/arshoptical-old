@foreach ($products as $product)
    <div class="col-lg-4 col-sm-6">
        <div class="product-card">
            <div class="product-grid-content">
                <div class="product-header">
                    <!-- <a href="" class="author">
                    Epple
                </a> -->
                    <!-- <input class="form-check-input sortCategory" type="checkbox" name="subcategory"
                        id="cate{{ $subcategoryId }}" value="{{ $subcategoryId }}"> -->
                    <h3><a href="{{ route('product.detail', ['id' => $product->id, 'name' => slug($product->slug)]) }}">{{ __($product->name) }}
                            {{ __($product->model_no) }}</a></h3>
                </div>
                <div class="product-card--body">
                    <div class="card-image">
                        <img src="{{ getImage(imagePath()['product']['thumb']['path'] . '/' . $product->image, imagePath()['product']['thumb']['size']) }}"
                            alt="">
                        <div class="hover-contents">
                            <a href="{{ route('product.detail', ['id' => $product->id, 'name' => slug($product->slug)]) }}"
                                class="hover-image">
                                <img src="{{ getImage(imagePath()['product']['thumb']['path'] . '/' . $product->image, imagePath()['product']['thumb']['size']) }}"
                                    alt="">
                            </a>
                           <!--  <div class="hover-btns">
                                <a href="cart.html" class="single-btn">
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

                          $item = App\Models\SubCategory::where('id',$product->subcategory_id)->first();
                        @endphp
                         <a target="_blank" rel="noreferrer" href="/public/pdf?link={{$item->pdf }}" class="btn btn--primary submenu-btn">PDF</a>
                        @auth
                        <span class="price">{{ $general->cur_sym }}{{ showAmount($product->price) }}</span>
                        @else
                        <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">Prices</a>
                        @endauth
                        
                        <!-- <del class="price-old">£51.20</del>
                        <span class="price-discount">20%</span> -->
                    </div>
                </div>
            </div>
            <div class="product-list-content">
                <div class="card-image">
                    <img src="{{ getImage(imagePath()['product']['thumb']['path'] . '/' . $product->image, imagePath()['product']['thumb']['size']) }}"
                        alt="">
                </div>
                <div class="product-card--body">
                    <div class="product-header">
                        <a href="" class="author">
                            Gpple
                        </a>
                        <h3><a href="{{ route('product.detail', ['id' => $product->id, 'name' => slug($product->slug)]) }}"
                                tabindex="0">{{ __($product->name) }}</a></h3>
                    </div>
                    <article>
                        <h2 class="sr-only">Card List Article</h2>
                        <!--  <p>More room to move. With 80GB or 160GB of storage and up to 40 hours of
                        battery life, the new iPod classic
                        lets you enjoy
                        up to 40,000 songs or..</p> -->
                    </article>
                    <div class="price-block">
                        <span class="price">£51.20</span>
                        <del class="price-old">£51.20</del>
                        <span class="price-discount">20%</span>
                    </div>
                    <div class="rating-block">
                        <span class="fas fa-star star_on"></span>
                        <span class="fas fa-star star_on"></span>
                        <span class="fas fa-star star_on"></span>
                        <span class="fas fa-star star_on"></span>
                        <span class="fas fa-star "></span>
                    </div>
                    <div class="btn-block">
                        <a href="" class="btn btn-outlined">Add To Cart</a>
                        <a href="" class="card-link"><i class="fas fa-heart"></i> Add To
                            Wishlist</a>
                        <a href="" class="card-link"><i class="fas fa-random"></i> Add To
                            Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach