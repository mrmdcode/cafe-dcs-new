@extends('Layouts.system')
@section('title', 'خطای ۵۰۰ | پنل مدیریت')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/errors.css') }}">
@endsection

@section('content')
    <div class="error-500">
        <div class="error-box">
            <div class="error-icon">
                <i class="ti ti-server-off"></i>
            </div>
            <p class="error-label">خطای ۵۰۰</p>
            <h1 class="error-title">خطای داخلی سرور</h1>
            <p class="error-message">مشکلی در سمت سرور پیش آمد. چند لحظه صبر کنید و دوباره امتحان کنید.</p>
            <div class="error-actions">
                <a href="javascript:history.back()" class="btn-error">
                    <i class="ti ti-arrow-left"></i> بازگشت
                </a>
                <a href="{{ url('/') }}" class="btn-error secondary">
                    <i class="ti ti-home"></i> صفحه اصلی
                </a>
            </div>
            <p class="error-footer">اگر مشکل ادامه دارد، با پشتیبانی تماس بگیرید.</p>
        </div>
    </div>
@endsection
