<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;


class PaymentController extends Controller
{
    public function index()
    {
        return view('stripe-payment');
    }

    public function makePayment(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Make payment and chill."
        ]);

        Session::flash('success', 'Payment successfully made.');

        return redirect('home');
    }
}
