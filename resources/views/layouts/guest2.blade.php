<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">


    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('import/img/photos/ReminExlogolink3.png')}}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>ReminEx Faculty</title>

	<link href="{{asset('import/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('import/css/collapse.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

</head>
<body class="hold-transition">
    <header>
        {{-- @auth --}}
            @include('layouts.partial.guest-nav')
            
        {{-- @endauth --}}
    </header>
    
    <div class="wrapper">
        @include('layouts.partial.side-nav')
        @yield('content')
    </div>
    

    


@vite('resources/js/app.js')
@vite('resources/js/collapse.js')
<!-- Bootstrap 4 -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>
</html>