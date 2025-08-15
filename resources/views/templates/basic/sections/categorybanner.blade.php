 @php
$subcats = App\Models\Category::where('id',$categoryId)->get();
@endphp
@foreach($subcats as $item))


                 <section class="section-margin">
            <div class="promo-wrapper promo-type-three">
                <a href="#" class="promo-image promo-overlay bg-image" data-bg="{{ getImage(imagePath()['categorybanner']['path'] . '/' . $item->image, imagePath()['categorybanner']['size']) }}">
                </a>
                
            </div>
        </section>

                 

                     @endforeach