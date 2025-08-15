 

       
            <div class="tab-pane {{ $index == 0 ? 'show active' : ''}}" id="producttab-{{$index }}" role="tabpanel" aria-labelledby="shop-tab">
                <div class="product-slider sb-slick-slider slider-border-single-row""
                    data-slick-setting='{
                            "autoplay": true,
                            "autoplaySpeed": 3000,
                            "slidesToShow": 5,
                            "rows":1,
                            "dots":true }' data-slick-responsive='[
                            {"breakpoint":1200, "settings": {"slidesToShow": 3} },
                            {"breakpoint":768, "settings": {"slidesToShow": 2} },
                            {"breakpoint":480, "settings": {"slidesToShow": 1} },
                            {"breakpoint":320, "settings": {"slidesToShow": 1} } ]'>
                    
                    @foreach($category->subcategories as $item)

                        <div class="single-slide">
                            <div class="product-card">
                                        <div class="product-header">
                                            <!-- <a href="" class="author">
                                                jpple
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
                                                    <!-- <div class="hover-btns">
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

                                                    <a target="_blank" rel="noreferrer" href="/public/pdf?link={{ $item->pdf }}" class="btn btn--primary submenu-btn">PDF</a>
                                                   @auth
                                                 
                                                    <span class="price">{{ showAmount($item->price - userDiscountWeb($item->price)) }} </span>
                                                    
                                                @else
                                                    <a href="{{ route('user.login') }}" class="btn btn--primary submenu-btn">Price</a>
                                                @endauth
                                               
                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @endforeach
               
                              <!-- end loop 2-->
               </div>
            </div>