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

        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>پرسنل</h4>
                    <button class="btn btn-warning text-light py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#create_company">افزودن</button>
                </div>
                <div class="card-body">
                    <table class="table bg-white table-hover table-striped table-bordered">
                        <thead class="">
                        <th>#</th>
                        <th>نام فامیل ,..</th>
                        <th>ایمیل</th>
                        <th>آدرس</th>
                        <th>شماره تلفن</th>
                        <th>فعالیت</th>
                        <th>نوع همکاری</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        @php @endphp
                        @forelse($employees as $i =>$employee )
                            <tr class=" text-center">
                                <td>{{$i+1}}</td>
                                <td>{{$employee->name}} - {{$employee->family}} - {{$employee->age}}</td>
                                <td>{{$employee->email}}</td>
                                <td>{{$employee->state}} - {{$employee->city}} - {{$employee->address}}</td>
                                <td>{{$employee->phone_number}}</td>
                                <td>
                                    @switch($employee->position)
                                        @case("cashier")
                                             <span> صندوقدار </span>
                                            @break
                                        @case("order_recipient")
                                             <span> سفارش گیرنده </span>
                                            @break
                                        @case("preparation")
                                             <span> آشپز / باریستا </span>
                                            @break
                                        @case("waiter")
                                             <span> گارسون </span>
                                            @break
                                        @endswitch
                                </td>
                                <td>
                                    @switch($employee->work_status)
                                        @case("temporary_employment")
                                             <span> قراردادی دائم </span>
                                            @break
                                        @case("permanent_employment")
                                             <span> قراردادی دائم </span>
                                            @break
                                        @case("dismissal")
                                             <span> اخراج </span>
                                            @break
                                        @case("suspension")
                                             <span> تعلیق </span>
                                            @break
                                        @case("contract")
                                             <span> قراردادی </span>
                                            @break
                                        @case("contractor")
                                             <span> پیمانکار </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="d-flex justify-content-around">

                                    @if($employee->work_status == 'suspension')
                                        <a href="{{route('company.employee.de_suspension',$employee->id)}}" class="btn btn-success">برگردانندن</a>
                                        <a href="{{route('company.employee.dismissal',$employee->id)}}" class="btn btn-danger">خراج</a>
                                    @else
                                        <a href="{{route('company.employee.suspension',$employee->id)}}" class="btn btn-warning">معلق کردن</a>
                                    @endif
                                    <button data-tas="{{route('company.employee.show',$employee->id)}}" onclick="view(this.getAttribute('data-tas'))" class="btn btn-outline-primary">نمایش</button>
                                    <button data-tas="{{route('company.employee.edit',$employee->id)}}" class="btn btn-outline-warning">ویرایش</button>
                                </td>

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






@include('dashboard.company.manager._partial._employee_create')
@include('dashboard.company.manager._partial._employee_show')


@endsection
@section('js')
    <script>
        const view = async (tas) => {
            await fetch(tas,{
                headers : {
                    'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content'),
                    'Content-Type' : 'application/json',
                    'Accept' : "application/json"
                }
            }).then(res => res.json())
                .then((res)=>{
                    console.log(res)
                    $('input[tas-data-modal="name"]').val(res.employee.name)
                    $('input[tas-data-modal="family"]').val(res.employee.family)
                    $('input[tas-data-modal="age"]').val(res.employee.age)
                    $('input[tas-data-modal="state"]').val(res.employee.state)
                    $('input[tas-data-modal="address"]').val(res.employee.address)
                    $('input[tas-data-modal="city"]').val(res.employee.city)
                    $('input[tas-data-modal="phone_number"]').val(res.employee.phone_number)
                    $('input[tas-data-modal="national_id"]').val(res.employee.national_id)
                    $('input[tas-data-modal="telegram_phone"]').val(res.employee.telegram_phone)
                    $('input[tas-data-modal="telegram_id"]').val(res.employee.telegram_id)
                    $('input[tas-data-modal="static_ip"]').val(res.employee.static_ip)
                    $('input[tas-data-modal="email"]').val(res.employee.email)
                    $('select[tas-data-modal="work_status"]').val(res.employee.work_status).change(); // این خط و خط پایینی هردو برای انتخاب آپشن ها هست
                    console.log($(`select[tas-data-modal="position"] option[value="${res.employee.position}"]`).attr('selected','selected'))
                    $('#company_show_label').text(res.employee.name+' '+res.employee.family);
                    $('#company_show').modal('show');
                })
            // console.log(response)

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
