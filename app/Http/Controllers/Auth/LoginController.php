<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Extension;
use App\Models\UserLogin;
use App\Models\Wishlist;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct() {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    public function showLoginForm() {
        $pageTitle = "Sign In";
        return view(activeTemplate() . 'user.auth.login', compact('pageTitle'));
    }

    public function login(Request $request) {
        $this->validateLogin($request);

        if (isset($request->captcha)) {

            if (!captchaVerify($request->captcha, $request->captcha_secret)) {
                $notify[] = ['error', "Invalid captcha"];
                return back()->withNotify($notify)->withInput();
            }

        }

// If the class is using the ThrottlesLogins trait, we can automatically throttle

// the login attempts for this application. We'll key this by the username and

// the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

// If the login attempt was unsuccessful we will increment the number of attempts

// to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    // public function findUsername() {
    //     $login = request()->input('username');

    //     $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //     request()->merge([$fieldType => $login]);
    //     return $fieldType;
    // }
    public function findUsername() {
        $login = request()->input('login');

        if (!$login) {
            return 'username'; // Default fallback
        }

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } elseif (preg_match('/^[0-9]{10}$/', $login)) {
            $fieldType = 'mobile';
        } else {
            $fieldType = 'username'; // Default for any other input
        }

        request()->merge([$fieldType => $login]);
        return $fieldType;
    }
    

    public function username() {
        return $this->findUsername(); 
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('login', 'password');
        $field = $this->username();
        
        // Map the login field to the correct database field
        $credentials[$field] = $credentials['login'];
        unset($credentials['login']);
        
        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $notify[] = ['error', 'Invalid login credentials.'];
        return back()->withNotify($notify)->withInput($request->only('login'));
    }

    protected function validateLogin(Request $request) {
        $customRecaptcha = Extension::where('act', 'custom-captcha')->where('status', 1)->first();
        $validation_rule = [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    
        if ($customRecaptcha) {
            $validation_rule['captcha'] = 'required';
        }
    
        $request->validate($validation_rule);
    }
    

    public function logout() {
        $this->guard()->logout();

        request()->session()->invalidate();

        $notify[] = ['success', 'You have been logged out.'];
        return redirect()->route('user.login')->withNotify($notify);
    }

    public function authenticated(Request $request, $user) {

        if ($user->status == 0) {
            $this->guard()->logout();
            $notify[] = ['error', 'Your account has been deactivated.'];
            return redirect()->route('user.login')->withNotify($notify);
        }

        $user->tv = $user->ts == 1 ? 0 : 1;
        $user->save();
        $ip        = $_SERVER["REMOTE_ADDR"];
        $exist     = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        if ($exist) {
            $userLogin->longitude    = $exist->longitude;
            $userLogin->latitude     = $exist->latitude;
            $userLogin->city         = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country      = $exist->country;
        } else {
            // IP geolocation removed - setting default values
            $userLogin->longitude    = null;
            $userLogin->latitude     = null;
            $userLogin->city         = null;
            $userLogin->country_code = null;
            $userLogin->country      = null;
        }

        $userAgent          = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os      = @$userAgent['os_platform'];
        $userLogin->save();

        $carts = session()->get('cart');

        if ($carts) {

            foreach ($carts as $data) {
                $cart = Cart::where('user_id', $user->id)->where('product_id', $data['product_id'])->first();

                if (!$cart) {
                    $cart             = new Cart();
                    $cart->user_id    = $user->id;
                    $cart->product_id = $data['product_id'];
                }

                $cart->quantity += $data['quantity'];
                $cart->save();

            }

        }

        $wishlist = session()->get('wishlist');

        if ($wishlist) {

            foreach ($wishlist as $data) {

                $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $data['product_id'])->first();

                if (!$wishlist) {
                    $wishlist             = new Wishlist();
                    $wishlist->user_id    = $user->id;
                    $wishlist->product_id = $data['product_id'];
                    $wishlist->save();
                }

            }

        }

        return redirect()->route('user.home');
    }

}