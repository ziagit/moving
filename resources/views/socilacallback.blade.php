<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Social Login</title>

    <meta charset="utf-8">
    <!-- Fonts -->
    <style>

    </style>
</head>

<body>
    <div>
        <input type="hidden" value="{{$token}}" id="token">
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        location.href = "/callback/"+document.getElementById('token').value
    </script>
</body>

</html>