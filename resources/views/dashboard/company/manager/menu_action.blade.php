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

        <div class="col-lg-12">

            <div class="card bg-white border-0 rounded-10 mb-4">
                <div class="card-body p-4">
                    <h4 class="fs-18 mb-4">سیستم منو</h4>
                    <ul class="nav nav-tabs mb-4" id="myTab2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="preview2-tab" data-bs-toggle="tab" data-bs-target="#category_tab" type="button" role="tab" aria-controls="preview2-tab-pane" aria-selected="true">دسته بندی</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="code2-tab" data-bs-toggle="tab" data-bs-target="#menu_tab" type="button" role="tab" aria-controls="code2-tab-pane" aria-selected="false" tabindex="-1">منو</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="code2-tab" data-bs-toggle="tab" data-bs-target="#menu_item_tab" type="button" role="tab" aria-controls="code2-tab-pane" aria-selected="false" tabindex="-1">منو آیتم</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade active show" id="category_tab" role="tabpanel" aria-labelledby="preview2-tab" tabindex="0">
                            @include('dashboard.company.manager._partial._menu_action_category')
                        </div>
                        <div class="tab-pane fade" id="menu_tab" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                            @include('dashboard.company.manager._partial._menu_action_menu')
                        </div>
                        <div class="tab-pane fade" id="menu_item_tab" role="tabpanel" aria-labelledby="code2-tab" tabindex="0">
                            @include('dashboard.company.manager._partial._menu_action_menu_item')
                        </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>






    @include('dashboard.company.manager._partial._menu_action_category_create_show_edit')
    @include('dashboard.company.manager._partial._menu_action_menu_create_show_edit')
    @include('dashboard.company.manager._partial._menu_action_menu_item_create_show_edit')


