@php
$footerAddress = getContent('contact_us.content',true);
$paymentOption = getContent('footer.element',false,null,true);
$footerContent = getContent('footer.content',true);
$socialIcons = getContent('social_icon.element',false,null,true);
$categoryList = App\Models\Category::where('status',1)->with('subcategories')->latest()->limit(6)->get();
$policyPages = getContent('policy_pages.element', false, null, true);
$headerContent = getContent('contact_us.content',true);
@endphp

<a href="https://wa.me/message/DZBGVDMWBEISK1" class="whatsapp-button" target="_blank" style="position: fixed;  left: 30px; bottom: 30px;z-index: 99999999;">
  <img src="{{ asset('image/icon/WhatsAppIcon.png') }}" style="width:60px;" alt="whatsapp">
</a>
 <footer class="site-footer">
        <div class="container">
            <div class="row justify-content-between  section-padding">
                <div class=" col-xl-3 col-lg-3 col-sm-12">
                    <div class="single-footer pb--40">
                        <div class="footer-title">
                            <h3>Contact Us</h3>
                        </div>
                        <div class="footer-contact">
                            <p><span class="label">@lang('Address'):</span><span class="text">{{ __(@$footerAddress->data_values->address) }}</span></p>

                            <p><span class="label">Phone:</span><span class="text">{{ __(@$headerContent->data_values->contact_number) }}</span></p>
                            <p><span class="label">Email:</span><span class="text">{{ __(@$headerContent->data_values->contact_email) }}</span></p>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-9 col-lg-9 col-sm-12">
                    <div class="row justify-content-between">
                        <div class=" col-xl-3 col-lg-3 col-sm-12">
                            <div class="single-footer pb--40">
                                <div class="footer-title">
                                    <h3>Top Categories</h3>
                                </div>
                                <ul class="footer-list normal-list">
                                    @php 
                                     $cats = App\Models\Category::active()->where('featured', 1)->orderBy('orderno')->take(6)->get();
                                    @endphp
                                     @foreach ($cats as  $key  => $row)
                                    <li><a href="{{ route('category.products',['id'=>$row->id,'name'=>slug($row->name)]) }}">{{$row->name}}</a></li>
                                        @endforeach 

                                </ul>
                            </div>
                        </div>
                        <div class=" col-xl-3 col-lg-3 col-sm-12">
                            <div class="single-footer pb--40">
                                <div class="footer-title">
                                    <h3>Extras</h3>
                                </div>
                                <ul class="footer-list normal-list">
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                @foreach ($policyPages as $policy)  
                                <li><a href="{{ route('page.details', [$policy->id, slug($policy->data_values->title)]) }}">{{ __(@$policy->data_values->title) }}{{ $loop->last ? '' : '' }}</a></li>
                            @endforeach
                                   <!-- <li><a href="">Privacy & Policy</a></li>
                                    <li><a href="">Shipping & Delivery Policy</a></li>
                                    <li><a href="">Terms & Conditions</a></li>
                                    <li><a href="">Cancellation & Refund Policy </a></li>-->
                                </ul>
                            </div>
                        </div>
                        <div class=" col-xl-3 col-lg-3 col-sm-12">
                    <div class="footer-title">
                        <h3>WhatsApp Subscribe</h3>
                    </div>
                    <div class="newsletter-form mb--30">
                        <div class="newsletter-form mb--30">
                     
                       <form class="newletter-form">

                            <input type="number" class="form-control subscribe-email" placeholder="@lang('Enter Your Whatsapp No.')">
                            <button class="btn btn--primary w-100 subscribe-btn">Subscribe</button>
                       </form>
                    </div>
                    </div>


         @php 


         $key='social_icon';
         $section = @getPageSections()->$key;
        $content = App\Models\Frontend::where('data_keys', $key . '.content')->orderBy('id','desc')->first();
        $elements = App\Models\Frontend::where('data_keys', $key . '.element')->orderBy('id')->orderBy('id','desc')->get();
        @endphp
                    <div class="social-block">
                        <h3 class="title">STAY CONNECTED</h3>
                        <ul class="social-list list-inline">
                              @foreach($elements as $k => $type)
                            
                             <li class="single-social {{$type->data_values->title}}"><a href="{{$type->data_values->url}}">
@php echo   $type->data_values->social_icon @endphp</a></li>
                             
                             @endforeach
                            
                        </ul>
                    </div>
                </div>
                        <div class=" col-xl-3 col-lg-3 col-sm-12">
                            <div class="footer-title">
                                <h3>Install App</h3>
				<p>From Google Play or App 
Store</p>
				<div class="text-center text-lg-start mt-4">
                                <a href="https://play.google.com/store/apps/details?id=com.arshoptical.app&pcampaignid=web_share" target="_blank" class="download-btn"><i class="lab la-google-play"></i> <span><small>Go it on</small><br>Google Play</span></a>
                                <a href="https://apps.apple.com/in/app/arsh-optical-jsb/id6566179332" target="_blank" class="download-btn mt-2"><i class="lab la-apple"></i> <span><small>Download on the</small><br>App Store</span></a>
                            </div>


                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


       
        <div class="footer-bottom">
            <div class="container">
                <p class="copyright-heading">This is Arsh Optical from Delhi. We deals in optical eyeglasses in wholesale and to provide our best services in entire optical retail market.</p>
                <a href="#" class="payment-block">
                    <img src="/image/icon/payment.png" alt="">
                </a>
                <p class="copyright-text">Copyright © 2024 <a href="https://www.arshopticals.com" class="author">Arsh Optical</a>. All Right Reserved.
                    <br>
                    Design By Arsh Optical</p>
            </div>
        </div>
    </footer>
<!--Start of Tawk.to Script-->

<script type="text/javascript">

var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();

(function(){

var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];

s1.async=true;

s1.src='https://embed.tawk.to/65e95ef38d261e1b5f69d055/1hobplqug';

s1.charset='UTF-8';

s1.setAttribute('crossorigin','*');

s0.parentNode.insertBefore(s1,s0);

})();

</script>

<!--End of Tawk.to Script-->