<!-- Modal -->
<div class="modal fade" id="create_menu" tabindex="-1" aria-labelledby="create_menu_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{route('company.menu.store')}}" method="post" enctype="multipart/form-data">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_menu_label">افزودن منو</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">نام فارسی</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="name" name="name" placeholder="نام فارسی">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">نام لاتین</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="name_en" name="name_en" placeholder="نام لاتین">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-4">
                            <label class="label">توضیحات</label>
                            <div class="form-group position-relative">
                                <textarea class="form-control ps-5 text-dark" name="description" id="description" placeholder="چند متن دمو ... " cols="30" rows="5"></textarea>
                                <i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-4">
                            <label class="label">تمایش در منو</label>
                            <div class="form-group position-relative">
                                <select class="form-select form-control ps-5 h-58" name="show_customer" id="show_customer" aria-label="Default select example">
                                    <option selected value="1" class="text-dark">فعال</option>
                                    <option value="0" class="text-dark">غیر فعال</option>

                                </select>
                                <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-4">
                            <label class="label">تمایش در سفارشگیر</label>
                            <div class="form-group position-relative">
                                <select class="form-select form-control ps-5 h-58" name="show_order_recipient" id="show_order_recipient" aria-label="Default select example">
                                    <option selected value="1" class="text-dark">فعال</option>
                                    <option value="0" class="text-dark">غیر فعال</option>

                                </select>
                                <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">بستن</button>
                <button type="submit" class="btn btn-primary text-white" id="create_menu_submit">ایجاد</button>
                <button type="button" class="btn btn-primary text-white d-none" id="create_menu_edit">ویرایش</button>
            </div>
        </form>
    </div>
</div>
