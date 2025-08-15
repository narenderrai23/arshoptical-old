<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Cart;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Wishlist;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public $activeTemplate;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('regStatus')->except('registrationNotAllowed');

        $this->activeTemplate = activeTemplate();
    }

    public function showRegistrationForm()
    {
        $pageTitle   = "Sign Up";
        $info        = json_decode(json_encode(getIpInfo()), true);
        $mobile_code = @implode(',', $info['code']);
        $countries   = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.auth.register', compact('pageTitle', 'mobile_code', 'countries'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $general             = GeneralSetting::first();
        $password_validation = Password::min(6);

        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $agree = 'nullable';

        if ($general->agree) {
            $agree = 'required';
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));
        $validate     = Validator::make($data, [
            'firstname'    => 'sometimes|required|string|max:50',
            'lastname'     => 'sometimes|required|string|max:50',
            'email'        => 'required|string|email|max:90|unique:users',
            'mobile'       => 'required|string|max:50|unique:users',
            'password'     => ['required', 'confirmed', $password_validation],
            'username'     => 'required|alpha_num|unique:users|min:6',
            'captcha'      => 'sometimes|required',
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'agree'        => $agree,
        ]);
        return $validate;
    }

    public function register(Request $request)
    {
        $this->validateRegistration($request);

        if ($request->filled('captcha') && !captchaVerify($request->captcha, $request->captcha_secret)) {
            $notify[] = ['error', 'Invalid captcha'];
            return back()->withNotify($notify)->withInput();
        }

        $user = $this->createFromRequest($request);

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // Backward-compatible signature; delegate to Request-based creation
        $request = new Request($data);
        return $this->createFromRequest($request);
    }

    protected function validateRegistration(Request $request): array
    {
        $general = GeneralSetting::first();

        $passwordRule = Password::min(6);
        if ($general->secure_password) {
            $passwordRule = $passwordRule->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $agreeRule = $general->agree ? 'required' : 'nullable';

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        return $request->validate([
            'firstname'    => 'sometimes|required|string|max:50',
            'lastname'     => 'sometimes|required|string|max:50',
            'email'        => 'required|string|email|max:90|unique:users',
            'mobile'       => 'required|string|max:50|unique:users',
            'password'     => ['required', 'confirmed', $passwordRule],
            'username'     => 'required|alpha_num|unique:users|min:6',
            'captcha'      => 'sometimes|required',
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'agree'        => $agreeRule,
        ]);
    }

    protected function createFromRequest(Request $request): User
    {
        $general  = GeneralSetting::first();
        $referBy  = session()->get('reference');
        $referUser = $referBy ? User::where('username', $referBy)->first() : null;

        $user               = new User();
        $user->firstname    = $request->input('firstname') ?: null;
        $user->lastname     = $request->input('lastname') ?: null;
        $user->email        = Str::lower(trim((string) $request->input('email')));
        $user->password     = Hash::make((string) $request->input('password'));
        $user->username     = trim((string) $request->input('username'));
        $user->ref_by       = $referUser ? $referUser->id : 0;
        $user->country_code = (string) $request->input('country_code');
        $user->mobile       = (string) $request->input('mobile');
        $user->address      = $this->buildAddressArray($request);
        $user->status       = 0;
        $user->ev           = $general->ev ? 0 : 1;
        $user->sv           = $general->sv ? 0 : 1;
        $user->ts           = 0;
        $user->tv           = 1;
        $user->notification = now();
        $user->save();

        $this->notifyAdminOfRegistration($user);
        $this->recordLoginFromRequest($user, $request);
        $this->syncSessionCartAndWishlist($user);

        return $user;
    }

    protected function buildAddressArray(Request $request): array
    {
        return [
            'address' => '',
            'state'   => '',
            'zip'     => '',
            'country' => $request->input('country'),
            'city'    => '',
        ];
    }

    protected function notifyAdminOfRegistration(User $user): void
    {
        $adminNotification              = new AdminNotification();
        $adminNotification->user_id     = $user->id;
        $adminNotification->title       = 'New member registered';
        $adminNotification->click_url   = urlPath('admin.users.detail', $user->id);
        $adminNotification->save();
    }

    protected function recordLoginFromRequest(User $user, Request $request): void
    {
        $ip        = $request->ip();
        $existing  = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        if ($existing) {
            $userLogin->longitude    = $existing->longitude;
            $userLogin->latitude     = $existing->latitude;
            $userLogin->city         = $existing->city;
            $userLogin->country_code = $existing->country_code;
            $userLogin->country      = $existing->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude    = isset($info['long']) ? implode(',', (array) $info['long']) : null;
            $userLogin->latitude     = isset($info['lat']) ? implode(',', (array) $info['lat']) : null;
            $userLogin->city         = isset($info['city']) ? implode(',', (array) $info['city']) : null;
            $userLogin->country_code = isset($info['code']) ? implode(',', (array) $info['code']) : null;
            $userLogin->country      = isset($info['country']) ? implode(',', (array) $info['country']) : null;
        }

        $userAgent          = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;
        $userLogin->browser = $userAgent['browser'] ?? null;
        $userLogin->os      = $userAgent['os_platform'] ?? null;
        $userLogin->save();
    }

    protected function syncSessionCartAndWishlist(User $user): void
    {
        $carts = session()->get('cart');
        if ($carts) {
            foreach ($carts as $item) {
                $cart = Cart::where('user_id', $user->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if (!$cart) {
                    $cart             = new Cart();
                    $cart->user_id    = $user->id;
                    $cart->product_id = $item['product_id'];
                }

                $cart->quantity += $item['quantity'];
                $cart->save();
            }
        }

        $wishlist = session()->get('wishlist');
        if ($wishlist) {
            foreach ($wishlist as $item) {
                $existingWishlist = Wishlist::where('user_id', $user->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if (!$existingWishlist) {
                    $newWishlist             = new Wishlist();
                    $newWishlist->user_id    = $user->id;
                    $newWishlist->product_id = $item['product_id'];
                    $newWishlist->save();
                }
            }
        }
    }

    public function checkUser(Request $request)
    {
        $exist['data'] = null;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email', $request->email)->first();
            $exist['type'] = 'email';
        }

        if ($request->mobile) {
            $exist['data'] = User::where('mobile', $request->mobile)->first();
            $exist['type'] = 'mobile';
        }

        if ($request->username) {
            $exist['data'] = User::where('username', $request->username)->first();
            $exist['type'] = 'username';
        }

        return response($exist);
    }

    public function registered()
    {
        return redirect()->route('user.home');
    }
}
