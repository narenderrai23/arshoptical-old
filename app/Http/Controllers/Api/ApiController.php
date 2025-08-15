<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\GeneralSetting;
use App\Models\OrderDetail;
use App\Models\ShippingMethod;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Notification;
use App\Models\PasswordReset;

class ApiController
{


    protected $activeTemplate;
    
    public function __construct() {
        session_start();
        return $this->activeTemplate = activeTemplate();
    }

   public function login(Request $request)
    {
        
     $validator = validator($request->all(), [ 'mobile' => 'required|numeric|digits:10|exists:users',
            'password' => 'required', ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()->toArray()]);
        }

        if (Auth::attempt(['mobile' => $request->username, 'password' => $request->password])) {
           // $token = Auth()->user()->createToken(Auth::user()->name)->plainTextToken;
           // return response()->json(['status' => 200, 'message' => 'Successfully logged in.', 'token' => $token, 'user' => Auth::user()]);
        }

       // return response()->json(['status' => 400, 'message' => 'Credential not matched our records.']);
    }



    

    public function checklogin(Request $request){


         $user=User::where('id',$request->userid ) 
                ->where('status',1)->first();

    if ($user) {

          
                return response()->json(['status' => 200, 'message' => $user]);
           
        }
        else{
        return response()->json(['status' => 400, 'message' => 'User not found or contact admin for login approval.']);
        }
    }
    public function userlogin(Request $request){

    //where('email',$request->username)->orWhere('mobile',$request->username)->where('status',1)->first();
         $user=User::where(function ($query) use ($request) {
                $query->where('email',$request->username)
            ->orWhere('mobile',$request->username);
            })
            ->where('status',1)->first();

    if ($user) {

           if(Hash::check($request->password, $user->password))
           {
                return response()->json(['status' => 200, 'message' => 'Successfully logged in.', 'user' => $user]);
            }
            else{
                return response()->json(['status' => 400, 'message' => 'Credential not matched our records.'.Hash::make($request->password)]);
            }
        }
        else{
        return response()->json(['status' => 400, 'message' => 'User not found or contact admin for login approval.']);
        }
    }

    public function categories(Request $request)
    {

       $data=Category::where('status',1)->orderBy('orderno')->get();

        return response()->json(['status' => 200, 'data' => $data]);
    
    }


     public function subcategories(Request $request)
    {
    
       $data=SubCategory::where('category_id',$request->catid)->where('status',1)->orderBy('orderno')->get();

        return response()->json(['status' => 200, 'data' => $data]);
    
    }


    public function catproducts(Request $request)
    {
    
       $data=Product::where('category_id',$request->catid)->get();
       
       
    
        return response()->json(['status' => 200, 'data' => $data]);
    
    }


    public function getBanners(Request $request){

        $bannermobile = getContent('bannermobile.element',false,null,true);
        $bannerbottom = getContent('bannerbottom.element',false,null,true);
        $bannermiddle = getContent('bannermiddle.element',false,null,true);

        return response()->json(['status' => 200, 'bannermobile' => $bannermobile, 'bannerbottom' => $bannerbottom, 'bannermiddle' => $bannermiddle]);
    }

    public function products(Request $request)
    {
    
       //$data=Product::where('category_id',$request->catid)->where('subcategory_id',$request->subcatid)->get();

     $products     = Product::active()->with('reviews');
     $products = $products->filterProduct($request->subcatid)->get();
     

        return response()->json(['status' => 200, 'data' => $products,'count' => count($products)]);
    
    }


      public function getuserdata(Request $request)
    {
    
      $user = User::where('id',$request->userid)->first();
      return response()->json(['status' => 200, 'user' => $user]);
    
    }


public function productsColors(Request $request)
    {
    
       $data=Product::where('id',$request->id)->with('productGallery')->get();
       //$data=ProductGallery::where('product_id',$request->id)->get();
        return response()->json(['status' => 200, 'data' => $data]);
    
    }


