@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.admin._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.admin._partial._topMenu')
@endsection
@section('content')

        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">نام کافه</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="name" value="{{$company->name}}" name="name" placeholder="نام کافه">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">نام کاربری کافه</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="username" value="{{$company->username}}" name="username" placeholder="نام کاربری کافه">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">نام مدیریت کافه</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="name_boss" value="{{$company->name_boss}}" name="name_boss" placeholder="نام مدیریت کافه">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group mb-4">
                    <label class="label">ظرفیت کافه</label>
                    <div class="form-group position-relative">
                        <div class="product-quantity">
                            <div class="add-to-cart-counter gap-2">
                                <button type="submit" class="minusBtn"></button>
                                <input disabled type="text" size="25" value="1" name="capacity" value="{{$company->capacity}}" class="count"/>
                                <button type="submit" class="plusBtn"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label class="label">قیمت (تومان)</label>
                    <div class="form-group position-relative">
                        <input disabled type="number" class="form-control text-dark ps-5 h-58" id="fee_received" value="{{$company->fee_received}}" name="fee_received" placeholder="قیمت">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-7 d-flex align-items-center justify-content-around">

                <div class="form-check">
                    <input disabled class="form-check-input disabled" value="0" type="checkbox" id="plan_menu" @if($company->plan_menu) checked @endif name="plan_menu">
                    <label class="form-check-label" for="plan_menu">
                        منو
                    </label>
                </div>


                <div class="form-check">
                    <input disabled class="form-check-input disabled" value="0" type="checkbox" id="plan_order_taker" @if($company->plan_order_taker) checked @endif name="plan_order_taker">
                    <label class="form-check-label" for="plan_order_taker">
                        سفارشگیر
                    </label>
                </div>


                <div class="form-check">
                    <input disabled class="form-check-input disabled" value="0" type="checkbox" id="plan_time_report" @if($company->plan_time_report) checked @endif name="plan_time_report">
                    <label class="form-check-label" for="plan_time_report">
                        گزارشگیر
                    </label>
                </div>


                <div class="form-check">
                    <input disabled class="form-check-input disabled" value="0" type="checkbox" id="plan_online_order" @if($company->plan_online_order) checked @endif name="plan_online_order">
                    <label class="form-check-label" for="plan_online_order">
                        سفارشگیر آنلاین
                    </label>
                </div>


                <div class="form-check">
                    <input disabled class="form-check-input disabled" value="0" type="checkbox" id="plan_printer_control" @if($company->plan_printer_control) checked @endif name="plan_printer_control">
                    <label class="form-check-label" for="plan_printer_control">
                        پرینتر
                    </label>
                </div>


                <div class="form-check">
                    <input disabled class="form-check-input disabled" value="0" type="checkbox" id="plan_preparation_notification" @if($company->plan_preparation_notification) checked @endif name="plan_preparation_notification">
                    <label class="form-check-label" for="plan_preparation_notification">
                        اطلاع رسانی
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">شماره تلفن کافه</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="phone" value="{{$company->phone}}" name="phone" placeholder="شماره تلفن کافه">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">شماره تلفن مدیر</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="phone_boss" value="{{$company->phone_boss}}" name="phone_boss" placeholder="شماره تلفن مدیر">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">شماره تلفن نماینده /بازاریاب</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="phone_representative" value="{{$company->phone_representative}}" name="phone_representative" placeholder="شماره تلفن نماینده /بازاریاب">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="label">آدرس کافه</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="address" value="{{$company->address}}"  name="address" placeholder="آدرس کافه">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="label">استان</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="state" value="{{$company->state}}" name="state" placeholder="استان">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="label">شهر</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="city" value="{{$company->city}}" name="city" placeholder="شهر">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="label">کد پستی</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="zip" value="{{$company->zip}}" name="zip" placeholder="کد پستی" >
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">طول جغرافیایی</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="long" value="{{$company->long}}" name="long"  >
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label">عرض جغرافیایی</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="lat" value="{{$company->lat}}" name="lat"  >
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div id="map" class="w-100 h-100"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">شماره تلفن عمومی</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="sm_tel" value="{{$company->sm_tel}}" name="sm_tel" placeholder="شماره تلفن عمومی">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">آیدی اینستاگرام</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="sm_instagram" value="{{$company->sm_instagram}}" name="sm_instagram" placeholder="آیدی اینستاگرام">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label class="label">آیدی تلگرام</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="sm_telegram" value="{{$company->sm_telegram}}" name="sm_telegram" placeholder="آیدی تلگرام">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label class="label">آیدی واتسآپ</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="sm_whatsapp" value="{{$company->sm_whatsapp}}" name="sm_whatsapp" placeholder="آیدی واتسآپ">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label class="label">آیدی تویتر</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="sm_twitter" value="{{$company->sm_twitter}}" name="sm_twitter" placeholder="آیدی تویتر">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label class="label">آیدی تردز</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="sm_threads" value="{{$company->sm_threads}}" name="sm_threads" placeholder="آیدی تردز">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label class="label">وبسایت</label>
                    <div class="form-group position-relative">
                        <input disabled type="text" class="form-control text-dark ps-5 h-58" id="sm_website" value="{{$company->sm_website}}" name="sm_website" placeholder="وبسایت">
                        <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">

            <div class="form-group">
                <label class="label">لوگو</label>

                        <img src="{{asset('storage/'.$company->image)}}" class="img-thumbnail "  alt="This is company logo">
                </div>

        </div>
@endsection
@section('js')
    <script !src="">
        var map = L.map('map').setView([32.4279, 53.6880], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);
        var marker;
        //

            var lat = $('#lat').val();
            var lng = $('#long').val();

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);
      </script>
@endsection
