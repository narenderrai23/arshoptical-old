@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="account-section pt-60 bg-white">
    <div class="container">
        <div class="account-wrapper">
            <div class="row">
                <div class="col-lg-6 col-md-8 m-auto">
                    <div class="card cmn--card">
                        <div class="card-body p-3 p-sm-4">
                            <div class="account-header mb-0 text-center">
                                <h5 class="title">@lang('Reset Password')</h5>
                            </div>
                            <form class="account-form" method="POST" action="{{ route('user.password.update') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                </div>
                                <div class="form-group hover-input-popup">
                                    <label for="password" class="form--label form-label">@lang('Password')</label>
                                    <input type="password" id="password"
                                        class="form-control form--control @error('password') is-invalid @enderror"
                                        name="password" required autofocus="off">
                                         <button type="button" class="btn btn-sm btn-light position-absolute" 
                                        style="top: 66%; right: -24px; transform: translateY(-50%); border: none; background: transparent;"
                                        onclick="togglePassword()">
                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                    </button>
                                    
                                    @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group hover-input-popup">
                                    <label for="password-confirm" class="form--label form-label">
                                        @lang('Confirm Password')
                                    </label>
                                    <input type="password" id="password-confirm" class="form-control form--control"
                                        name="password_confirmation" required autofocus="off">
                                        <button type="button" class="btn btn-sm btn-light position-absolute" 
                                        style="top: 66%; right: -24px; transform: translateY(-50%); border: none; background: transparent;"
                                        onclick="togglePasswordConf()">
                                        <i id="eyeIconConf" class="fa fa-eye"></i>
                                    </button>
                                    
                                </div>
                                <div class="mt-4">
                                    <button class="btn btn-outlined" type="submit">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@push('style-lib')
<link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/custom.css') }}">
@endpush

@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function($) {
        "use strict";
        @if ($general->secure_password)
            $('input[name=password]').on('input',function(){
            secure_password($(this));
            });
        @endif
    })(jQuery);
    
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
      function togglePasswordConf() {
        let passwordField = document.getElementById("password-confirm");
        let eyeIcon = document.getElementById("eyeIconConf");

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