<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RazorpayPaymentController extends Controller
{
    public function index(Request $request)
    {

        $uid = Auth::id();
        $cartdata = Cart::where('userid',$uid)->get();

        foreach($cartdata as $cart)
        {
            $order = new Order;
            $order->productid=$cart['productid'];
            $order->userid=$cart['userid'];
            $order->status='paid';
            $order->payment='online';
            $order->amount=$request->amount;
            $order->save();
        }
        Cart::where('userid',$uid)->delete();
        $amount = $request->amount;
        return view('razorpayView',['amount'=>$amount]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }

        Session::put('success', 'Payment successful');
        return redirect()->back();
    }
}
