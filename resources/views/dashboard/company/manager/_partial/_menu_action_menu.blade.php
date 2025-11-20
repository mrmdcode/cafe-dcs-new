<div class="card"202>
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4>منو ها</h4>
        <button class="btn btn-warning text-light py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#create_menu">افزودن</button>
    </div>
    <div class="card-body">
        <table class="table bg-white table-hover table-striped table-bordered">

            <thead class="">
            <th>#</th>
            <th>نام</th>
            <th>نام (لاتین)</th>
            <th>توضیحات</th>
            <th>نمایش در منو</th>
            <th>نمایش در سفارشگیر</th>
            <th>تعداد محصولین</th>
            <th>#</th>
            </thead>
            <tbody>
            @php @endphp
            @forelse($menu as $i =>$item )
                <tr class=" text-center">
                    <td>{{$i+1}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->name_en}}</td>
                    <td>{{$item->description}}</td>
                    <td>
                        @if($item->show_customer)
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <td>
                        @if($item->show_order_recipient)
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <td>{{$item->MenuItem()->count()}}</td>
                    <td class="d-flex justify-content-around">
                        <button tas-view="{{route('company.menu.show',$item->id)}}" tas-update="{{route('company.menu.update',$item->id)}}" onclick="view_menu(this.getAttribute('tas-view'),this.getAttribute('tas-update'))" class="btn btn-outline-primary">نمایش</button>
                        <button tad-data="{{$item->id}}" onclick="btn_delete('menu_delete_form_',this.getAttribute('tad-data'),'منو')" class="btn btn-outline-danger">حذف</button>

                        @if($item->show_order_recipient)
                        <a href="{{route('company.menu.sor_hide',$item->id)}}" class="btn btn-outline-warning">عدم نمایش در سفارشگیر</a>

                        @else
                        <a href="{{route('company.menu.sor_show',$item->id)}}" class="btn btn-outline-warning">نمایش در سفارشگیر</a>
                        @endif
                        @if($item->show_customer)
                        <a href="{{route('company.menu.sc_hide',$item->id)}}" class="btn btn-outline-warning">عدم نمایش برای مشتریان</a>
                        @else
                        <a href="{{route('company.menu.sc_show',$item->id)}}" class="btn btn-outline-warning">نمایش برای مشتریان</a>
                        @endif
                        <form action="{{route('company.menu.destroy',$item->id)}}" id="menu_delete_form_{{$item->id}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
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
