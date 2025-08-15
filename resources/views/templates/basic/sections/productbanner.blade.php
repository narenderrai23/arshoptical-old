 @php
$subcats = App\Models\SubCategory::where('id',$subcategoryId)->get();
@endphp

<style>
@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
.promo-wrapper.promo-type-three{height: 120px !important;}
.section-margin{margin-bottom:0px !important;}
.product-view-mode{display:none !important;}
}</style>
@foreach($subcats as $item))


                 <section class="section-margin">
            <div class="promo-wrapper promo-type-three">
                <a href="#" class="promo-image promo-overlay bg-image" data-bg="{{ getImage(imagePath()['categorybanner']['path'] . '/' . $item->banner, imagePath()['categorybanner']['size']) }}">
                </a>
                
            </div>
        </section>

                 

                     @endforeach