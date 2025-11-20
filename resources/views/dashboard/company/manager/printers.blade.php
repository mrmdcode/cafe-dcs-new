@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="@if(session('status') == 'success')alert alert-success @elseif(session('status') == 'error')alert alert-danger @endif col-11">
            <div class="alert-body ">{{session('message')}}</div>
        </div>

        <div class="col-9">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>پرینتر ها</h4>
                </div>
                <div class="card-body">
                    <table class="table bg-white table-hover table-striped table-bordered">
                        <thead class="">
                        <th>#</th>
                        <th>نام</th>
                        <th>آدرس داخلی</th>
                        <th>صندوق</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        @php @endphp
                        @forelse($printers as $i =>$item )
                            <tr class=" text-center">
                                <td>{{$i+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->local_address}}</td>
                                <td>
                                    @if($item->cashier)
                                    ✅
                                    @else
                                        ❌
                                    @endif
                                </td>

                            <td>

                                <button  onclick="$('#fmd_{{$item->id}}').submit()" class="btn btn-outline-danger">حذف</button>
                                <a href="{{route('company.printer.show',$item->id)}}" class="btn btn-outline-danger">ویرایش</a>
                            </td>

                                <form action="{{route('company.printer.destroy',$item->id)}}" method="post" id="fmd_{{$item->id}}">
                                    @csrf
                                    @method('delete')
                                </form>

                            </tr>
                        @empty
                            <tr>
                                <td  class="d-flex justify-content-center">هیچ پرینتری ثبت نشده</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <form @if($is_update) action="{{route('company.printer.update',$is_update->id)}}" @else action="{{route('company.printer.store')}}" @endif method="post" class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>پرینتر ها</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="label">نام</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="name" name="name" @if(!empty($is_update)) value="{{$is_update->name}}"@endif placeholder="نام ">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="label">آدرس داخلی</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="local_address" name="local_address" @if(!empty($is_update))  value="{{$is_update->local_address}}" @endif placeholder="آدرس داخلی ">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="label">صندوق</label>
                                <div class="form-group position-relative">
                                    <select class="form-select form-control ps-5 h-58" name="cashier" id="cashier" aria-label="Default select example">
                                       @if(!empty($is_update))
                                            @if($is_update->cashier)
                                                <option value="1" selected class="text-dark">صندوق</option>
                                                <option value="0" class="text-dark">سایر</option>
                                            @else
                                                <option value="1" class="text-dark">صندوق</option>
                                                <option value="0" selected class="text-dark">سایر</option>
                                            @endif
                                        @else
                                            <option value="1" class="text-dark">صندوق</option>
                                            <option value="0" selected class="text-dark">سایر</option>
                                       @endif
                                    </select>
                                    <i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if($is_update)
                                @method('put')
                            <button class="btn btn-primary btn-block">ویرایش</button>
                            @else
                            <button class="btn btn-success btn-block">ثبت</button>

                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row mt-2">
        <div class=""></div>
        <div class="card col-9 bg-white border-0 rounded-10 mb-4">
            <div class="card-body p-4">
                <h3 class="fs-18 mb-4 border-bottom pb-20 mb-20">متا دیتا</h3>
                دانلود کلید اختصاصی (private key) برای نرم افزار QZ Tray و اتصال به پرینتر ها
                <br>
                <a href="#" class="btn btn-success mt-4 text-white">دانلود</a>
            </div>
        </div>
    </div>



    @include('dashboard.company.manager._partial._employee_create')
    @include('dashboard.company.manager._partial._employee_show')


@endsection
@section('js')
    <script>
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
