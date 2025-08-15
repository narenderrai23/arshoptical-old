<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $activeTemplate;
    
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|gt:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $product = Product::findOrFail($request->product_id);
        $productgallery = ProductGallery::where('id', $request->color_id)->first();
        $color = $request->color;
        $color_id = $request->color_id;
        $user_id = auth()->user()->id ?? null;
        $cart_id = $product->id . $color_id;

        if ($request->quantity > $productgallery->qty) {
            return response()->json(['error' => 'Requested quantity is not available in our stock.']);
        }

        if ($user_id) {
            $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id', $color_id)->first();

            if ($cart) {
                if ($cart->quantity + $request->quantity >= $productgallery->qty) {
                    return response()->json(['error' => 'Requested quantity is not available in our stock.']);
                }

                $cart->quantity += $request->quantity;
                $cart->save();
            } else {
                $cart = new Cart();
                $cart->user_id = auth()->user()->id;
                $cart->product_id = $request->product_id;
                $cart->color = $request->color;
                $cart->color_id = $request->color_id;
                $cart->quantity = $request->quantity;
                $cart->save();
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$cart_id])) {
                if ($cart[$cart_id]['quantity'] >= $product->quantity) {
                    return response()->json(['error' => 'Requested quantity is not available in our stock.']);
                }

                $cart[$cart_id]['quantity'] += $request->quantity;
            } else {
                $general = GeneralSetting::first();
                $cart[$cart_id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'discount' => $product->today_deals == 1 ? $general->discount : $product->discount,
                    'discount_type' => $product->today_deals == 1 ? $general->discount_type : $product->discount_type,
                    'image' => $product->image,
                    'product_id' => $product->id,
                    'color' => $request->color,
                    'color_id' => $request->color_id,
                    'quantity' => $request->quantity,
                ];
            }
        }

        session()->put('cart', $cart);
        return response()->json(['success' => 'Product added to shopping cart']);
    }

    public function updateCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|gt:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        //$color=$request->color;
        $color_id = $request->color_id;

        $product = Product::findOrFail($request->product_id);
        $productgallery = ProductGallery::where('id', $request->color_id)->first();
        $user_id = auth()->user()->id ?? null;
        $cart_id = $product->id . $color_id;
        if ($request->quantity > $productgallery->qty) {
            $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id', $request->color_id)->first();

            return response()->json(['error' => 'Requested quantity is not available in our stock.', 'qty' => $cart->quantity, 'maxQty' => $productgallery->qty]);
        }

        if ($user_id != null) {
            $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id', $request->color_id)->first();

            $cart->quantity = $request->quantity;
            $cart->save();
        } else {
            $cart = session()->get('cart');
            $cart[$cart_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json(['success' => 'Cart was successfully updated.']);
    }

    public function deleteCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $user_id = auth()->user()->id ?? null;
        $color_id = $request->color_id;
        if ($user_id) {
            $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->where('color_id', $request->color_id)->first();
            $cart->delete();
        } else {
            $cart = session()->get('cart');

            // uset with two values hare
            unset($cart[$request->product_id . $color_id]);
            session()->put('cart', $cart);
        }

        return response()->json(['success' => 'Product was successfully removed.']);
    }

    public function getCartCount()
    {
        $user_id = auth()->user()->id ?? null;

        if ($user_id) {
            return Cart::where('user_id', $user_id)->count();
        }

        $cart = session()->get('cart');
        if ($cart) {
            return count($cart);
        }
        return 0;
    }

    public function cartProducts()
    {
        if (!auth()->user()) {
            return redirect()->route('user.login');
        }
        $pageTitle = 'My Cart';
        $emptyMessage = 'There is no product in the cart.';
        $user_id = auth()->user()->id ?? null;
        $carts = [];

        $cart = session()->get('cart');
        $carts = json_decode(json_encode($cart)) ?? [];

        if ($user_id) {
            $carts = Cart::where('user_id', $user_id)->with('product','productGallery')->orderBy('id', 'asc')->get();
        }

        session()->forget('total');
        return view($this->activeTemplate . 'cart', compact('pageTitle', 'emptyMessage', 'carts'));
    }

    public function couponApply(Request $request)
    {
        $coupon = Coupon::where('name', $request->coupon)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first();

        if (!$coupon) {
            return response()->json(['error' => 'There was no coupon found.']);
        }

        $user_id = auth()->user()->id ?? null;
        $general = GeneralSetting::first();

        if ($user_id) {
            $carts = Cart::where('user_id', $user_id)->with('product')->get();
            $ttax = 0;
            foreach ($carts as $cart) {
                $sumPrice = 0;
                $product = Product::active()->where('id', $cart->product->id)->first();
                $price = productPrice($product);

                $sumPrice = $sumPrice + $price * $cart->quantity;
                $total[] = $sumPrice;
                $ttax = producttax($product);
                $tax[] = ($sumPrice * $ttax) / 100;
            }
        } else {
            $carts = session()->get('cart');
            foreach ($carts as $cart) {
                $sumPrice = 0;
                $product = Product::active()->where('id', $cart['product_id'])->first();
                $price = productPrice($product);
                $ttax = producttax($product);
                $sumPrice = $sumPrice + $price * $cart['quantity'];
                $total[] = $sumPrice;
                $tax[] = ($sumPrice * $ttax) / 100;
            }
        }

        $subtotal = array_sum($total);
        $subtotaltax = array_sum($tax);

        if ($coupon->min_order > $subtotal) {
            return response()->json(['error' => 'Sorry, you have to order a minimum amount of ' . $general->cur_sym . showAmount($coupon->min_order)]);
        }

        if ($coupon->discount_type == 1) {
            $discount = $coupon->discount;
            $taxdiscount = $coupon->discount;
        } else {
            $discount = ($subtotal * $coupon->discount) / 100;
            $taxdiscount = ($subtotaltax * $coupon->discount) / 100;
        }
        $ttax = $subtotaltax - $taxdiscount;
        $totalAmount = $subtotal + $ttax - $discount;

        $total = [
            'coupon_name' => $coupon->name,
            'coupon_id' => $coupon->id,
            'discount_type' => $coupon->discount_type,
            'subtotal' => $subtotal,
            'totaltax' => $ttax,
            'discount' => $discount,
            'totalAmount' => $totalAmount,
        ];
        session()->put('total', $total);
        session()->put('ttax', $ttax);
        return response()->json([
            'success' => 'Coupon has been successfully added.',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'totaltax' => $ttax,
            'totalAmount' => $totalAmount,
        ]);
    }
}