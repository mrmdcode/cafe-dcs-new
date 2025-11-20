@extends('Layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 ">
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4 pb-0">
                    <div class="d-sm-flex justify-content-between align-items-center border-bottom pb-20 mb-20">
                        <h4 class="fw-bold fs-18 mb-0 text-center">سفارش {{$order->customer->name}}</h4>
                        <h4 class="fw-bold fs-18 mb-0 text-center text-gray-light body-font">21 دی 1402</h4>
                    </div>
                    <div class="default-table-area orders-details-info">
                        <div class="table-responsive">
                            <table class="table align-middle text-center">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-primary text-start">نام</th>
                                    <th scope="col">قیمت</th>
                                    <th scope="col">تعداد</th>
                                    <th scope="col">توضیحات</th>
                                    <th scope="col" class="text-end">مقدار کل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $total = 0; @endphp
                                @forelse($order->menu_item as $item)
                                    <tr>
                                        <td class="text-start">
                                            <a href="#" class="d-flex align-items-center">
                                                <img src="@if($item->image){{asset('/storage/'.$item->image)}} @else {{asset('assets/images/food-loading.png')}} @endif" width="67px" height="67px" class="wh-55 rounded-3" alt="product">
                                                <div class="ms-3">
                                                    <h6 class="text-dark ms-0 mb-1">{{$item->name}}</h6>
                                                    <span class="fs-14 fw-semibold heading-font"><span class="text-gray-light">منو:</span> {{$item->menu->name}}</span>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{$item->price}} تومان</td>
                                        <td>{{$item->pivot->qty}}</td>
                                        <td>{{$item->pivot->description}}</td>
                                @php $total += $item->pivot->qty * $item->price; @endphp

                                        <td class="fw-semibold text-end">{{$item->pivot->qty * $item->price}} تومان</td>
                                    </tr>
                                @empty

                                <tr></tr>
                                @endforelse

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-semibold">زیر مجموع :</td>
                                    <td class="fw-semibold text-end">{{$total}} تومان</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-semibold">تخفیف :</td>
                                    <td class="fw-semibold text-end">@if($order->discount) {{$order->discount}} تومان@elseندارد @endif</td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-semibold text-dark">مجموع :</td>
                                    <td class="fw-semibold text-dark text-end">{{$total - $order->orde}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-12 col-sm-12">
            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <h4 class="fs-18 fw-semibold mb-4">اطلاعات صورت حساب</h4>
                    <h5 class="fs-16 fw-semibold mb-3">{{$order->customer->name}}</h5>
                    <ul class="ps-0 mb-0 list-unstyled">
                        <li class="mb-2 d-flex">
                            <span class="fw-semibold d-inline-block">کد اشتراک : </span>
                            <span class="ms-1">{{$order->customer->id}} (برای اینکه هربار نیازی به دادن شماره نباشد میتوانید از کد اشتراک خود استفاده کنید  )</span>
                        </li>
                        <li class="mb-2 d-flex">
                            <span class="fw-semibold d-inline-block">نوع پرداخت : </span>
                            <span class="ms-1">کارت اعتباری</span>
                        </li>
                        <li class="mb-2 d-flex">
                            <span class="fw-semibold d-inline-block">ارائه دهنده : </span>
                            <span class="ms-1">{{$order->customer->name}}</span>
                        </li>
                        <li class="d-flex mb-2">
                            <span class="fw-semibold d-inline-block">تاریخ معتبر : </span>
                            <span class="ms-1">21 دی 1402</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
