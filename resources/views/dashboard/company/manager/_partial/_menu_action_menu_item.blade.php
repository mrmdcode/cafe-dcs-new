<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4>منو آیتم ها</h4>
        <div class="form-group" >
            <div class="form-group position-relative" style="width: 350px;">
                <select class="form-select form-control ps-5 h-58" name="menu_select" id="menu_select" aria-label="Default select example">

                        <option selected value="#" class="text-dark">همه</option>
                    @forelse($menu as $i => $item)
                        <option  value="{{$item->id}}" class="text-dark">{{$item->name}}</option>

                    @empty
                        <option selected  class="text-dark">پرینتری وجود ندارد ، ثبت کنید .</option>

                    @endforelse
                </select>
                <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
            </div>
        </div>
        <button class="btn btn-warning text-light py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#create_menu_item">افزودن</button>

    </div>
    <div class="card-body">
        <table class="table bg-white table-hover table-striped table-bordered">

            <thead class="">
            <th>#</th>
            <th>دسته بندی</th>
            <th>منو</th>
            <th>نام</th>
            <th>نام (لاتین)</th>
            <th>توضیحات</th>
            <th>نمایش در منو</th>
            <th>نمایش در سفارشگیر</th>
            <th>موجود</th>
            <th>عکس</th>
            <th>تایم آماده سازی</th>
            <th>پیرنتر</th>
            <th>#</th>
            </thead>
            <tbody id="table_menu_item">
            @php @endphp
            @forelse($menu_item as $i =>$item )
                <tr class=" text-center" menu-id="{{$item->menu->id}}">
                    <td>{{$i+1}}</td>
                    <td>{{$item->category->name}}</td>
                    <td>{{$item->menu->name}}</td>
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
                    <td>
                        @if($item->active)
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <td>
                        <img src="{{asset('storage/'.$item->image)}}" height="100px" width="350px" alt="{{$item->name}}">
                    </td>
                    <td>{{$item->rost_time}}</td>
                    <td>{{$item->printer->name ?? null}}</td>
                    <td >
                        <div class="row px-2">
                            <button tas-view="{{route('company.menu_item.show',$item->id)}}" tas-update="{{route('company.menu_item.update',$item->id)}}" onclick="view_menu_item(this.getAttribute('tas-view'),this.getAttribute('tas-update'))" class="btn col btn-outline-primary">نمایش</button>
                            <button tad-data="{{$item->id}}" onclick="btn_delete('menu_item_delete_form_',this.getAttribute('tad-data'),'منو')" class="btn col btn-outline-danger">حذف</button>

                            @if($item->show_order_recipient)
                                <a href="{{route('company.menu_item.sor_hide',$item->id)}}" class="btn col btn-outline-warning">عدم نمایش در سفارشگیر</a>

                            @else
                                <a href="{{route('company.menu_item.sor_show',$item->id)}}" class="btn col btn-outline-warning">نمایش در سفارشگیر</a>
                            @endif
                            @if($item->show_customer)
                                <a href="{{route('company.menu_item.sc_hide',$item->id)}}" class="btn col btn-outline-warning">عدم نمایش برای مشتریان</a>
                            @else
                                <a href="{{route('company.menu_item.sc_show',$item->id)}}" class="btn col btn-outline-warning">نمایش برای مشتریان</a>
                            @endif
                            @if($item->active)
                                <a href="{{route('company.menu_item.de_active',$item->id)}}" class="btn col btn-outline-warning">عدم موجودی</a>
                            @else
                                <a href="{{route('company.menu_item.active',$item->id)}}" class="btn col btn-outline-warning">موجود سازی</a>
                            @endif
                            <form action="{{route('company.menu_item.destroy',$item->id)}}" id="menu_item_delete_form_{{$item->id}}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </div>
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
