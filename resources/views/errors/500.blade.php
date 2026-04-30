@extends('Layouts.system')

@section('title', 'خطای ۵۰۰ - خطای سرور داخلی | پنل مدیریت')

@section('css')
    <style>
        .error-500 {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .error-code {
            font-size: 120px;
            font-weight: 800;
            color: #764ba2;
            margin: 0;
            line-height: 1;
            text-shadow: 3px 3px 0 rgba(102, 126, 234, 0.2);
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

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .search-box {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
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
    <div class="error-500">
        <div class="error-box">
            <div class="error-icon">⚠️</div>
            <h1 class="error-code">۵۰۰</h1>
            <h2 class="error-title">خطای داخلی سرور!</h2>
            <div class="error-message">
                متأسفانه خطایی در سرور رخ داده است.<br>
                لطفاً چند دقیقه دیگر مجدداً تلاش کنید. در صورت تکرار مشکل، با پشتیبانی فنی تماس بگیرید.
            </div>

            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ url('/') }}" class="btn-back">
                    🏠 بازگشت به صفحه اصلی
                </a>
                <a href="javascript:history.back()" class="btn-back" style="background: #48bb78;">
                    ↩️ بازگشت به صفحه قبل
                </a>
            </div>

            <div class="search-box">
                <input type="text" class="search-input" placeholder="جستجو در سایت...">
            </div>
        </div>
    </div>
@endsection
