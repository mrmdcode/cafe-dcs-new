@extends('Layouts.system')
@section('title', 'خطای ۵۰۰ | پنل مدیریت')

@section('css')
<style>
    .error-500 {
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

    .error-icon {
        font-size: 48px;
        color: #888;
        margin-bottom: 1.5rem;
    }

    .error-label {
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #999;
        margin: 0 0 8px;
    }

    .error-title {
        font-size: 22px;
        font-weight: 500;
        color: #1a1a1a;
        margin: 0 0 12px;
        line-height: 1.4;
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
        transition: border-color 0.2s, color 0.2s;
    }

    .btn-error:hover {
        border-color: #bbb;
        color: #111;
    }

    .btn-error.secondary {
        color: #888;
    }

    .error-footer {
        margin-top: 2rem;
        font-size: 13px;
        color: #aaa;
    }
</style>
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
