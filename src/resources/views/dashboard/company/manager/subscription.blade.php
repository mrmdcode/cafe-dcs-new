@extends('Layouts.system')

@section('title', 'پرداخت اشتراک ماهیانه')

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card w-100" style="max-width: 500px;"> {{-- optional width limit --}}
            <div class="card-header">فعال‌سازی اشتراک</div>
            <div class="card-body text-center">
                <p>برای استفاده از سرویس، نیاز به اشتراک فعال دارید.</p>
                <p>مبلغ اشتراک: {{ number_format($amount) }} تومان</p>
                <form action="{{ route('subscription.pay') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">پرداخت و فعال‌سازی</button>
                </form>
            </div>
             @foreach (['success', 'error', 'warning', 'info'] as $msg)
                @if (session()->has($msg))
                    <div class="alert alert-warning">
                        {{ session($msg) }}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
