<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>TingsApp</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">
   <style>                                                                    
        html,
        body {
            height: 100% !important;
            min-height: 100% !important;
            padding: 30px;
            background-color: #f0f2f5;
        }
        .container{
            font-family: 'Roboto';
            padding: 30px;
            margin: auto;
            max-width: 600px;
            box-shadow: 0 1px 2px #11111142;
            border-radius: 8px !important;
            background-color: #fff;
        }
        .heading{
            text-align: center;
        }
        .reset-button{
            padding: 14px 33px;
            border: 0;
            border-radius: 30px;
            background: #f97d4a;
            color: #fff;
            min-width: 174px;
            text-decoration: none;
            font-size: 14px;
        }
        .action{
            text-align: center;
        }
        .line{
            border-top: 1px solid #ddd;
        }
        .grading{
            font-size: 11px;
        }
        .email{
            font-size: 11px;
            color: #f97d4a;
        }
      
    </style>
</head>

<body>
    <div class="container">
       <div class="heading">
            <h1>TingsApp</h1>
       </div>
       <div class="content">
           <p>Dear customer !</p>
           <p>Your payment is proceed successfully to TingsApp!  </p>
           <p>Amount: {{$amount}}</p>
           <p>Do you want to see your order?  </p>
       </div><br><br>
        <div class="action">
            <a class="btn btn-primary" href="http://localhost:8000/carrier/history/details/{{$order}}">My Dashboard (local)</a>
           <a class="btn btn-primary" href="https://tingsapp.com/carrier/history/details/{{$order}}">My Dashboard</a>
        </div>

        <br><br>
        <p>.</p>
        <div class="line"></div>
        <span class="grading">Yours, TingsApp Team</span><br>
        <span class="email">support@tingsapp.com</span>
    </div>


</body>

</html>