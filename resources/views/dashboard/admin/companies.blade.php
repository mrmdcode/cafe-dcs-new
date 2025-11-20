@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.admin._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.admin._partial._topMenu')
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="@if(session('status') == 'success')alert alert-success @elseif(session('status') == 'error')alert alert-danger @endif col-11">
            <div class="alert-body ">{{session('message')}}</div>
        </div>

       <div class="col-12">
           <div class="card">
               <div class="card-header bg-white d-flex justify-content-between align-items-center">
                   <h4>کافه ها</h4>
                   <button class="btn btn-warning text-light py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#create_company">ساخت</button>
               </div>
               <div class="card-body">
                   <table class="table bg-white table-hover table-striped table-bordered">
                       <thead class="">
                           <th>#</th>
                           <th>نام شرکت</th>
                           <th>ظرفیت</th>
                           <th>فعال</th>
                           <th>پلن های خریداری شده</th>
                           <th>تعداد کارکنین</th>
                           <th>مدیریت</th>
                           <th>#</th>
                       </thead>
                       <tbody>
                           @php @endphp
                            @forelse($companies as $i =>$company )
                                <tr class=" text-center">
                                    <td>{{$i+1}}</td>
                                    <td>{{$company->name}}</td>
                                    <td>{{$company->capacity}}</td>
                                    <td>
                                        @if($company->active)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                    </td>
                                    <td>
                                        @if($company->plan_menu)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                        @if($company->plan_order_taker)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                        @if($company->plan_time_report)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                        @if($company->plan_online_order)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                        @if($company->plan_printer_control)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                        @if($company->plan_preparation_notification)
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                    </td>
                                    <td>{{$company->employers()->count() -1}}</td>
                                    <td>{{$company->name_boss}}  {{$company->phone_boss}}</td>
                                    <td class="d-flex justify-content-around">
                                        <form class="d-none" action="{{route('companies.destroy',$company->id)}}" id="del-{{$company->id}}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        @if($company->active)
                                            <a href="{{route('companies.de_active',$company->id)}}" class="btn btn-danger">غیرفعال</a>
                                        @else
                                            <a href="{{route('companies.active',$company->id)}}" class="btn btn-success">فعال</a>
                                        @endif
                                        <a href="{{route('companies.show',$company->id)}}" class="btn btn-outline-primary">نمایش</a>
                                        <a href="{{route('companies.edit',$company->id)}}" class="btn btn-outline-warning">ویرایش</a>
                                        <button onclick="btn_delete(this.getAttribute('action-target'))" action-target="{{$company->id}}" class="btn btn-outline-danger">حذف</button>
                                    </td>
                                    <form action="{{route('companies.destroy',$company->id)}}" id="form_{{$company->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </tr>
                            @empty
                                <tr>
                                    <td  class="d-flex justify-content-center">هیچ کافه های ثبت نشده</td>
                                </tr>
                            @endforelse
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
    </div>






    <!-- Modal -->
    <div class="modal fade" id="create_company" tabindex="-1" aria-labelledby="create_company_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content" action="{{route('companies.store')}}" method="post" enctype="multipart/form-data">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ایجاد کافه</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="label">نام کافه</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="name" name="name" placeholder="نام کافه">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="label">نام کاربری کافه</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="username" name="username" placeholder="نام کاربری کافه">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="label">نام مدیریت کافه</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="name_boss" name="name_boss" placeholder="نام مدیریت کافه">
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
                                            <input type="text" size="25" value="1" name="capacity" class="count"/>
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
                                    <input type="number" class="form-control text-dark ps-5 h-58" id="fee_received" name="fee_received" placeholder="قیمت">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 d-flex align-items-center justify-content-around">

                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="checkbox" id="plan_menu" name="plan_menu">
                                    <label class="form-check-label" for="plan_menu">
                                        منو
                                    </label>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="checkbox" id="plan_order_taker" name="plan_order_taker">
                                    <label class="form-check-label" for="plan_order_taker">
                                        سفارشگیر
                                    </label>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="checkbox" id="plan_time_report" name="plan_time_report">
                                    <label class="form-check-label" for="plan_time_report">
                                        گزارشگیر
                                    </label>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="checkbox" id="plan_online_order" name="plan_online_order">
                                    <label class="form-check-label" for="plan_online_order">
                                        سفارشگیر آنلاین
                                    </label>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="checkbox" id="plan_printer_control" name="plan_printer_control">
                                    <label class="form-check-label" for="plan_printer_control">
                                        پرینتر
                                    </label>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" value="0" type="checkbox" id="plan_preparation_notification" name="plan_preparation_notification">
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
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="phone" name="phone" placeholder="شماره تلفن کافه">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="label">شماره تلفن مدیر</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="phone_boss" name="phone_boss" placeholder="شماره تلفن مدیر">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="label">شماره تلفن نماینده /بازاریاب</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="phone_representative" name="phone_representative" placeholder="شماره تلفن نماینده /بازاریاب">
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
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="address" name="address" placeholder="آدرس کافه">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="label">استان</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="state" name="state" placeholder="استان">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="label">شهر</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="city" name="city" placeholder="شهر">
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
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="zip" name="zip" placeholder="کد پستی" >
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">طول جغرافیایی</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="long" name="long"  >
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">عرض جغرافیایی</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="lat" name="lat"  >
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
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="sm_tel" name="sm_tel" placeholder="شماره تلفن عمومی">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="label">آیدی اینستاگرام</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="sm_instagram" name="sm_instagram" placeholder="آیدی اینستاگرام">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="label">آیدی تلگرام</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="sm_telegram" name="sm_telegram" placeholder="آیدی تلگرام">
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
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="sm_whatsapp" name="sm_whatsapp" placeholder="آیدی واتسآپ">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="label">آیدی تویتر</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="sm_twitter" name="sm_twitter" placeholder="آیدی تویتر">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="label">آیدی تردز</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="sm_threads" name="sm_threads" placeholder="آیدی تردز">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4">
                                <label class="label">وبسایت</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="sm_website" name="sm_website" placeholder="وبسایت">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">

                        <div class="form-group">
                            <label class="label">لوگو</label>
                            <div class="form-control h-100 text-center position-relative p-4 p-lg-5">
                                <div class="product-upload">
                                    <label for="file-upload" class="file-upload mb-0">
                                        <i class="ri-upload-cloud-2-line fs-2 text-gray-light"></i>
                                        <span class="d-block fw-semibold text-body">فایل ها را اینجا رها کنید یا برای آپلود کلیک کنید.</span>
                                    </label>
                                    <input id="file-upload" name="image" type="file">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">بستن</button>
                    <button type="submit" class="btn btn-primary text-white">ایجاد</button>
                </div>
            </form>
        </div>
    </div>



@endsection
@section('js')
    <script>
        var map = L.map('map').setView([32.4279, 53.6880], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);
        var marker;
        //
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById('lat').value = lat;
            document.getElementById('long').value = lng;
        });
        $("input[type='checkbox']").on('change', function() {
            if ($(this).is(':checked')) {
                $(this).attr('value', '1');
            } else {
                $(this).attr('value', '0');
            }


        });

        const btn_actiona = (route) => {

        }
        const btn_delete = (id) => {
            console.log(id)
            Swal.fire({
                title: "آیا مایل به حذف کافه هستید .",
                text: "بعد از حذف دیگر به محتوای کافه دسترسی ندارید .",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "بله ،حذف شود ."
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#form_${id}`).submit();
                    Swal.fire({
                        title: "حذف شد!",
                        text: "کافه در حالت حذف و غیرفعال قرارگرفت.",
                        icon: "success"
                    });
                }
            });
        }
    </script>
@endsection
