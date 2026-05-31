<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Taker {{$company->name}}</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/OTdashboard.css')}}">
    <meta name="X-CSRF-TOKEN" content="{{csrf_token()}}">

</head>
<body>

<div id="loader" style="z-index: 10; width: 100%;height: 100vh; background-color: #2b3035;opacity: 0.6;display:none;justify-content:center;align-items:center;position: fixed">
    <div class="spinner-border" role="status" >
        <span class="visually-hidden">بارگذاری...</span>
    </div>
</div>

<form action="{{route('logout')}}" method="post" id="lgform">
    @csrf
</form>
<input type="hidden" id="X-CSRF-TOKEN" value="">

    <div class="container-fluid bg-dark" style="height: 100vh">
        <div class="row text-center pt-2">
            <h3 class="col-md-4 text-secondary" >
                <button onclick="document.getElementById('lgform').submit()" class="btn">خروج
                </button>
            </h3>
            <h3 class="col-md-4 text-secondary">{{$company->name}}</h3>
            <h3 class="col-md-4 text-secondary">{{$user->name}}</h3>
        </div>
        <div class="row  fw-semibold " id="tables">
            <div class="col-md-12 py-3 ">
                <button class="btn btn-warning w-100" >بدون میز</button>
            </div>



        </div>
    </div>


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="order_register" tabindex="2" aria-labelledby="order_register_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="order_register_label">عنوان مدال</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label class="label">نام مشتری</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="customer_name" name="customer_name" placeholder="نام مشتری ">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label class="label">شماره مشتری</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="customer_phone" name="customer_phone" placeholder="شماره مشتری ">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label class="label">کد اشتراک</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="subscription_code" onkeyup="handler_subscription_code(this.value)" name="subscription_code" placeholder="کد اشتراک">
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
                <button type="button" class="btn btn-primary text-white" id="send_btn" >ثبت</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/assets/js/sweetalert.js')}}"></script>
<script src="{{asset('assets/js/OTdashboard.js')}}"></script>

</body>
</html>
