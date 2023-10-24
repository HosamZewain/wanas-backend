@extends('auth.layout')

@section('content')
    {{-- <div class="auth-content min-vh-100" style="background:url({{asset('UI/assets/images/bg.png')}}) no-repeat center left/100% 100%"> --}}
    <div class="auth-content min-vh-100">
        <div class="container-fluid">
            <div class="row no-gutters">
                <!-- discription -->
                <div class="col-md-7 col-sm-12">
                    <div class="auth-logo text-center my-5">
                        <img
                            src="{{asset('UI/assets/images/login-logo.png')}}"
                            class="logo-img"
                            alt="logo"
                        />
                    </div>
                    <h1 class="main-heder text-center mb-5">Reset Password</h1>
                    <p class="text-center main-p text-capitalize mb-5">
                        roqay operations mangement system
                    </p>

                    <div class="authForm mb-3">
                        <form action="{{ route('reset.password.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="email_address" class="text-white mb-2">Email</label>
                                <input type="email" id="email_address" placeholder="Type Email"
                                       class="form-control mb-2" name="email" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="my-3">
                                <label for="password" class="text-white mb-2">Password</label>
                                <input type="password" id="password" class="form-control mb-2"
                                       placeholder="Type Password" name="password"
                                       required autofocus>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="my-3">
                                <label for="password-confirm" class="text-white mb-2">Confirm Password</label>
                                <input type="password" id="password-confirm" class="form-control mb-2"
                                       placeholder="Type Confirm Password" name="password_confirmation"
                                       required autofocus>
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn ripple btn-primary w-100 fw-bold fs-15 authBtn">
                                Reset Password
                            </button>
                        </form>
                    </div>
                </div>
                <!-- image -->
                <div class="col-md-5 d-none d-sm-none d-md-block">
                    <img
                        src="{{asset('UI/assets/images/img.png')}}"
                        alt="img"
                        class="side-img w-100 h-100"
                    />
                </div>
            </div>
        </div>
    </div>

@endsection
