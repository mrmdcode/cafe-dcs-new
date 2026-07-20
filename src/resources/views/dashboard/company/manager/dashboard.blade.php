@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-8">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="stats-box card bg-white border-0 rounded-10 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-1">
                                <div class="flex-grow-1 me-3">
                                    <h3 class="body-font fw-bold fs-3 mb-2">{{ number_format($totalSales) }} تومان</h3>
                                    <span>کل فروش</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="icon transition">
                                        <i class="flaticon-donut-chart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="stats-box card bg-white border-0 rounded-10 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-1">
                                <div class="flex-grow-1 me-3">
                                    <h3 class="body-font fw-bold fs-3 mb-2">{{ number_format($totalOrders) }}</h3>
                                    <span>کل سفارش</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="icon transition">
                                        <i class="flaticon-goal"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="stats-box card bg-white border-0 rounded-10 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-1">
                                <div class="flex-grow-1 me-3">
                                    <h3 class="body-font fw-bold fs-3 mb-2">{{ number_format($totalCustomers) }}</h3>
                                    <span>کل مشتریان</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="icon transition">
                                        <i class="flaticon-award"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold fs-18 mb-3">وضعیت سفارش‌های امروز</h4>
                    <ul class="ps-0 mb-0 list-unstyled sales_by_locations">
                        @foreach($statusBreakdown as $status)
                            <li class="mb-3">
                                <span class="fw-semibold d-block mb-2">{{ $status['label'] }} ({{ $status['count'] }})</span>
                                <div class="progress" role="progressbar" aria-valuenow="{{ $status['percent'] }}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-{{ $status['color'] }}" style="width: {{ $status['percent'] }}%">
                                        <span class="count fw-semibold text-body">%{{ $status['percent'] }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <h4 class="fs-18 fw-semibold mb-3">پرفروش‌ترین آیتم‌های امروز</h4>
                    @forelse($topItemsToday as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $item->name }}</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $item->total_qty }} عدد</span>
                        </div>
                    @empty
                        <p class="text-gray-light mb-0">امروز هنوز سفارشی ثبت نشده است.</p>
                    @endforelse
                </div>
            </div>
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold fs-18 mb-3">مشتریان اخیر</h4>
                    <ul class="ps-0 mb-0 list-unstyled max-h-198">
                        @forelse($recentCustomers as $customer)
                            <li class="border-bottom border-color-gray mb-3 pb-3">
                                <div class="d-sm-flex justify-content-between align-content-center">
                                    <div class="flex-grow-1">
                                        <h4 class="fw-semibold fs-16 mb-0">{{ $customer->name }}</h4>
                                        <span class="text-gray-light">{{ $customer->phone }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-sm-0">
                                        <span class="bg-opacity-10 bg-primary fs-13 fw-semibold text-primary py-1 px-3 rounded-pill">{{ $customer->orders_count }} سفارش</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-light">مشتری‌ای ثبت نشده است.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-white border-0 rounded-10 mb-4">
        <div class="card-body p-4">
            <h4 class="fw-bold fs-18 mb-3">سفارشات اخیر</h4>
            <div class="default-table-area recent-orders">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th scope="col" class="text-primary">شناسه سفارش</th>
                            <th scope="col">مشتری</th>
                            <th scope="col">مبلغ</th>
                            <th scope="col">تاریخ</th>
                            <th scope="col">وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="fw-semibold">#{{ $order['id'] }}</td>
                                <td>{{ $order['customer'] }}</td>
                                <td>{{ number_format($order['total']) }} تومان</td>
                                <td>{{ $order['date'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $order['status']->color() }} bg-opacity-10 text-{{ $order['status']->color() }} py-2 px-3 fw-semibold">{{ $order['status']->label() }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">سفارشی ثبت نشده است.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
