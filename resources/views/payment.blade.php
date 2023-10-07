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
                            enctype="multipart/form-data" action="{{route('payment')}}">
                               @csrf
                            <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{env('rzr_key')}}" data-amount="1000"
                                data-buttontext="Pay 10 INR" data-name="online web tutorials" data-description="Razorpay Payment Example"
                                data-image="{{asset('logo.png')}}"
                                data-prefill.name="name" data-prefill.email="email" data-theme.color="#ff7529">

                            </script>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


</body>

</html>
