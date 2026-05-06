@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h4>گزارش مالی</h4>
                </div>
                <div class="card-body">
                    {{-- Report Type Selector --}}
                    <form method="GET" class="mb-4">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-2">
                                <label class="form-label">نوع گزارش</label>
                                <select name="type" class="form-select" onchange="this.form.submit()">
                                    <option value="today" {{ $reportType == 'today' ? 'selected' : '' }}>امروز</option>
                                    <option value="daily" {{ $reportType == 'daily' ? 'selected' : '' }}>روزانه</option>
                                    <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>ماهانه</option>
                                    <option value="custom" {{ $reportType == 'custom' ? 'selected' : '' }}>بازه دلخواه
                                    </option>
                                </select>
                            </div>

                            @if ($reportType == 'daily')
                                <div class="col-md-3">
                                    <label class="form-label">تاریخ</label>
                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}"
                                        onchange="this.form.submit()">
                                </div>
                            @elseif($reportType == 'monthly')
                                <div class="col-md-3">
                                    <label class="form-label">ماه</label>
                                    <input type="month" name="month" class="form-control" value="{{ request('month') }}"
                                        placeholder="YYYY-MM" onchange="this.form.submit()">
                                </div>
                            @elseif($reportType == 'custom')
                                <div class="col-md-2">
                                    <label class="form-label">از تاریخ</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">تا تاریخ</label>
                                    <input type="date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">اعمال</button>
                                </div>
                            @endif
                        </div>
                    </form>

                    {{-- Total Revenue Box --}}
                    <div class="alert alert-success d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">مجموع فروش:</span>
                        <span class="fs-4">{{ number_format($total) }} تومان</span>
                    </div>

                    {{-- Orders Table --}}
                    <table class="table bg-white table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>شماره سفارش</th>
                                <th>مشتری</th>
                                <th>تاریخ</th>
                                <th>اقلام</th>
                                <th>مبلغ (تومان)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer->name ?? 'مهمان' }}</td>
                                    <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($order->menu_item as $item)
                                                <li>{{ $item->name ?? 'آیتم #' . $item->id }} ({{ $item->pivot->qty }}x
                                                    {{ number_format($item->price) }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ number_format($order->menu_item->sum(fn($i) => $i->pivot->qty * $i->price)) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">هیچ سفارش پرداخت شده‌ای یافت نشد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
