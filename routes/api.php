<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('Api')->name('api.')->group(function(){
	Route::get('general-setting','BasicController@generalSetting');
	Route::get('unauthenticate','BasicController@unauthenticate')->name('unauthenticate');
	Route::get('languages','BasicController@languages');
	Route::get('language-data/{code}','BasicController@languageData');
	Route::get('categories','ApiController@categories');
	Route::post('categoryproducts','ApiController@catproducts');
	Route::post('subcategories','ApiController@subcategories');
	Route::post('products','ApiController@products');
	Route::post('productscolors','ApiController@productsColors');
	Route::get('brands','ApiController@brands');
	Route::post('userregister','ApiController@register');
	Route::post('userlogin','ApiController@userlogin');
	Route::post('checklogin','ApiController@checklogin');
	Route::post('myordersdetails','ApiController@order_details');
	Route::post('myorders','ApiController@myorders');
	Route::post('paymentdata','ApiController@paymentdata');
	Route::post('myprofile','ApiController@myprofile');
	Route::post('updatepassword','ApiController@updatepassword');
	Route::post('updateprofile','ApiController@updateprofile');
	Route::post('addtomycart','ApiController@addToMyCart');
	Route::post('cartcount','ApiController@CartCount');
	Route::post('viewcartproducts','ApiController@viewCartProducts');
	Route::post('updatemycart','ApiController@updateMyCart');
	Route::post('deletemycart','ApiController@deleteMyCart');
	Route::post('mycouponapply','ApiController@myCouponApply');
	Route::post('apporder','ApiController@appOrder');
	Route::get('getbanners','ApiController@getBanners');
	Route::get('getnotification','ApiController@getNotification');
	Route::get('getnotificationcount','ApiController@getNotificationCount');
	Route::post('deleteprofile','ApiController@deleteProfile');
	Route::post('resetpassotp','ApiController@sendOTPPassword');
	Route::post('resetnewpassword','ApiController@resetNewPassword');
	Route::post('getuserdata','ApiController@getuserdata');

	Route::get('appdeposit','ApiController@appDeposit');
	Route::post('appdepositinsert','ApiController@appDepositInsert')->name('deposit.insert');
	Route::get('appdepositpreview','ApiController@appDepositPreview')->name('deposit.preview');
	Route::get('apppaymentconfirm', 'ApiController@appDepositConfirm')->name('deposit.confirm');
	Route::post('apppaymentrequest', 'CcavenueController@ccavrequesthandler')->name('ccav-request-handler');
	Route::post('ccavenue-payment', 'CcavenueController@ccavenuepayment')->name('paymentccavenue');
	Route::any('ccavenue-response', 'CcavenueController@callback')->name('ccavenue-response');

	Route::namespace('Auth')->group(function(){
		Route::post('login', 'LoginController@login');
		Route::post('register', 'RegisterController@register');
		
	    Route::post('password/email', 'ForgotPasswordController@sendResetCodeEmail');
	    Route::post('password/verify-code', 'ForgotPasswordController@verifyCode');
	    
	    Route::post('password/reset', 'ResetPasswordController@reset');
	});


	Route::middleware('auth.api:sanctum')->name('user.')->prefix('user')->group(function(){
		Route::get('logout', 'Auth\LoginController@logout');
		Route::get('authorization', 'AuthorizationController@authorization')->name('authorization');
	    Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
	    Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
	    Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
	    Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

	    Route::middleware(['checkStatusApi'])->group(function(){
	    	Route::get('dashboard',function(){
	    		return auth()->user();
	    	});

            Route::post('profile-setting', 'UserController@submitProfile');
            Route::post('change-password', 'UserController@submitPassword');

            // Withdraw
            Route::get('withdraw/methods', 'UserController@withdrawMethods');
            Route::post('withdraw/store', 'UserController@withdrawStore');
            Route::post('withdraw/confirm', 'UserController@withdrawConfirm');
            Route::get('withdraw/history', 'UserController@withdrawLog');


            // Deposit
            Route::get('deposit/methods', 'PaymentController@depositMethods');
            Route::post('deposit/insert', 'PaymentController@depositInsert');
            Route::get('deposit/confirm', 'PaymentController@depositConfirm');

            Route::get('deposit/manual', 'PaymentController@manualDepositConfirm');
            Route::post('deposit/manual', 'PaymentController@manualDepositUpdate');

            Route::get('deposit/history', 'UserController@depositHistory');

            Route::get('transactions', 'UserController@transactions');

	    });
	});
});