@extends('Layouts.system')
@section('title', 'خطای ۴۰۴ | پنل مدیریت')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/errors.css') }}">
@endsection

@section('content')
<div class="error-page">
    <div class="error-box">
        <span class="error-badge">خطای ۴۰۴</span>
        <i class="ti ti-file-search error-icon"></i>
        <h1 class="error-title">صفحه پیدا نشد</h1>
        <p class="error-message">صفحه‌ای که دنبالش می‌گردید وجود ندارد یا جابجا شده است.</p>
        <div class="error-actions">
            <a href="javascript:history.back()" class="btn-error">
                <i class="ti ti-arrow-left"></i> بازگشت
            </a>
            <a href="{{ url('/') }}" class="btn-error secondary">
                <i class="ti ti-home"></i> صفحه اصلی
            </a>
        </div>
        <p class="error-footer">آدرس را بررسی کنید یا از منو وارد شوید.</p>
    </div>
</div>
@endsection
