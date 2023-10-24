<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{config('app.name')}}</title>
    <meta charset="UTF-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="author" content="RoQaY Company"/>
    <meta name="robots" content="index, follow"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,  user-scalable=0" name="viewport"/>
    <meta name="description" content="Amana"/>
    <meta name="keywords" content="Amana"/>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Font Awesome -->
    <link rel="stylesheet" media="all"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- bootstrap 5 -->
    @if(app()->getLocale() == 'ar')
        <!-- bootstrap 5 if arabic -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
              integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
    @else
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
              integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endif
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"
          integrity="sha512-vebUliqxrVkBy3gucMhClmyQP9On/HAWQdKDXRaAlb/FKuTbxkjPKUyqVOxAcGwFDka79eTF+YXwfke1h3/wfg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" async/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;700;800;900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet" async>
    <!-- fonts -->

    <link href="{{asset('UI/assets/css/style.css')}}" rel="stylesheet" >
    <link href="{{asset('UI/assets/css/colors.css')}}" rel="stylesheet" >
    <link href="{{asset('UI/assets/css/custom.css')}}" rel="stylesheet" >

{{--    @vite(['resources/app/app.js',--}}
{{--           'resources/sass/app.scss',--}}
{{--           'public/UI/assets/css/style.css',--}}
{{--           'public/UI/assets/css/colors.css',--}}
{{--           'public/UI/assets/css/custom.css'])--}}
</head>


<!-- If Arabic -->
<!-- Add dir="rtl" class="rtl"-->
<body {{app()->getLocale()}} class='main-body {{app()->getLocale() == 'ar' ? 'rtl':''}}'
      dir="{{app()->getLocale() == 'ar' ? 'rtl':'ltr'}}">
@yield('content')
</body>

</html>
