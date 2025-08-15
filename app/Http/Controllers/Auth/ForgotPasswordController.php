<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showLinkRequestForm()
    {
        $pageTitle = "Forgot Password";
        return view(activeTemplate() . 'user.auth.passwords.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        if ($request->type == 'email') {
            $validationRule = [
                'value'=>'required|email'
            ];
            $validationMessage = [
                'value.required'=>'Email field is required',
                'value.email'=>'Email must be a valid email'
            ];

        }elseif($request->type == 'username'){
            $validationRule = [
                'value'=>'required'
            ];
            $validationMessage = ['value.required'=>'Username field is required'];
        }elseif($request->type == 'phone'){

            $validationRule = [
                'value'=>'required'
            ];
            $validationMessage = ['value.required'=>'Mobile No. is required'];

            $mobile = $request->value; 
            $otp = rand(1000, 9999);

            $currentDateTime = Carbon::now(); 
            $otp_expiry = $currentDateTime->addMinutes(10);
            
            $msg = "Your OTP for mobile verification is '.$otp.' Do not share with anyone. ARSH OPTICAL";
            
            sendMessage($mobile,$msg);

            session()->put('otp',$otp);

            $user = User::where('mobile', $request->value)->first();
            PasswordReset::where('mobile', $user->mobile)->delete();
            session()->put('pass_res_mail',$user->email);
            $password = new PasswordReset();
            $password->mobile = $user->mobile;
            $password->email = $user->email;
            $password->token = $otp;
            $password->created_at = \Carbon\Carbon::now();
            $password->save();

            $notify[] = ['success', 'OTP sent successfully'];
        return redirect()->route('user.password.code.verify')->withNotify($notify);
        }
        else{
            $notify[] = ['error','Invalid selection'];
            return back()->withNotify($notify);
        }

        $request->validate($validationRule,$validationMessage);

        $user = User::where($request->type, $request->value)->first();
        
        if (!$user) {
            $notify[] = ['error', 'User not found.'];
            return back()->withNotify($notify);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $userBrowserInfo = osBrowser();
        sendEmail($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => request()->ip(),
            'time' => now()->format('d-m-Y h:i:s A')
        ]);

        $pageTitle = 'Account Recovery';
        $email = $user->email;
        session()->put('pass_res_mail',$email);
        $notify[] = ['success', 'Password reset email sent successfully'];
        return redirect()->route('user.password.code.verify')->withNotify($notify);
    }

    public function codeVerify(){
        $pageTitle = 'Account Recovery';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return redirect()->route('user.password.request')->withNotify($notify);
        }
        return view(activeTemplate().'user.auth.passwords.code_verify',compact('pageTitle','email'));
    }

    public function verifyCode(Request $request)
    {
        


        $request->validate([
            'code' => 'required'
        ]);
        $code =  str_replace(' ', '', $request->code);
        $email = session()->get('pass_res_mails');
        if(session()->get('otp')==$email){
            
            $notify[] = ['success', 'You can change your password.'];
            session()->flash('fpass_email', $code);
            return redirect()->route('user.password.reset', $code)->withNotify($notify);
           }

        // if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
        //     $notify[] = ['error', 'Invalid token'];
        //     return redirect()->route('user.password.request')->withNotify($notify);
        // }
        $notify[] = ['success', 'You can change your password.'];
        session()->flash('fpass_email', $request->email);
        return redirect()->route('user.password.reset', $code)->withNotify($notify);
    }

}