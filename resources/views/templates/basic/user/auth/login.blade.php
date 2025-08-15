@php
$content = getContent('login.content', true);
@endphp
@extends($activeTemplate.'layouts.frontend')
@section('content')
 <style>
    .position-absolute {
    top: 50%!important;
    right: -36px!important;
    transform: translateY(-50%)!important;
    border: none!important;
    background: transparent!important;
}
 </style>
<main class="page-section inner-page-sec-padding-bottom">
<section class="account-section pt-60 bg-white">
    <div class="container">
        <div class="account-wrapper">
            <div class="row gy-5 align-items-center">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="account-thumb rtl">
                        <img src="{{ getImage('assets/images/frontend/login/'.@$content->data_values->image,'636x648') }}" alt="thumb">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="account-right ps-lg-5">
                        <div class="account-header mb-4">
                            <h5 class="title mb-1">{{ __(@$content->data_values->heading) }}</h5>
                            <p class="mb-0 fs--14px">{{ __(@$content->data_values->sub_heading) }}</p>
                        </div>
                        <form class="account-form" method="POST" action="{{ route('user.login') }}" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form--label form-label">@lang('Email or Mobile')<span class="text--danger">*</span></label>
                                <input type="text" id="email" class="form-control form--control" name="login" value="{{ old('username') }}">
                            </div>
                              <div class="form-group">
                                <label for="password" class="form--label form-label">
                                    @lang('Password')<span class="text--danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <input type="password" id="password" class="form-control form--control" name="password">
                                    <button type="button" class="btn btn-sm btn-light position-absolute" 
                                        style="top: 50%; right: 10px; transform: translateY(-50%); border: none; background: transparent;"
                                        onclick="togglePassword()">
                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form--group">
                                @php echo loadReCaptcha() @endphp
                            </div>
                            @include($activeTemplate.'partials.custom_captcha')

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="form-check form--check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">@lang('Remember Me')</label>
                                </div>
                                <a href="{{ route('user.password.request') }}" class="text--base fs--14px">
                                    @lang('Forgot Password?')
                                </a>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-outlined" type="submit">@lang('Sign In')</button>
                            </div>
                            <div class="mt-3 fs--14px">
                                @lang('Don\'t have an account ?')
                                <a href="{{ route('user.register') }}" class="btn btn-outlined">@lang('Create account now')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection

@push('script')
<script>
    "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        
        
         function togglePassword() {
        let passwordField = document.getElementById("password");
        let eyeIcon = document.getElementById("eyeIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
@endpush