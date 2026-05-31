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
                    <h4>میز ها</h4>
                </div>
                <div class="card-body">
                    <table class="table bg-white table-hover table-striped table-bordered">
                        <thead class="">
                        <th>#</th>
                        <th>نام</th>
                        <th>توضیحات</th>
                        <th>ظرفیت</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        @php @endphp
                        @forelse($tables as $i =>$item )
                            <tr class=" text-center">
                                <td>{{$i+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->capacity}}</td>

                                <td>

                                    <a href="{{route('company.table.destroy',$item->id)}}" class="btn btn-outline-danger">حذف</a>
                                    <a href="{{route('company.table.show',$item->id)}}" class="btn btn-outline-danger">ویرایش</a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td  class="d-flex justify-content-center">هیچ میزی ثبت نشده</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <form @if($is_update) action="{{route('company.table.update',$is_update->id)}}" @else action="{{route('company.table.store')}}" @endif method="post" class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>ایجاد</h4>
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
                                <label class="label">توضیحات</label>
                                <div class="form-group position-relative">
                                    <input type="text" class="form-control text-dark ps-5 h-58" id="description" name="description" @if(!empty($is_update))  value="{{$is_update->description}}" @endif placeholder="توضیحات">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label class="label">ظرفیت</label>
                                <div class="form-group position-relative">
                                    <input type="number" class="form-control text-dark ps-5 h-58" id="capacity" name="capacity" @if(!empty($is_update))  value="{{$is_update->capacity}}" @endif placeholder="ظرفیت">
                                    <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
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
