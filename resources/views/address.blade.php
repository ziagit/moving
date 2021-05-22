<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Shipbay</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">
    <style>
        html,
        body {
            height: 100%;
            min-height: 100%;
        }

        #app {
            height: 100%;
            min-height: 100%;
        }
        .search{
            margin-top: 100px;
            margin-left: 200px;
        }
    </style>
</head>

<body>
    <link rel="stylesheet" type="text/css" href="http://ws1.postescanada-canadapost.ca/css/addresscomplete-2.30.min.css?key=yc97-ja41-mj26-nu81" />
    <script type="text/javascript" src="http://ws1.postescanada-canadapost.ca/js/addresscomplete-2.30.min.js?key=yc97-ja41-mj26-nu81"></script>
    <div id="app">
        <form action="/" method="post">
            <input type="text" name="address" placeholder="Address" class="search">
            <input type="hidden" name="city" placeholder="City">
            <input type="hidden" name="state" placeholder="State">
            <input type="hidden" name="postalcode" placeholder="Postal code">
            <input type="hidden" name="country" placeholder="Country">
            <input type="submit" value="Sumbit">
        </form>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>

</body>

</html>