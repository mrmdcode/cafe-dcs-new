@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.cashier._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.cashier._partial._topMenu')
@endsection
@section('content')
    <!-- Search row -->
    <form method="GET" action="{{ request()->url() }}">
        <div class="row mx-1 bg-body-secondary mb-4 rounded-3 pt-3 pb-3">
            <div class="col-md-3">
                <div class="form-group d-flex mb-0">
                    <label class="col-form-label px-2">نام مشتری :</label>
                    <input type="text" class="form-control-sm text-dark ps-5 bg-light" name="customer_name"
                        value="{{ request('customer_name') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group d-flex mb-0">
                    <label class="col-form-label px-2">میز :</label>
                    <input type="text" class="form-control-sm text-dark ps-5 bg-light" name="location"
                        value="{{ request('location') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group d-flex mb-0">
                    <label class="col-form-label px-2">شماره فاکتور :</label>
                    <input type="text" class="form-control-sm text-dark ps-5 bg-light" name="invoice"
                        value="{{ request('invoice') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group d-flex mb-0">
                    <!-- A general submit button (optional) -->
                    <button type="submit" class="btn btn-primary mb-3">اعمال فیلترها</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Filter row -->
    <div class="row mx-1 bg-body-secondary mb-4 rounded-3 pt-3 pb-1">
        <form method="GET" action="{{ request()->url() }}" class="mb-3">
            <!-- Time preset buttons -->
            <div class="col-md-4 d-flex pb-2 gap-2">
                <button type="submit" name="today" value="1"
                    class="btn @if (request('today')) btn-primary @else btn-outline-primary @endif">
                    امروز
                </button>
                <button type="submit" name="yesterday" value="1"
                    class="btn @if (request('yesterday')) btn-primary @else btn-outline-primary @endif">
                    دیروز
                </button>
                <button type="submit" name="older" value="1"
                    class="btn @if (request('older')) btn-primary @else btn-outline-primary @endif">
                    سفارش های قدیمی
                </button>
                <button type="submit" name="paid" value="1"
                    class="btn @if (request('paid')) btn-success @else btn-outline-success @endif">
                    پرداخت شده
                </button>
            </div>
        </form>
        {{-- <!-- Custom date range (remove disabled to enable) -->
            <div class="col-md-2">
                <div class="form-group d-flex mb-0">
                    <label class="col-form-label">از تاریخ</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="form-control-sm text-dark ps-5 h-58">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group d-flex mb-0">
                    <label class="col-form-label">تا تاریخ</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="form-control-sm text-dark ps-5 h-58">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-success">انتخاب زمان منتخب</button>
            </div> --}}
    </div>

    <div class="row mx-1">
        <div class="card bg-white border-0 ">
            <div class="card-body">

                <h4 class="mt-0 header-title">سفارش ها </h4>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="default-table-area recent-orders">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>مشتری</th>
                                    <th>میز</th>
                                    <th>فاکتور</th>
                                    <th>هزینه نهایی سفارش</th>
                                    <th>سفارش گیرنده</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $index => $order)
                                    @php
                                        $total = $order->menu_item->sum(
                                            fn($item) => $item->pivot->per * $item->pivot->qty,
                                        );
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $order->customer->name ?? '' }}</td>
                                        <td>{{ $order->table->id ?? '' }} - {{ $order->table->name ?? '' }}</td>
                                        <td>
                                            <a href="/company/orders/{{ $order->id }}/{{ $order->unique_key }}/factor"
                                                target="_blank" class="btn btn-sm btn-success">فاکتور</a>
                                        </td>
                                        <td>{{ number_format($total) }}</td>
                                        <td>{{ $order->order_recipient->name ?? '' }}
                                            {{ $order->order_recipient->family ?? '' }}</td>
                                        <td><span class="badge bg-{{ $order->status->color() }}">
                                                {{ $order->status->label() }}
                                            </span></td>
                                        <td>
                                            <button class="btn btn-primary view-btn" data-id="{{ $order->id }}"
                                                data-key="{{ $order->unique_key }}">
                                                نمایش
                                            </button>
                                            <a href="{{ route('company.cashier.orders.edit', $order) }}"
                                                class="btn btn-warning {{ in_array($order->getRawOriginal('status'), ['finish', 'paid']) ? 'disabled' : '' }}">
                                                ویرایش
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">سفارشی پیدا نشد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="view_order_modal" tabindex="-1" aria-labelledby="view_order_modal_label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="view_order_modal_label">عنوان مدال</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>آیتم</th>
                                <th>تعداد</th>
                                <th>قیمت</th>
                                <th>قیمت کل</th>
                            </tr>
                        </thead>
                        <tbody class="items"></tbody>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">تخفیف :</div>
                        <div class="col-md-3" id="discount">0</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">مالیات :</div>
                        <div class="col-md-3" id="tax">0</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">مجموع :</div>
                        <div class="col-md-3" id="total_all">0</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">بستن</button>
                    <button type="button" class="btn btn-danger text-white" id="delete">حذف</button>
                    <button type="button" class="btn btn-primary text-white" id="print">پرینت</button>
                    <button type="button" class="btn btn-primary text-white" id="finish"
                        title="ارسال به سر میر">اتمام آماده سازی</button>
                    <button type="button" class="btn btn-primary text-white" id="paid">پرداخت</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script> --}}
    <script src="{{ asset('/assets/js/qz-tray.js') }}"></script>
    <script src="{{ asset('/assets/js/cashier-orders.js') }}"></script>
    <script src="{{ asset('/assets/js/cashier_printers.js') }}"></script>
@endsection
@section('css')
@endsection
