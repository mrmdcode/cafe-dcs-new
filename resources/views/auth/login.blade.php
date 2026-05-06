@extends('Layouts.app')

@section('content')

    <div class="m-auto mw-510 py-5">
        <form method="post" action="{{route('login')}}">
            @csrf

            <div class="d-flex align-items-center gap-4 mb-3">
                <h4 class="fs-3 mb-0">شروع کنید.</h4>
                <a href="index.html">
                    <img src="assets/images/logo.svg" alt="logo">
                </a>
            </div>
            <p class="fs-18 mb-5">حساب کاربری ندارید؟ <a href="register.html" class="text-decoration-none text-primary">ثبت نام</a></p>
            <div class="d-sm-flex gap-3 mb-4">
                <a href="https://www.google.com/" target="_blank" class="btn btn-outline-primary fs-16 fw-semibold text-dark heading-fornt py-2 py-md-3 px-4 hover-white w-sm-100">
                    <img src="assets/images/google.svg" alt="google">
                    <span class="ms-2">ورود از طریق گوگل</span>
                </a>
                <a href="https://www.facebook.com/" target="_blank" class="btn btn-primary fs-16 fw-semibold text-dark heading-fornt py-2 py-md-3 px-4 text-white w-sm-100 mt-3 mt-sm-0">
                    <img src="assets/images/facebook.svg" alt="google">
                    <span class="ms-2">ورود از طریق فیس بوک</span>
                </a>
            </div>
            <span class="d-block fs-18 fw-semibold text-center or mb-4">
            <span class="bg-body-bg d-inline-block py-1 px-3">یا</span>
            </span>
            <div class="card bg-white border-0 rounded-10 mb-4">

                <div class="card-body p-4">
                    <div class="form-group mb-4">
                        <label class="label">ایمیل</label>
                        <input type="email" class="form-control h-58 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ایمیل خود را وارد کنید">
                    </div>
                    <div class="form-group mb-0">
                        <label class="label">گذرواژه</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative">
                                <input type="password" id="password" class="form-control h-58 text-dark" name="password" placeholder="رمز عبور را وارد کنید">
                                <i style="color: #A9A9C8; font-size: 16px; left: 15px !important;" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 end-0 position-absolute" aria-hidden="true"></i>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @error('email')
                    <span class="" role="">
                        <b>{{ $message }}</b>
                    </span>
                    @enderror
                    @error('password')
                    <span class="" role="">
                        <b>{{ $message }}</b>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="d-sm-flex justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input position-relative" style="top: 1.1px;" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label fs-16 text-gray-light" for="flexCheckDefault">
                        مرا به خاطر بسپار
                    </label>
                </div>

                <a href="{{ route('password.request') }}" class="fs-16 text-primary text-decoration-none mt-2 mt-sm-0 d-block">
                    فراموشی گذرواژه؟
                </a>
            </div>
            <button class="btn btn-primary fs-16 fw-semibold text-dark heading-fornt py-2 py-md-3 px-4 text-white w-100">
                ورود
            </button>
        </form>
    </div>
@endsection




