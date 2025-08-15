@php
    $contactContent = getContent('contact_us.content',true);
@endphp
@extends($activeTemplate.'layouts.frontend')
@section('content')




<section class="contact-section pt-80 bg-white">
    <div class="container">
        <div class="row gy-5">


        <!-- Cart Page Start -->
        <main class="contact_area inner-page-sec-padding-bottom">
            <div class="container">
               <!--  <div class="row">
                    <div class="col-lg-12">
                        <div id="google-map"></div>
                    </div>
                </div> -->
                <div class="row mt--60 ">
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="contact_adress">
                            <div class="ct_address">
                                <h3 class="ct_title">Location & Details</h3>
                                <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.1526825669075!2d77.22062771127995!3d28.655146675550746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd13d2513035%3A0xd5593059669e9ad6!2sGali%20Kandle%20Kashan%2C%20Baradari%2C%20Chandni%20Chowk%2C%20Delhi%2C%20110006!5e0!3m2!1sen!2sin!4v1690203656945!5m2!1sen!2sin" class="embed-responsive-item" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" height="250" width="400"></iframe></p>
                            </div>
                            <div class="address_wrapper">
                                <div class="address">
                                    <div class="icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><span>Address:</span> {{ __(@$contactContent->data_values->address) }}</p>
                                    </div>
                                </div>
                                <div class="address">
                                    <div class="icon">
                                        <i class="far fa-envelope"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><span>Email: </span> {{ __(@$contactContent->data_values->contact_email) }} </p>
                                    </div>
                                </div>
                                <div class="address">
                                    <div class="icon">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><span>Phone:</span> {{ __(@$contactContent->data_values->contact_number) }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-12 mt--30 mt-md--0">
                        <div class="contact_form">
                            <h3 class="ct_title">Send Us a Message</h3>
                             <form id="contact-form" method="post" action="" class="contact-form" class="contact-form">
                        @csrf
                           
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>{{ __(@$contactContent->data_values->title) }}<span class="required">*</span></label>
                                            <input type="text" name="name" class="form-control form--control-4" placeholder="@lang('Full Name')" 
                                    value="@if(auth()->user()){{ auth()->user()->fullname }}@else{{ old('name') }}@endif"
                                    @if(auth()->user()) readonly @endif required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Your Email <span class="required">*</span></label>
                                            <input type="email" name="email" class="form-control form--control-4" placeholder="@lang('Email Address')"
                                    value="@if(auth()->user()){{ auth()->user()->email }}@else{{old('email')}} @endif"
                                    @if(auth()->user()) readonly @endif required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Your Subject*</label>
                                            <input type="text" name="subject" class="form-control form--control-4" placeholder="@lang('Subject')" value="{{old('subject')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Your Message</label>
                                            <textarea name="message" id="" cols="30" rows="10" class="form-control form--control form--control-4" placeholder="@lang('Your Message')">{{old('message')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-btn">
                                            <button type="submit" value="submit" id="submit" class="btn btn-black"
                                                name="submit">send</button>
                                        </div>
                                        <div class="form__output"></div>
                                    </div>
                                </div>
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</section>

        <!-- Cart Page End -->






@endsection