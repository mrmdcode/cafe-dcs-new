@extends('Layouts.system')
@section('title', 'خطای ۴۰۳ | پنل مدیریت')

@section('css')
<style>
    .error-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: #f7f7f6;
    }

    .error-box {
        text-align: center;
        max-width: 420px;
        width: 100%;
    }

    .error-badge {
        display: inline-block;
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 3px 12px;
        border-radius: 6px;
        background: #FCEBEB;
        color: #791F1F;
        margin-bottom: 1.25rem;
    }

    .error-icon {
        font-size: 44px;
        color: #A32D2D;
        display: block;
        margin-bottom: 1rem;
    }

    .error-title {
        font-size: 22px;
        font-weight: 500;
        color: #1a1a1a;
        margin: 0 0 10px;
    }

    .error-message {
        font-size: 15px;
        color: #666;
        line-height: 1.7;
        margin: 0 0 2rem;
    }

    .error-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-error {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 20px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        background: #fff;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .btn-error:hover { border-color: #bbb; color: #111; }
    .btn-error.secondary { color: #888; }

    .error-footer {
        margin-top: 2rem;
        font-size: 13px;
        color: #aaa;
    }
</style>
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
