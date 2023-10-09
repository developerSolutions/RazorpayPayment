<!DOCTYPE html>
<html>

<head>
    <title> Razorpay Payment Gateway Integration Example </title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>

    <div class="container">

        <h1> Razorpay Payment Gateway Integration Example</h1>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table">
                        <h3 class="panel-title">Razorpay Payment </h3>
                    </div>
                    <div class="panel-body">

                        @if(Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif


                        <form class="contribution-form" id="contribution-form" method="POST"
                            enctype="multipart/form-data">
                               @csrf
                               <input type="text" name="amount" class="form-control" placeholder="amount in rupee"/>

                           <button  class="btn btn-outline-dark btn-lg"><i class="fas fa-money-bill"></i> Own Checkout</button>
                        </form>
                        {{-- <button id="rzp-button1" class="btn btn-outline-dark btn-lg"><i class="fas fa-money-bill"></i> Own Checkout</button> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <form class="contribution-form" name="contribution_form" method="POST"
                            enctype="multipart/form-data" action="{{route('payment')}}">
                               @csrf 
      <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id"/>
      <input type="hidden" name="razorpay_signature" id="razorpay_signature"/>
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
  {{-- using cdn here --}}
      <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
      <script>
        // var options = {
        //   "key": "{{env('rzr_key')}}", // Enter the Key ID generated from the Dashboard
        //   "amount": "1000",
        //   "currency": "INR",
        //   "description": "Acme Corp",
        //   "image": "{{asset('logo.png')}}",
        //   "prefill":
        //   {
        //     "email": "gaurav.kumar@example.com",
        //     "contact": +919900000000,
        //   },
        //   config: {
        //       display: {
        //         blocks: {
        //           banks: {
        //             name: 'Most Used Methods',
        //             instruments: [
        //               {
        //                 method: 'wallet',
        //                 wallets: ['freecharge']
        //               },
        //               {
        //                   method: 'upi'
        //               },
        //               ],
        //           },
        //         },
        //         sequence: ['block.banks'],
        //         preferences: {
        //           show_default_blocks: true,
        //         },
        //       },
        //     },
           
        
        //   "modal": {
        //     "ondismiss": function () {
        //       if (confirm("Are you sure, you want to close the form?")) {
        //         txt = "You pressed OK!";
        //         console.log("Checkout form closed by the user");
        //       } else {
        //         txt = "You pressed Cancel!";
        //         console.log("Complete the Payment")
        //       }
        //     }
        //   }
        // };
        // var rzp1 = new Razorpay(options);

        $(document).ready(function(){
         
         $('#contribution-form').submit(function(e){
          e.preventDefault();
          var form = $('#contribution-form')[0];
          var data = new FormData(form);
          var URL = "{{route('create')}}";
          $.ajax({
          url:URL,
          data:data,
          type:"POST",
          cache:false,
          processData:false,
          contentType:false,
          success:function(dta)
          {
            if(dta.status === true)
            {
              //here we are passing options data from backend 
              proceedPayment(dta.checkoutData);
              
            }
          },
          error:function(dta){
            //show error message
         console.log(dta.responseJSON.message);
          }
          });
         })
       
        });
        //this function calls when form submited and order id created successfully
        var proceedPayment = function(dta){
          var options = dta;
          options.handler = function(response)
        {
          document.getElementById('razorpay_payment_id').value =response.razorpay_payment_id;
          document.getElementById('razorpay_signature').value =response.razorpay_signature;
          document.contribution_form.submit();
          //if order id created successfully then open razorpay 
       
        }
        Razorpay.open(options);
        }
     
        // document.getElementById('rzp-button1').onclick = function (e) {
        //   Razorpay.open(options);  //click payment button open payment  from here
        //   e.preventDefault();
        // }
      </script>

</body>

</html>