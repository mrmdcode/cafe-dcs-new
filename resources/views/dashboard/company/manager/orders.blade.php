@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
    <meta name="X-CSRF-TOKEN" content="{{csrf_token()}}"/>
    <div class="row mx-1 bg-body-secondary mb-4 rounded-3 pt-3 pb-3">
        <div class="col-md-3">
            <div class="form-group d-flex  mb-0">
                <label class="col-form-label px-2">نام مشتری : </label>
                <input type="text" class="form-control-sm text-dark ps-5 bg-light">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group d-flex  mb-0">
                <label class="col-form-label px-2">مکان :</label>
                <input type="text" class="form-control-sm text-dark ps-5 bg-light">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group d-flex  mb-0">
                <label class="col-form-label px-2">شماره فاکتور :</label>
                <input type="text" class="form-control-sm text-dark ps-5 bg-light">
            </div>
        </div>
    </div>
    <div class="row mx-1 bg-body-secondary mb-4 rounded-3 pt-3 pb-1">
        <div class="col-md-4 d-flex pb-2">
            <button class="btn btn-primary rounded-5 " id="time_today" onclick="filter_time_refresh('today')">امروز</button>
            <button class="btn btn-outline-primary rounded-5  mx-1" id="time_yesterday" onclick="filter_time_refresh('yesterday')">دیروز</button>
            <button class="btn btn-outline-primary rounded-5" id="time_older" onclick="filter_time_refresh('older')">قبلتر</button>
        </div>


        <div class="col-md-2">

            <div class="form-group d-flex  mb-0">
                <label class="col-form-label">از تازیخ</label>
                <input type="date" class="form-control-sm text-dark ps-5 h-58" disabled>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group d-flex mb-0">
                <label class="col-form-label">از تازیخ</label>
                <input type="date" class="form-control-sm text-dark ps-5 h-58" disabled>

            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-success" disabled>انتخاب زمان منتخب</button>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-1 form-switch">
            <label class="form-check-label" for="flexSwitchCheckChecked">حساب شده .</label>
            <br>
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" onchange="filter_paid_refresh()" >
        </div>

    </div>
    <div class="row mx-1">
        <div class="card bg-white border-0 ">
            <div class="card-body">

                <h4 class="mt-0 header-title">سفارش ها </h4>
                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif



                <div class="default-table-area recent-orders">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>نام مشتری</th>
                                <th>شماره میز</th>
                                <th>فاکتور</th>
                                <th>مبلغ سفارش</th>
                                <th>سفارش گیرنده</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody id="orders">


                                <tr>
                                    <td colspan="8">دیتا نا موجود</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>



            </div>

            <div class="modal fade" id="edit_order" tabindex="2" aria-labelledby="order_register_label" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="order_register_label">عنوان مدال</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="label">نام مشتری</label>
                                        <div class="form-group position-relative">
                                            <input type="text" class="form-control text-dark ps-5 h-58" id="customer_name" name="customer_name" placeholder="نام مشتری ">
                                            <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="label">شماره مشتری</label>
                                        <div class="form-group position-relative">
                                            <input type="text" class="form-control text-dark ps-5 h-58" id="customer_phone" name="customer_phone" placeholder="شماره مشتری ">
                                            <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <hr>

                            <div class="row bg-light">
                                <div  class="col-md-12 " style="overflow-x: auto;border-bottom: 1px solid #000;">
                                    <div id="menus" class="row flex-row flex-nowrap">

                                    </div>
                                </div>

                                <div id="menu_items" style="border-left: 1px solid #000000e4;" class=" col-md-4 p-0 mw-100">
                                </div>
                                <div id="order_items" class="col-md-8" style="height: 450px;"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">بستن</button>
                            <button type="button" class="btn btn-primary text-white" id="send_btn" >بروزرسانی</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="view_order_modal" tabindex="-1" aria-labelledby="view_order_modal_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="view_order_modal_label">عنوان مدال</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered ">
                        <thead >
                            <th>#</th>
                            <th>آیتم</th>
                            <th>تعداد</th>
                            <th>قیمت</th>
                            <th>قیمت کل</th>
                        </thead>
                        <tbody class="items">

                        </tbody>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">تخفیف : </div>
                        <div class="col-md-3" id="tax"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3" >مالیات :</div>
                        <div class="col-md-3" id="tax"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">مجموع :</div>
                        <div class="col-md-3" id="total_all"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">بستن</button>
                    <button type="button" class="btn btn-danger text-white" id="delete">حذف</button>
                    <button type="button" class="btn btn-primary text-white" id="print">پرینت</button>
                    <button type="button" class="btn btn-primary text-white" id="finish" title="ارسال به سر میر">اتمام آماده سازی</button>
                    <button type="button" class="btn btn-primary text-white" id="paid">پرداخت</button>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('js')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script src="{{asset('/assets/js/qz-tray.js')}}"></script>
    <script src="{{asset('/assets/js/orders_controller.js')}}"></script>
    <script src="{{asset('/assets/js/cashier_printers.js')}}"></script>
@endsection
@section('css')
@endsection