public function brands(Request $request)
    {
    
       $data=Brand::all();

        return response()->json(['status' => 200, 'data' => $data]);
    
    }
    public function userVerified()
    {
        return response()->json(['status' => Auth::user()->customers->is_verified ? 200 : 400, 'user' => Auth::user(), 'is_verified' => Auth::user()->customers->is_verified], 200);
    }

    public function register(Request $request)
    {


        $exist = User::where('mobile',$request->mobile_code.$request->mobile)
        ->orWhere('email',$request->email)->first();
        if ($exist) {
            $response[] = 'The mobile/email already exists';
            return response()->json([
                'code'=>409,
                'status'=>'conflict',
                'message'=>['error'=>$response],
            ]);
        }
        
         $general = GeneralSetting::first();
        $user = new User;
        $user->firstname=$request->firstname;
        $user->lastname=$request->lastname;
        $user->username =$request->username ;
        $user->email=$request->email;
        $user->country_code="IN";
        $user->password=Hash::make($request->password);
        $user->mobile=$request->mobile_code.$request->mobile;
        $user->address      = [
            'address' => '',
            'state'   => '',
            'zip'     => '',
            'country' => isset($data['country']) ? $data['country'] : null,
            'city'    => '',
        ];
        $user->status = 0;
        $user->ev     = $general->ev ? 0 : 1;
        $user->sv     = $general->sv ? 0 : 1;
        $user->ts     = 0;
        $user->tv     = 1;
        $user->save();

        
        return response()->json([
            'code'=>202,
            'status'=>'created',
            'message'=>['success'=>'User successfully created'],
            'data'=>$user
        ]);
        
    }

    function myorders(Request $request){
        $data= Order::where('user_id', $request->id)->with('deposit')->orderBy('id','DESC')->get();

        return response()->json(['status' => 200, 'data' => $data]);
     }

    function order_details(Request $request){
        $data= Order::where('id', $request->orderid)->where('user_id', $request->id)->with(['orderDetail.product','orderDetail.galleryImage', 'coupon', 'shipping', 'deposit.gateway', 'user'])->first();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    function paymentdata(Request $request){
        $data= Transaction::where('user_id', $request->id)->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    function myprofile(Request $request){
        $data = User::where('id',$request->id)->first();
        return response()->json(['status' => 200, 'data' => $data]);
    }
    function updatepassword(Request $request){


         $user = User::where('id',$request->id)->first();
         if (Hash::check($request->current_password, $user->password)) {
                $password       = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                return response()->json(['status' => 200, 'message' => 'Password change sucessfully']);
            } else {
                
                return response()->json(['status' => 200, 'message' => 'The password doesn\'t match!']);
            }
    }
    function updateprofile(Request $request){

        $user = User::where('id',$request->id)->first();
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;

        if ($request->hasFile('image')) {
            $location    = imagePath()['profile']['user']['path'];
            $size        = imagePath()['profile']['user']['size'];
            $filename    = uploadImage($request->image, $location, $size, $user->image);
            $user->image = $filename;
        }

        $address = [
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'country' => @$user->address->country,
            'city'    => $request->city,
        ];

        $user->address = $address;

        $user->save();
         return response()->json(['status' => 200, 'message' => 'Profile updated sucessfully!']);
    }


    public function addToMyCart(Request $request) {

      

        $product = Product::active()->where('id',$request->product_id)->first();
        $productgallery = ProductGallery::where('id',$request->color_id)->first();
        $color =$request->color;
        $color_id =$request->color_id;
        $user_id = $request->user_id;
        $cart_id = $request->product_id.$color_id;
        $cart='';

        if ($request->quantity > $productgallery->qty) {
            return response()->json(['error' => 'Requested quantity is not available in our stock.']);
        }

        if ($user_id) {
            $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id',$color_id)->first();

            if ($cart) {

                if (($cart->quantity + $request->quantity) >= $productgallery->qty) {
                    return response()->json(['error' => 'Requested quantity is not available in our stock.']);
                }

                $cart->quantity += $request->quantity;
                $cart->save();

            } else {

                $cart             = new Cart();
                $cart->user_id    = $user_id;
                $cart->product_id = $request->product_id;
                $cart->color = $request->color;
                $cart->color_id = $request->color_id;
                $cart->quantity   = $request->quantity;
                $cart->save();

            }

        } 

        return response()->json(['success' => 'Product added to shopping cart','data' => $cart ]);

    }

    public function  CartCount(Request $request) {

         $user_id = $request->id;

        if ($user_id) {
            $data= Cart::where('user_id', $user_id)->count();
            return response()->json(['status' => 200, 'data' => $data]);
        }
        else{
             return response()->json(['status' => 400, 'message' => 'Cart is empty']);
        }


    }


     public function viewCartProducts(Request $request) {
        
        $user_id= $request->id;
         
            $data = Cart::select('carts.*','products.price','products.quantity as gst','products.model_no','products.name','product_galleries.image','product_galleries.qty')
            ->join('products','carts.product_id', '=', 'products.id')
            ->join('product_galleries','carts.color_id', '=', 'product_galleries.id')
            ->where('carts.user_id', $user_id)->orderBy('carts.id', 'asc')->get();
            if($data){
                return response()->json(['status' => 200, 'data' => $data]);
            }
            else{
               return response()->json(['status' => 400, 'message' => 'Cart is empty']); 
            }

           
    }




    public function updateMyCart(Request $request) {
        
        $color_id=$request->color_id;
       
        
        $product = Product::active()->where('id',$request->product_id)->first();

        $productgallery = ProductGallery::where('id',$request->color_id)->first();
       
        $user_id = $request->id;
        $cart_id = $product->id.$color_id;
        if ($request->quantity > $productgallery->qty) {
             $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id', $request->color_id)->first();

            return response()->json(['error' => 'Requested quantity is not available in our stock.','qty' =>  $cart->quantity]);
        }

        if ($user_id != null) {

            $cart= Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id', $request->color_id)->first();
            $cart->quantity = $request->quantity;
            $cart->save();
        } 
       $data = Cart::where('user_id', $user_id)->with('product')->orderBy('id', 'asc')->get();
        return response()->json(['success' => 'Cart was successfully updated.', 'data' => $data]);

    }

    public function deleteMyCart(Request $request) {
       

        $user_id = $request->id;
        $color_id=$request->color_id;
        if ($user_id) {
            $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id', $request->color_id)->first();
            $cart->delete();
        } 

        return response()->json(['success' => 'Product was successfully removed.']);
    }

    public function myCouponApply(Request $request) {

        $coupon = Coupon::where('name', $request->coupon)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first();

        if (!$coupon) {
            return response()->json(['error' => 'There was no coupon found.']);
        }
        $total=[0];
        $user_id = $request->id;
        $user =User::where('id',$request->id)->first();
        $general = GeneralSetting::first();

        if ($user_id) {
            $carts = Cart::where('user_id', $user_id)->with('product')->get();
            $ttax=0;
            foreach ($carts as $cart) {
                $sumPrice = 0;
                $product  = Product::where('status',1)->where('id', $cart->product_id)->first();
                //dd($product);
                $price = productPrice($product,$user);
               
                $sumPrice = $sumPrice + ($price * $cart->quantity );
                $total[]  = $sumPrice;
                $ttax = producttax($product);
                $tax[] = ($sumPrice * $ttax) /100;
            }

        } 

        $subtotal = array_sum($total);
        $subtotaltax = array_sum($tax);

        if ($coupon->min_order > $subtotal) {
            return response()->json(['error' => 'Sorry, you have to order a minimum amount of ' . $general->cur_sym . showAmount($coupon->min_order)]);
        }

        if ($coupon->discount_type == 1) {
            $discount = $coupon->discount;
            $taxdiscount=  $coupon->discount;
        } else {
            $discount = $subtotal * $coupon->discount / 100;
             $taxdiscount = $subtotaltax * $coupon->discount / 100;
        }
        $ttax=$subtotaltax - $taxdiscount;
        $totalAmount = $subtotal + $ttax - $discount;

        $total = [
            'coupon_name'   => $coupon->name,
            'coupon_id'     => $coupon->id,
            'discount_type' => $coupon->discount_type,
            'subtotal'      => $subtotal,
            'totaltax'      => $ttax,
            'discount'      => $discount,
            'totalAmount'   => $totalAmount,
        ];
       
        return response()->json([
            'success'     => 'Coupon has been successfully added.',
            'subtotal'    => $subtotal,
            'discount'    => $discount,
            'totaltax'    => $ttax,
            'totalAmount' => $totalAmount,
            'total'        => $total,
           ]);
    }

//Cash On Delivery payment start from Mobile app
    public function appOrder(Request $request) {

        

       
        $user =User::where('id',$request->id)->first();
        $subtotal   = $this->cartSubTotal($user->id );
        $shipping   = ShippingMethod::where('id', $request->shipping_method)->where('status', 1)->first();
        if(!$shipping){
             return response()->json([
            'shipping method'     => 'Please check shipping method.',
        
           ]);
        }
        $grandTotal = $subtotal + $shipping->price;

        $total = $request->total;

        if ($total) {
            $discount   = $request->discount;
            $coupon_id  = $request->coupon_id;
            $totaltax   = $request->totaltax;
            $grandTotal = $grandTotal + $totaltax - $discount;
        }

        $address = [
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'country' => $request->country,
            'city'    => $request->city,
        ];
        $trxno=getTrx();
        $order                  = new Order();
        $order->user_id         = $user->id ;
        $order->order_no        = $trxno;
        $order->subtotal        = $subtotal;
        $order->discount        = $discount ?? 0;
        $order->shipping_charge = $shipping->price;
        $order->tax             = $totaltax;
        $order->total           = $grandTotal;
        $order->coupon_id       = $coupon_id ?? 0;
        $order->shipping_id     = $shipping->id;
        $order->address         = json_encode($address);
        $order->payment_type    = $request->payment_type;
        $order->source          = 'Mobile';

        if ($request->payment_type == 1) {
            $order->save();
            session()->put('order_id', $order->id);
              return redirect()->route('appdeposit');
        }

        $order->order_status = 0;
        $order->save();

        $carts = Cart::where('user_id', $user->id)->with('productGallery')->get();
        $general = GeneralSetting::first();
        foreach ($carts as $cart) {
                
            if($cart->productGallery->qty==0){
                continue;
            }
            
            $product = Product::findOrFail($cart->product_id);
           // dd($product);
            $price = productPrice($product,$user);

            $orderDetail             = new OrderDetail();
            $orderDetail->order_id   = $order->id;
            $orderDetail->product_id = $cart->product_id;
            $orderDetail->quantity   = $cart->quantity;
            $orderDetail->price      = $price;
            $orderDetail->color      = $cart->color;
            $orderDetail->color_id   = $cart->color_id;
            $orderDetail->save();

           // $product->decrement('quantity', $cart->quantity);
            //$product->save();
            $product->decrementInventory($cart->quantity,$cart->color_id);
            $cart->delete();

        }

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id ;
        $adminNotification->title     = 'Order successfully done via Cash on delivery.';
        $adminNotification->click_url = urlPath('admin.orders.detail',$order->id);
        $adminNotification->save();

       $mobile = $user->mobile; 
        $order_number = $trxno;
        $status = 'Processing';

       sendOrder($mobile,$order_number,$status);

       
        return response()->json([
            'method_name'     => 'Order successfully done via Cash on delivery.',
            'user_name'       => $user->username,
            'subtotal'        => showAmount($subtotal),
            'shipping_charge' => showAmount($shipping->price),
            'total'           => showAmount($grandTotal),
            'currency'        => $general->cur_text,
            'order_no'        => $order->order_no,
           ]);
    }



//Online payment gateway start from Mobile app

     public function appDeposit(Request $request) {



          $user =User::where('id',$request->id)->first();
        $subtotal   = $this->cartSubTotal($user->id );
        $shipping   = ShippingMethod::where('id', $request->shipping_method)->where('status', 1)->first();
        if(!$shipping){
             return response()->json([
            'shipping method'     => 'Please check shipping method.',
        
           ]);
        }
        $grandTotal = $subtotal + $shipping->price;

        $total = $request->total;

        if ($total) {
            $discount   = $request->discount;
            $coupon_id  = $request->coupon_id;
            $totaltax   = $request->totaltax;
            $grandTotal = $grandTotal + $totaltax - $discount;
        }

        $address = [
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'country' => $request->country,
            'city'    => $request->city,
        ];

        $order                  = new Order();
        $order->user_id         = $user->id ;
        $order->order_no        = getTrx();
        $order->subtotal        = $subtotal;
        $order->discount        = $discount ?? 0;
        $order->shipping_charge = $shipping->price;
        $order->tax             = $totaltax;
        $order->total           = $grandTotal;
        $order->coupon_id       = $coupon_id ?? 0;
        $order->shipping_id     = $shipping->id;
        $order->address         = json_encode($address);
        $order->payment_type    = $request->payment_type;

        $order->save();
        session()->put('order_id', $order->id);
    $_SESSION["order_id"]=$order->id;
        $order_id        = $order->id;
        $order           = Order::where('id', $order_id)->where('order_status', 0)->first();
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view($this->activeTemplate . 'user.payment.appdeposit', compact('gatewayCurrency', 'pageTitle', 'order'));
      
    }

     protected function cartSubTotal($user_id) {
        $user =User::where('id',$user_id)->first();
        $carts = Cart::where('user_id', $user_id)->with('productGallery')->get();
    
        $total = [0];
    
        foreach ($carts as $cart) {
            $sumPrice = 0;
            if($cart->productGallery->qty==0){
                continue;
            }
            $product  = Product::where('id', $cart->product->id)->first();
            $price = productPrice($product,$user);

            $sumPrice = $sumPrice + ($price * $cart->quantity);
            $total[]  = $sumPrice;
        }
    
        $subtotal = array_sum($total);
        return $subtotal; 
    }


    public function appDepositInsert(Request $request) {
     
        $order_id = $_SESSION["order_id"];
        $order    = Order::where('id', $order_id)->where('order_status', 0)->first();

        ///change user defalut user id here *****************
        $user     = User::where('id',1)->first();
        $gate     = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();

        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $order->total || $gate->max_amount < $order->total) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge    = $gate->fixed_charge + ($order->total * $gate->percent_charge / 100);
        $payable   = $order->total + $charge;
        $final_amo = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->order_id        = $order_id;
        $data->user_id         = $user->id;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->charge          = $charge;
        $data->amount          = $order->total;
        $data->rate            = $gate->rate;
        $data->final_amo       = $final_amo;
        $data->btc_amo         = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->try             = 0;
        $data->status          = 0;
        $data->save();
         session()->put('Track', $data->trx);
        $_SESSION["Track"]=$data->trx;
        return redirect()->route('api.deposit.preview');
    }

  public function appDepositPreview() {

        $track     =  $_SESSION["Track"]; 
        $data      = Deposit::where('trx', $track)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $pageTitle = 'Payment Preview';
       // dd($pageTitle);
   return view($this->activeTemplate . 'user.payment.apppreview', compact('data', 'pageTitle'));
  }

   public function appDepositConfirm() {
        $track   = $_SESSION["Track"]; 
        $deposit = Deposit::where('trx', $track )->where('status', 0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

       
        $dirName = $deposit->gateway->alias;
       
    if($dirName=='ccavenue'){
        $orderid=$deposit->trx;
        return view(activeTemplate() . 'user.payment.appccavenue', compact('deposit','orderid'));

    }
        
    
    }

       public function getNotification(Request $request) {
      
      
  
        $date = \Carbon\Carbon::today()->subDays(7);
        $n=\Carbon\Carbon::now();
        User::where('id',$request->userid)->update(['notification' => $n]);
        $data = Notification::where('created_at', '>=',$date)->orderBy('id', 'asc')->get();
        return response()->json(['success' => 'Notification Data.', 'data' => $data]);   
    
    }

    public function getNotificationCount(Request $request) {
      
        $date = User::where('id',$request->userid)->first();
         
        $data = Notification::where('created_at', '>=',$date->notification)->orderBy('id', 'asc')->get();
        $count=$data->count();
        //return response()->json(['success' => 'Notification Data Count. ', 'data' => $count]);   
 return response()->json(['success' => 'Notification Data Count. ', 'data' => '0']);   
    
    }
     
    public function deleteProfile(Request $request) {
      
        User::where('id',$request->userid)->update(['status' => '0']);
       
       
      
        return response()->json(['success' => 'You have Deleted your profile. ']);   
    
    }

    public function sendOTPPassword(Request $request){

           $mobile = $request->mobile; 
            $otp = rand(1000, 9999);

            $currentDateTime = Carbon::now(); 
            $otp_expiry = $currentDateTime->addMinutes(10);
            
            $msg = "Your OTP for mobile verification is '.$otp.' Do not share with anyone. ARSH OPTICAL";
            
            sendMessage($mobile,$msg);

          

            $user = User::where('mobile', $request->mobile)->first();
        
            PasswordReset::where('mobile', $user->mobile)->delete();
            
            $password = new PasswordReset();
            $password->mobile = $user->mobile;
            $password->email = $user->email;
            $password->token = $otp;
            $password->created_at = \Carbon\Carbon::now();
            $password->save();
            return response()->json(['success' => 'OTP sent successfully. ', 'data' => $otp]);   
            
    }

     public function resetNewPassword(Request $request){

           $mobile = $request->mobile; 
            $user = User::where('mobile', $mobile)->first();
            $user->password = bcrypt($request->newpass);
            $user->save();
            return response()->json(['success' => 'Password changed successfully. ', 'data' => $request->newpass]);   
            
    }
}