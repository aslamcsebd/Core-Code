
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   {{-- <meta http-equiv="refresh" content="5" /> --}}

   <title> @yield('pageTitle') </title>
   <link rel="icon" href="{{ asset('images/code.svg') }}" type="image/icon type">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   {{--  AdminLTE v3.1.0
         Bootstrap v4.6.0 --}}
   <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
   <link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
   <link rel="stylesheet" href="{{ asset('css/OverlayScrollbars.min.css') }}">

   {{-- Include normalize --}}
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
   