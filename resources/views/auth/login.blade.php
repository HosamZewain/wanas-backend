<!doctype html>
<html class="no-js " lang="ar">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>:: تطبيق ونس :: تسجيل الدخول</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.min.css') }}">
</head>

<body class="theme-blush " dir="rtl">

<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="header">
                        <img class="logo" src="{{ asset('dashboard/assets/images/logo.svg') }}" alt="">
                        <h5>أهلا بك فى تطبيق ونس</h5>
                    </div>
                    <div class="body">
                        <div class="input-group mb-3">
                            <input id="email" type="email" placeholder="البريد الإلكترونى"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" type="password" placeholder="كلمة المرور"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password">
                            <div class="input-group-append">
                                <span class="input-group-text"><a href="forgot-password.html" class="forgot"
                                                                  title="Forgot Password"><i class="zmdi zmdi-lock"></i></a></span>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="checkbox">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember_me">
                                تذكرنى
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">
                            تسجيل دخول
                        </button>

                    </div>
                </form>
                <div class="copyright text-center">
                    &copy;
                    <script>document.write(new Date().getFullYear())</script>
                    ,
                    <span>جميع الحقوق محفوظة تطبيق ونس </span>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="{{ asset('dashboard/assets/images/signin.svg') }}" alt="Sign In"/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('dashboard/assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('dashboard/assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->
</body>
</html>
