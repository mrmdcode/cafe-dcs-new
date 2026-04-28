@extends('Layouts.system')

@section('title', 'خطای ۴۰۳ - دسترسی غیرمجاز | پنل مدیریت')

@section('css')
<style>
        .error-403 {
            min-height: 100vh;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-box {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            text-align: center;
            max-width: 550px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .error-code {
            font-size: 120px;
            font-weight: 800;
            color: #f5576c;
            margin: 0;
            line-height: 1;
        }

        .error-icon {
            font-size: 80px;
            margin: 20px 0;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin: 20px 0 15px;
        }

        .error-message {
            color: #718096;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4);
            color: white;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #4a5568;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            background: #2d3748;
            color: white;
        }

        .contact-support {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #718096;
        }

        .contact-support a {
            color: #f5576c;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .error-box {
                padding: 30px 20px;
            }

            .error-code {
                font-size: 80px;
            }

            .error-title {
                font-size: 22px;
            }
        }
    </style>
@endsection

@section('content')
<div class="error-403">
    <div class="error-box">
        <div class="error-icon">🚫</div>
        <h1 class="error-code">۴۰۳</h1>
        <h2 class="error-title">دسترسی غیرمجاز!</h2>
        <div class="error-message">
            شما به این بخش دسترسی ندارید.<br>
            لطفاً با حساب کاربری مناسب وارد شوید یا با مدیر سیستم تماس بگیرید.
        </div>

        <div class="d-flex gap-3 justify-content-center">
            @if(!auth()->check())
                <a href="{{ route('login') }}" class="btn-login">
                    🔐 ورود به پنل
                </a>
            @endif
            <a href="{{ url('/') }}" class="btn-home">
                🏠 صفحه اصلی
            </a>
        </div>

        <div class="contact-support">
            نیاز به کمک دارید؟ <a href="mailto:support@digitalcoffee.ir">تماس با پشتیبانی</a>
        </div>
    </div>
</div>
@endsection
