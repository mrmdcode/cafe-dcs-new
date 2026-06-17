@extends('Layouts.system')
@section('title', 'خطای ۴۰۳ | پنل مدیریت')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/errors.css') }}">
@endsection

@section('content')
    <div class="error-page">
        <div class="error-box">
            <span class="error-badge">خطای ۴۰۳</span>
            <i class="ti ti-lock error-icon"></i>
            <h1 class="error-title">دسترسی ممنوع</h1>
            <p class="error-message">شما مجوز لازم برای مشاهده این صفحه را ندارید.</p>
            <div class="error-actions">
                <a href="javascript:history.back()" class="btn-error">
                    <i class="ti ti-arrow-left"></i> بازگشت
                </a>
                <a href="{{ url('/') }}" class="btn-error secondary">
                    <i class="ti ti-home"></i> صفحه اصلی
                </a>
            </div>
            <p class="error-footer">اگر فکر می‌کنید اشتباهی رخ داده، با پشتیبانی تماس بگیرید.</p>
        </div>
    </div>
@endsection
