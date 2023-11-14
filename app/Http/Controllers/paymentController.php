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
        $planName = 'Monthly donation for kheti';
        $amount = $request->amount * 100;
        ;

        if($request->period =='daily')
        {
           $interval = 7; 
        }
        else if($request->period =='weekly')
        {
           $interval = 5; 
        }
        else if($request->period =='monthly')
        {
           $interval = 1; 
        }
        else if($request->period =='yearly')
        {
           $interval = 1; 
        }
        $createRzpPlan = $api->plan->create(array('period' => $request->period, 'interval' => $interval, 'item' => array('name' => $planName, 'description' => '', 'amount' => $amount, 'currency' => 'INR'), 'notes' => array('key1' => 'value3', 'key2' => 'value2')));
        //get plan id
          $planID = $createRzpPlan->id; 
        
           // subscription count in months
           $subs_time = $request->total_count;
           // subscription date expired 
           $expired_date = \Carbon\Carbon::now();
           // date to unix date 
           $expired_unix= strtotime("+".$subs_time,strtotime($expired_date));
           /*Create the subscription*/
           $createRzpsubscription = $api->subscription->create(array('plan_id' => $planID, 'customer_notify' => 1, 'quantity' => 1, 'total_count' => $subs_time,
            'notes' => array('key1' => 'value3', 'key2' => 'value2'),'notify_info'=>array('notify_phone' => '+918867898919','notify_email'=> 'developersolutions2023@gmail.com')));

          //  return response()->json(['id'=> $createRzpsubscription->id,'url'=>$createRzpsubscription->short_url,'status'=>true]);
        $options =
        [
            "key"=> env('rzr_key'),
            "name"=> "Developer Solutions", //your business name
            "description"=> "Test Transaction",
            "image"=> "logo.png",
            "subscription_id" => $createRzpsubscription->id, //This is a sample Order ID. Pass 
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
        //dd($request->all());
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
