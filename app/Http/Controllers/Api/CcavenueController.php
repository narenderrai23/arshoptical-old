<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Auth;
use App\Models\Deposit;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Session;
use Razorpay\Api\Api;
class CcavenueController extends Controller
{
   /*
* @param1 : Plain String
* @param2 : Working key provided by CCAvenue
* @return : Decrypted String
*/
public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }
function encrypt($plainText,$key)
{
	$key = $this->hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function decrypt($encryptedText,$key)
{
	$key = $this->hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = $this->hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 

 public function callback(Request $request)
    {
        $workingKey='3FB83DD23D0241518BFE059A4F4A3D81';     //Working Key should be provided here.
        $encResponse=$_POST["encResp"];         //This is the response sent by the CCAvenue Server
        $rcvdString=$this->decrypt($encResponse,$workingKey);       //Crypto Decryption used as per the specified working key.
        $order_status="";
        $order_id="";
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
         for($i = 0; $i < $dataSize; $i++) 
        {
            $information=explode('=',$decryptValues[$i]);
            if($i==3)   $order_status=$information[1];
            if($i==0)   $order_id=$information[1];
        }
	 $pageTitle='Payment Processing Result';
       

      
        if($order_status == 'Success')
        {
		 $deposit = Deposit::where('trx', $order_id)->orderBy('id', 'DESC')->first();
        $deposit->detail = $decryptValues;
        $deposit->save();
            PaymentController::userDataUpdate($deposit->trx);
           
        }
         return view($this->activeTemplate .'appccavenue-payment-view', compact('order_status', 'decryptValues','dataSize','pageTitle'));
    }

    //payment functions
    public function ccavenuepayment(Request $request)
    {


        $workingKey='3FB83DD23D0241518BFE059A4F4A3D81';		//Working Key should be provided here.
        $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
        $rcvdString=$this->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
        $order_status="";
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
        //dd($decryptValues);
	$pageTitle='Payment Failure';
	  $order_status="";
        $order_id="";
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
         for($i = 0; $i < $dataSize; $i++) 
        {
            $information=explode('=',$decryptValues[$i]);
            if($i==3)   $order_status=$information[1];
            if($i==0)   $order_id=$information[1];
        }

	if($order_status == 'Success')
        {
		 $deposit = Deposit::where('trx', $order_id)->orderBy('id', 'DESC')->first();
        $deposit->detail = $decryptValues;
        $deposit->save();
            PaymentController::userDataUpdate($deposit->trx);
           
        }
        return view($this->activeTemplate .'appccavenue-payment-view', compact('order_status', 'decryptValues','dataSize','pageTitle'));
    }
	
    public function ccavrequesthandler(Request $request)
    {

    $merchant_data='2670117';
	$working_key='3FB83DD23D0241518BFE059A4F4A3D81';
	$access_code='AVZS66LB94CI38SZIC';
	
	foreach ($_POST as $key => $value){
		//if($key != '_token')
		$merchant_data.=$key.'='.urlencode($value).'&';
	}
		//print_r($merchant_data);die;

	$encrypted_data=$this->encrypt($merchant_data,$working_key);
		//dd($encrypted_data);
        return view('web-views.ccavenue-payment', compact('encrypted_data','access_code'));
    }
}