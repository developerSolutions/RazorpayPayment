<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class paymentController extends Controller
{

    public function create(Request $request)
    {
       // this function creates order id send options data in response
       if(!empty($request->amount)){
        $api = new Api(env('rzr_key'),env('rzr_secret'));
        $razorpay = $api->order->create(['amount'=>$request->amount * 100 ,'currency'=>"INR"]);
        $options =
        [
            "name"=> "Developer Solutions", //your business name
            "description"=> "Test Transaction",
            "image"=> "logo.png",
            "order_id"=> $razorpay->id, //This is a sample Order ID. Pass 
            "prefill"=> [ 
                "name"=> "Test", //your customer's name
                "email"=> "Test@example.com",
                "contact"=> "9000090000" //Provide the customer's phone number for better conversion rates 
            ],
            "notes"=> [
                "address"=> "Razorpay Corporate Office"
            ],
            "theme"=> [
                "color"=> "#3399cc"
            ]

        ];
        //we need to fetch
        return response()->json(['checkoutData'=>$options,'status'=>true]);
       }
       return response()->json(['checkoutData'=>'','status'=>false]);

    }
    public function payment(Request $request)
    {
        $api = new Api(env('rzr_key'),env('rzr_secret'));
        $paymentInfo = $api->payment->fetch($request->razorpay_payment_id);
       // we get payment info
        dd($request->all(),$paymentInfo);
        //when payment successfull then this function call to show success message
    //    if(!empty($request->razorpay_payment_id)){
    //     $api = new Api(env('rzr_key'),env('rzr_secret'));
    //     try{
    //     $payment = $api->payment->fetch($request->razorpay_payment_id);
    //     $response = $payment->capture(['amount'=> $payment['amount']]);
    //     dd($response);
    //     }
    //     catch(\Exception $ex)
    //     {
    //         return $ex->getMessage();
    //     }
    //    }
    }
}
