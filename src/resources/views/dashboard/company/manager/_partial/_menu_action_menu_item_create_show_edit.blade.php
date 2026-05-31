<!-- Modal -->
<div class="modal fade" id="create_menu_item" tabindex="-1" aria-labelledby="create_menu_item_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{route('company.menu_item.store')}}" method="post" enctype="multipart/form-data">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_menu_item_label">افزودن منو</h1>
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
                    <div class="col-lg-12">
                        <div class="form-group mb-4">
                            <label class="label"> توضیحات لاتین</label>
                            <div class="form-group position-relative">
                                <textarea class="form-control ps-5 text-dark" name="description_en" id="description_en" placeholder="چند متن دمو ... " cols="30" rows="5"></textarea>
                                <i class="ri-information-line position-absolute top-0 start-0 fs-20 text-gray-light ps-20 pt-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="label">تام آماده سازی(دقیقه)</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="rost_time" name="rost_time" placeholder="تایم آماده">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-4">
                            <label class="label">دسته بندی</label>
                            <div class="form-group position-relative">
                                <select class="form-select form-control ps-5 h-58" name="category_id" id="category_id" aria-label="Default select example">
                                   @forelse($category as $i => $item)
                                    <option selected value="{{$item->id}}"  class="text-dark">{{$item->name}}</option>

                                    @empty
                                    <option selected  class="text-dark">پرینتری وجود ندارد ، ثبت کنید .</option>

                                   @endforelse
                                </select>
                                <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-4">
                            <label class="label">منو</label>
                            <div class="form-group position-relative">
                                <select class="form-select form-control ps-5 h-58" name="menu_id" id="menu_id" aria-label="Default select example">
                                    @forelse($menu as $i => $item)
                                        <option selected value="{{$item->id}}"  class="text-dark">{{$item->name}}</option>

                                    @empty
                                        <option selected  class="text-dark">منویی وجود ندارد ، ثبت کنید .</option>

                                    @endforelse
                                </select>
                                <i class="ri-map-2-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-4">
                            <label class="label">پرینتر</label>
                            <div class="form-group position-relative">
                                <select class="form-select form-control ps-5 h-58" name="printer_id" id="printer_id" aria-label="Default select example">
                                    @forelse($printer as $i => $item)
                                        <option selected value="{{$item->id}}"  class="text-dark">{{$item->name}}</option>

                                    @empty
                                        <option selected  class="text-dark">منویی وجود ندارد ، ثبت کنید .</option>

                                    @endforelse
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


                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="label">قیمت (تومان)</label>
                            <div class="form-group position-relative">
                                <input type="text" class="form-control text-dark ps-5 h-58" id="price" name="price" placeholder="قیمت">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 " id="parent_image">

                        <div class="form-group mb-4">
                            <label class="label">عکس</label>
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
                    <div class="col-md-12">
                        <img src="" alt="" id="image-pan">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">بستن</button>
                <button type="submit" class="btn btn-primary text-white" id="create_menu_item_submit">ایجاد</button>
                <button type="button" class="btn btn-primary text-white d-none" id="create_menu_item_edit">ویرایش</button>
            </div>
        </form>
    </div>
</div>
