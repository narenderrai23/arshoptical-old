<?php

namespace App\Http\Controllers\Gateway\ccavenue;
use Auth;
use App\Models\Deposit;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use Session;
use Razorpay\Api\Api;


class ProcessController extends Controller
{
    /*
     * PhonePe Gateway
     */
 public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }
    public static function process($deposit)
    {
               // $orderid=uniqid();

		 $orderid=$depost->trx;
               // dd($depost->trx);

                return view(activeTemplate() . 'user.payment.ccavenue', compact('deposit','orderid'));
    }
    //               @php($config=\App\CPU\Helpers::get_business_settings('ccavenue'))
    //                         @if(isset($config) && $config['status'])

    //                         @php($config=\App\CPU\Helpers::get_business_settings('ccavenue'))
    //                                         @php($user=auth('customer')->user())
    //                                         @php($workingKey = $config['working_key'])
    //                                         @php($data = new \stdClass())
    //                                         @php($data->merchantId = $config['merchant_id'])
    //                                         @php($data->accessCode = $config['access_code'])
    //                                         @php($data->detail = 'payment')
    //                                         @php($data->order_id = session('cart_group_id'))
    //                                         @php($data->amount = \App\CPU\Convert::usdTomyr($amount))
    //                                         @php($data->name = $user->f_name.' '.$user->l_name)
    //                                         @php($data->email = $user->email)
    //                                         @php($data->phone = $user->phone)
    //                                         @php($data->hashed_string = md5($workingKey . urldecode($data->detail) . urldecode($data->amount) . urldecode($data->order_id)))
                           
    //                         @endif
    // }




    public function ipn(Request $request)
    {


        if($request->code == 'PAYMENT_SUCCESS')
    {
        $transactionId = $request->transactionId;
        $merchantId=$request->merchantId;
       $providerReferenceId=$request->providerReferenceId;
       $merchantOrderId=$request->merchantOrderId;
       $checksum=$request->checksum;
       $status=$request->code;
       $deposit = Deposit::where('btc_wallet', $request->transactionId)->orderBy('id', 'DESC')->first();
       //Transaction completed, You can add transaction details into database
 
 
       $data = ['providerReferenceId' => $providerReferenceId, 'checksum' => $checksum,];
        if($merchantOrderId !=''){
        $data['merchantOrderId']=$merchantOrderId;
        }
 
        if (!$deposit) {
            $notify[] = ['error', 'Invalid request'];
        }
        
        
        $deposit->detail = $request->all();
        $deposit->save(); 
         
      



 
            PaymentController::userDataUpdate($deposit->trx);
            $notify[] = ['success', 'Transaction was successful'];
            return redirect()->route(gatewayRedirectUrl(true))->withNotify($notify);
        } else {
            $notify[] = ['error', "Invalid Request"];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        //$input = $request->all();

        // $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        // $saltIndex = 1;

        // $finalXHeader = hash('sha256','/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'].$saltKey).'###'.$saltIndex;

        // $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'])
        //         ->withHeader('Content-Type:application/json')
        //         ->withHeader('accept:application/json')
        //         ->withHeader('X-VERIFY:'.$finalXHeader)
        //         ->withHeader('X-MERCHANT-ID:'.$input['transactionId'])
        //         ->get();

        // dd(json_decode($response));

        // $deposit = Deposit::where('trx', $_POST['custom'])->orderBy('id', 'DESC')->first();
        //     $deposit->detail = $details;
        //     $deposit->save();


        // $deposit = Deposit::where('btc_wallet', $request->razorpay_order_id)->orderBy('id', 'DESC')->first();
        // $razorAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);

        // if (!$deposit) {
        //     $notify[] = ['error', 'Invalid request'];
        // }
        
        // $sig = hash_hmac('sha256', $request->razorpay_order_id . "|" . $request->razorpay_payment_id, $razorAcc->key_secret);
        // $deposit->detail = $request->all();
        // $deposit->save();

        // if ($sig == $request->razorpay_signature && $deposit->status == '0') {
        //     PaymentController::userDataUpdate($deposit->trx);
        //     $notify[] = ['success', 'Transaction was successful'];
        //     return redirect()->route(gatewayRedirectUrl(true))->withNotify($notify);
        // } else {
        //     $notify[] = ['error', "Invalid Request"];
        //     return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        // }

    }
}