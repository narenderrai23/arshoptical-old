<?php

namespace App\Http\Controllers\Gateway\PhonePe;

use App\Models\Deposit;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use Session;
use Razorpay\Api\Api;
use Auth;


class ProcessController extends Controller
{
    /*
     * PhonePe Gateway
     */

    public static function process($deposit)
    {
                $orderid=uniqid();
        //round($deposit->final_amo * 100)
        $data = array (
            'merchantId' => 'M220AA571J6KQ',
            'merchantTransactionId' => $orderid,
            'merchantUserId' => 'MUID123',
            'amount' => 1,
            'redirectUrl' => route(gatewayRedirectUrl(true)),
            'redirectMode' => 'POST',
            'callbackUrl' => route('ipn.'.$deposit->gateway->alias),
            'mobileNumber' => '9910035373',
            'paymentInstrument' => 
            array (
            'type' => 'PAY_PAGE',
            ),
        );
        $deposit->btc_wallet = $orderid;
        $deposit->save();
       
$apiKey='25c4e44c-5516-456d-a6e4-17cfc7a64c4f';
$url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";
	
		$encode = json_encode($data);
                $payloadMain = base64_encode($encode);
                $salt_index = 1; //key index 1
                $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
                $sha256 = hash("sha256", $payload);
                $final_x_header = $sha256 . '###' . $salt_index;
                $request = json_encode(array('request'=>$payloadMain));
		$curl = curl_init();
		curl_setopt_array($curl, [
  		CURLOPT_URL => $url,
  		CURLOPT_RETURNTRANSFER => true,
  		CURLOPT_ENCODING => "",
 		 CURLOPT_MAXREDIRS => 10,
 		 CURLOPT_TIMEOUT => 30,
 		 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 		 CURLOPT_CUSTOMREQUEST => "POST",
 		  CURLOPT_POSTFIELDS => $request,
 		 CURLOPT_HTTPHEADER => [
   		 "Content-Type: application/json",
    		 "X-VERIFY: " . $final_x_header,
     		"accept: application/json"
  		],
		]);



$response = curl_exec($curl);
dd($response);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
   $res = json_decode($response);


   
   if(isset($res->code) && ($res->code=='PAYMENT_INITIATED')){
 
  $payUrl=$res->data->instrumentResponse->redirectInfo->url;
 
 return redirect()->away($payUrl);
   }else{
   //HANDLE YOUR ERROR MESSAGE HERE
            dd('ERROR : '.$err );
   }
}
    }




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