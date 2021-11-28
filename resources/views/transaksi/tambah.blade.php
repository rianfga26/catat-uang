<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @yield('css')
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
        .backgroundf7{
            background: #f7f7f7;
        }
        img[alt="www.000webhost.com"]
        {
            display:none;
            
        }
    </style>
</head>
<body>
    <div class="app">
        <div class="container" style="background: lightgray;">
            <div class="row align-items-center bg-danger">
                <a href="{{ route('home') }}" class="mx-1 mt-1">
                    <img src="{{ asset('images/icons8-back-52.png') }}" alt="" width="16px">
                </a>
                <h5 class="text-white pt-3 display-5">@yield('judul')</h5>
                @yield('icon')
            </div>
            <div class="row bg-white justify-content-center mt-1">
                <div class="col-xs-8 mb-5">
                    <div class="d-flex align-items-center mt-3 w-50">
                        @yield('link')
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
</body>
<script src="https://unpkg.com/autonumeric"></script>
<script>
    new AutoNumeric('#rupiah', 'integer');
</script>
</html>
