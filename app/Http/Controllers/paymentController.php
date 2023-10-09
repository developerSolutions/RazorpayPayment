<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class paymentController extends Controller
{

    public function payment(Request $request)
    {
       if(!empty($request->razorpay_payment_id)){
        $api = new Api(env('rzr_key'),env('rzr_secret'));
        try{
        $payment = $api->payment->fetch($request->razorpay_payment_id);
        $response = $payment->capture(['amount'=> $payment['amount']]);
        dd($response);
        }
        catch(\Exception $ex)
        {
            return $ex->getMessage();
        }
       }
    }
}
