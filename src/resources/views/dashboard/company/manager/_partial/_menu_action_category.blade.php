<div class="card"202>
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4>دسته بندی ها</h4>
        <button class="btn btn-warning text-light py-2 px-4 text-white fw-semibold" data-bs-toggle="modal" data-bs-target="#create_category">افزودن</button>
    </div>
    <div class="card-body">
        <table class="table bg-white table-hover table-striped table-bordered">

            <thead class="">
            <th>#</th>
            <th>نام</th>
            <th>نام (لاتین)</th>
            <th>تعداد محصولین</th>
            <th>#</th>
            </thead>
            <tbody>
            @php @endphp
            @forelse($category as $i =>$item )
                <tr class=" text-center">
                    <td>{{$i+1}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->name_en}}</td>
                    <td>{{$item->MenuItem()->count()}}</td>
                    <td class="d-flex justify-content-around">
                        <button tas-view="{{route('company.category.show',$item->id)}}" tas-update="{{route('company.category.update',$item->id)}}" onclick="view(this.getAttribute('tas-view'),this.getAttribute('tas-update'))" class="btn btn-outline-primary">نمایش</button>
                        <button tad-data="{{$item->id}}" onclick="btn_delete('category_delete_form_',this.getAttribute('tad-data'),'دسته بندی')" class="btn btn-outline-danger">حذف</button>
                        <form action="{{route('company.category.destroy',$item->id)}}" id="category_delete_form_{{$item->id}}" method="post">
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
