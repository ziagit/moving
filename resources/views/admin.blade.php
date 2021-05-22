<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <title>TingsApp</title>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://js.stripe.com/v3/"></script>
  <!-- Fonts -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">

  <link href="{{ asset('fonts/maison-neue/stylesheet.css') }}" rel="stylesheet" type="text/css" />
  <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAQTHaD2g0BjmczBlX73Vv-KthtHzdRYPk"></script>
  
  <!-- pusher -->
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <style>
    html,
    body {
      height: 100% !important;
      min-height: 100% !important;
    }

    #app {
      height: 100% !important;
      min-height: 100% !important;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 0px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .m-bottom-2 .align-center .justify-center {
      display: none !important;
    }
  </style>

</head>

<body onbeforeunload="return myFunction()">
  <div id="app">
    <admin></admin>
  </div>
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Start of HubSpot Embed Code -->
  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/19603118.js"></script>
  <!-- End of HubSpot Embed Code -->
 
</body>

</html>