@endsection
@section('js')
    <script>
        const view = async (tas_view,tas_update) => {
            await fetch(tas_view,{
                headers : {
                    'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content'),
                    'Content-Type' : 'application/json',
                    'Accept' : "application/json"
                }
            }).then(res => res.json())
                .then((res)=>{
                    console.log(res)
                    $('#create_category input').attr('disabled','disabled')
                    $('#create_category input#name').val(res.category.name);
                    $('#create_category .modal-body').append('<input type="hidden" name="_method" value="put" disabled="disabled">');
                    $('#create_category .modal-content').attr('action',tas_update);
                    $('#create_category input#name_en').val(res.category.name_en);
                    $('#create_category_edit').removeClass('d-none');
                    $('#create_category_submit').addClass('d-none');
                    $('#create_category_edit').attr('onclick',"edit_category()");
                  $('#create_category_label').text("نمایش دسته بندی");
                    $('#create_category').modal('show');
                })
            // console.log(response)

        }
        const edit_category = () => {
            $('#create_category_edit').addClass('d-none');
            $('#create_category_submit').removeClass('d-none');
            $('#create_category_submit').text('بروزرسانی');
            $('#create_category_label').text("ویرایش دسته بندی");
            $('#create_category input').removeAttr('disabled')
        }

        const view_menu = async (tas_view,tas_update) => {
            await fetch(tas_view,{
                headers : {
                    'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content'),
                    'Content-Type' : 'application/json',
                    'Accept' : "application/json"
                }
            }).then(res => res.json())
                .then((res)=>{
                    console.log(res)
                    $('#create_menu input').attr('disabled','disabled')
                    $('#create_menu textarea').attr('disabled','disabled')
                    $('#create_menu select').attr('disabled','disabled')
                    $('#create_menu input#name').val(res.menu.name);
                    $('#create_menu input#name_en').val(res.menu.name_en);
                    $('#create_menu textarea#description').val(res.menu.description);
                    $('#create_menu select#show_customer').val(res.menu.show_customer).change();
                    $('#create_menu select#show_order_recipient').val(res.menu.show_order_recipient).change();
                    $('#create_menu .modal-body').append('<input type="hidden" name="_method" value="put" disabled="disabled">');
                    $('#create_menu .modal-content').attr('action',tas_update);
                    $('#create_menu_edit').removeClass('d-none');
                    $('#create_menu_submit').addClass('d-none');
                    $('#create_menu_edit').attr('onclick',"edit_menu()");
                    $('#create_menu_label').text("نمایش منو ");
                    $('#create_menu').modal('show');
                })
            // console.log(response)

        }
        const edit_menu = () => {
            $('#create_menu_edit').addClass('d-none');
            $('#create_menu_submit').removeClass('d-none');
            $('#create_menu_submit').text('بروزرسانی');
            $('#create_menu_label').text("ویرایش منو");
            $('#create_menu input').removeAttr('disabled')
            $('#create_menu textarea').removeAttr('disabled')
            $('#create_menu select').removeAttr('disabled')
        }
        const view_menu_item = async (tas_view,tas_update) => {
            await fetch(tas_view,{
                headers : {
                    'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content'),
                    'Content-Type' : 'application/json',
                    'Accept' : "application/json"
                }
            }).then(res => res.json())
                .then((res)=>{
                    console.log(res)
                    $('#create_menu_item input').attr('disabled','disabled')
                    $('#create_menu_item textarea').attr('disabled','disabled')
                    $('#create_menu_item select').attr('disabled','disabled')
                    $('#create_menu_item input#name').val(res.menu_item.name);
                    $('#create_menu_item input#name_en').val(res.menu_item.name_en);
                    $('#create_menu_item textarea#description').val(res.menu_item.description);
                    $('#create_menu_item textarea#description').val(res.menu_item.description_en);
                    $('#create_menu_item input#price').val(res.menu_item.price);
                    $('#create_menu_item input#rost_time').val(res.menu_item.rost_time);
                    $('#create_menu_item img#image-pan').attr('src',$('meta[name="base-url"]').attr('content')+'/storage/'+res.menu_item.image);
                    $('#create_menu_item select#menu_id').val(res.menu_item.menu_id).change();
                    $('#create_menu_item select#category_id').val(res.menu_item.category_id).change();
                    $('#create_menu_item select#printer_id').val(res.menu_item.printer_id).change();
                    $('#create_menu_item select#show_customer').val(res.menu_item.show_customer).change();
                    $('#create_menu_item select#show_order_recipient').val(res.menu_item.show_order_recipient).change();
                    $('#create_menu_item .modal-body').append('<input type="hidden" name="_method" value="put" disabled="disabled">');
                    $('#create_menu_item .modal-content').attr('action',tas_update);
                    $('#create_menu_item_edit').removeClass('d-none');
                    $('#create_menu_item_submit').addClass('d-none');
                    $('#parent_image').addClass('d-none');
                    $('#create_menu_item_edit').attr('onclick',"edit_menu_item()");
                    $('#create_menu_item_label').text("نمایش منو ");
                    $('#create_menu_item').modal('show');
                })
            // console.log(response)

        }
        const edit_menu_item = () => {
            $('#create_menu_item_edit').addClass('d-none');
            $('#create_menu_item_submit').removeClass('d-none');
            $('#create_menu_item img#image-pan').addClass('d-none')
            $('#parent_image').removeClass('d-none');
            $('#create_menu_item_submit').text('بروزرسانی');
            $('#create_menu_item_label').text("ویرایش آیتم");
            $('#create_menu_item input').removeAttr('disabled')
            $('#create_menu_item textarea').removeAttr('disabled')
            $('#create_menu_item select').removeAttr('disabled')
        }
        const btn_delete = (item,id,name) => {
            Swal.fire({
                title: `آیا مایل به حذف ${name} هستید .`,
                text: `بعد از حذف دیگر به محتوای ${name} دسترسی ندارید .`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "بله ،حذف شود ."
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#${item}${id}`).submit();
                }
            });
        }

        $('#menu_select').on('change',()=>{
            console.log($('#menu_select').val())
            $('#table_menu_item').children().addClass('d-none')
            if($('#menu_select').val() == "#"){
                $('#table_menu_item').children().removeClass('d-none')
            }
            else {
                $(`#table_menu_item tr[menu-id="${$('#menu_select').val()}"]`).removeClass('d-none')

            }
        })
    </script>
@endsection
