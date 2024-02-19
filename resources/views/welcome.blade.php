<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{ Vite::asset('resources/assets/style.css')}}">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased">
      <div class="home_container">
            <div class='selectRole'>
                <h2>Please Select Your Role:</h2>
                <ul>
                    <li><h3><a href="{{route('admin_login.get')}}">Admin</a></h3></li>
                    <li><h3><a href="{{route('user_login.get')}}" >User</a></h3></li>
                </ul>
            </div>
      </div>

    </body>
</html>
