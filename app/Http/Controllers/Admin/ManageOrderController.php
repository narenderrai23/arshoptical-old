<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\Transaction;
use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class ManageOrderController extends Controller {

    public function allOrder(Request $request) {
        $pageTitle    = 'All Orders';
        $emptyMessage = 'No order found';

        $orders = Order::query();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function($q) use($search){
                    $q->where('order_no',$search)->orWhereHas('user',function($query) use ($search){
                        $query->where('username',$search);
                    });
            });
        }

        $orders = $orders->with('user')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));

    }

    public function pendingOrder(Request $request) {
        $pageTitle    = 'Pending Orders';
        $emptyMessage = 'No order found';

        $orders = Order::pending();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function($q) use($search){
                    $q->where('order_no',$search)->orWhereHas('user',function($query) use ($search){
                        $query->where('username',$search);
                    });
            });
        }

        $orders = $orders->with('user')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));

    }

    public function confirmOrder(Request $request) {
        $pageTitle    = 'Confirmed Orders';
        $emptyMessage = 'No order found';

        $orders = Order::confirmed();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function($q) use($search){
                    $q->where('order_no',$search)->orWhereHas('user',function($query) use ($search){
                        $query->where('username',$search);
                    });
            });
        }

        $orders = $orders->with('user')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));

    }

    public function shippedOrder(Request $request) {
        $pageTitle    = 'Shipped Orders';
        $emptyMessage = 'No order found';

        $orders = Order::shipped();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function($q) use($search){
                    $q->where('order_no',$search)->orWhereHas('user',function($query) use ($search){
                        $query->where('username',$search);
                    });
            });
        }

        $orders = $orders->with('user')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));

    }

    public function deliveredOrder(Request $request) {
        $pageTitle    = 'Delivered Orders';
        $emptyMessage = 'No order found';

        $orders = Order::delivered();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function($q) use($search){
                    $q->where('order_no',$search)->orWhereHas('user',function($query) use ($search){
                        $query->where('username',$search);
                    });
            });
        }

        $orders = $orders->with('user')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));

    }

    public function cancelOrder(Request $request) {
        $pageTitle    = 'Cancel Orders';
        $emptyMessage = 'No order found';

        $orders = Order::cancel();

        if ($request->search) {
            $search = request()->search;
            $orders = $orders->where(function($q) use($search){
                    $q->where('order_no',$search)->orWhereHas('user',function($query) use ($search){
                        $query->where('username',$search);
                    });
            });
        }

        $orders = $orders->with('user')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));

    }

    public function userOrders(Request $request,$id){

        $user = User::findOrFail($id);

        $pageTitle    = 'Order Logs of'.' '.$user->username;
        $emptyMessage = 'No order found';

        $orders = Order::where('user_id',$user->id);

        if ($request->search) {
            $orders->where('order_no', $request->search);
        }

        $orders = $orders->with('user')->latest()->paginate(getPaginate());
        return view('admin.order.index', compact('pageTitle', 'emptyMessage', 'orders'));
    }

    public function userTransactions(Request $request , $id){
        $user = User::findOrFail($id);
        $pageTitle = 'Transaction Logs of'.' '.$user->username;
        $transactions = Transaction::where('user_id',$user->id)->with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage')); 
    }



    public function orderDetail($id) {
        $pageTitle    = 'Order Detail';
        $emptyMessage = 'No product found';
        $countries      = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $order        = Order::where('id', $id)->with(['orderDetail.product', 'coupon', 'shipping', 'deposit', 'user'])->firstOrFail();
        return view('admin.order.detail', compact('pageTitle', 'order', 'emptyMessage','countries'));
    }
    public function orderDetailUpdate(Request $request) {
            try {

       $orderArray = json_encode(["address" => $request->address,
                    "state" => $request->state,
                    "zip" => $request->address,
                    "country" => $request->country,
                    "city" => $request->city,
                    ]);

                    Order::find($request->orderId)->update(['address'=>$orderArray]);
                    $order = Order::find($request->orderId);
                    if(!empty($request->dataqty)){ 
                    foreach($request->dataqty as $val){
                        OrderDetail::find($val['id'])->update(['quantity'=>$val['qty']]);
                    }
                }
                $sumPrice = OrderDetail::where('order_id', $request->orderId)
                ->get()
                ->sum(function ($orderDetail) {
                    return $orderDetail->price * $orderDetail->quantity;
                });
                
                    $gstAmount = ($sumPrice * 12) / 100;
                    $total = $sumPrice + $gstAmount+ $order->shipping_charge+$order->shipping_charge-$order->discount;
                    Order::where('id', $request->orderId)->update(['subtotal'=>$sumPrice,'tax'=>$gstAmount,'total'=>$total]);
                    return response()->json(['success' => 'Order Details Updated successfully..']);
                 
                    } catch (\Throwable $th) {
                        return response()->json(['success' => 'Something Want Wrong.']);
                    }      
 
    }

    
    public function orderDetailDelete($id){

        $orderdetails = OrderDetail::find($id);
        OrderDetail::find($id)->delete();
        $order = Order::find($orderdetails->order_id);
        $sumPrice = OrderDetail::where('order_id', $orderdetails->order_id)
        ->get()
        ->sum(function ($orderDetail) {
            return $orderDetail->price * $orderDetail->quantity;
        });
        $gstAmount = ($sumPrice * 12) / 100;
        $total = $sumPrice + $gstAmount+ $order->shipping_charge+$order->shipping_charge-$order->discount;
        Order::where('id', $order->id)->update(['subtotal'=>$sumPrice,'tax'=>$gstAmount,'total'=>$total]);
        
        return redirect()->back()->with('success', 'Order detail deleted successfully.');
    }

    public function orderStatus(Request $request, $id) {
        $request->validate([
            'order_status' => 'required|integer',
        ]);

        $order = Order::where('id', $id)->with('user', 'orderDetail')->firstOrFail();
        $order->order_status = $request->order_status;

        if ($request->order_status == 1) {
            $status = 'Confirmed';
        } elseif ($request->order_status == 2) {
            $status = 'Shipped';
        } elseif ($request->order_status == 3) {
            $status = 'Delivered';

            foreach ($order->orderDetail as $detail) {
                $product = ProductGallery::findOrFail($detail->color_id);
                $product->increment('qty', $detail->quantity);
                $product->save();
            }

            if ($order->payment_type == 2) {
                $order->payment_status = 1;
            }

        } else {
            $status = 'Cancelled';

            if ($order->payment_status == 0) {
                $order->payment_status = 9;
            }

            foreach ($order->orderDetail as $detail) {
               $product = ProductGallery::findOrFail($detail->color_id);
                $product->increment('qty', $detail->quantity);
                $product->save();
            }
        }
        
        $order->save();

        $user    = $order->user;
        $general = GeneralSetting::first();

        $mobile = $user->mobile; 
        $order_number = $order->order_no;
        $status = $status;

        //$msg = "Your Order No ".$order_number." has been  ".$status." ARSH OPTICAL";
       sendOrder($mobile,$order_number,$status);
       // sendMessage($mobile,$msg);

        notify($user, 'ORDER_STATUS', [
            'method_name' => 'Your order has now ' . $status,
            'user_name'   => $user->username,
            'order_no'    => $order->order_no,
            'total'       => showAmount($order->total),
            'currency'    => $general->cur_text,
        ]);

        $notify[] = ['success', 'Order status change successfully.'];
        return back()->withNotify($notify);
    }

    public function invoice($id) {
        $pageTitle    = 'Print Invoice';
        $emptyMessage = 'No order found';
        $order        = Order::where('id', $id)->with(['orderDetail.product', 'coupon', 'shipping', 'deposit', 'user'])->firstOrFail();
        return view('admin.order.invoice', compact('order', 'pageTitle', 'emptyMessage'));
    }

}