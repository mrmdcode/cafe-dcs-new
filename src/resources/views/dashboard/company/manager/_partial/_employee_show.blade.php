<!-- Modal -->
<div class="modal fade" id="company_show" tabindex="-1" aria-labelledby="create_company_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="company_show_label"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">نام</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="name" name="name" placeholder="نام ">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">نام خانوادگی</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="family" name="family" placeholder="نام خانوادگی">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-4">
                            <label class="label">* فعالیت</label>
                            <div class="form-group position-relative">
                                <select disabled class="form-select form-control ps-5 h-58" name="position" tas-data-modal="position" aria-label="Default select example">
                                    <option value="cashier" class="text-dark">صندوقدار</option>
                                    <option value="order_recipient" class="text-dark">سفارش گیرنده</option>
                                    <option value="preparation" class="text-dark">باریستا/آشپز</option>
                                    <option value="waiter" class="text-dark">گارسون</option>
                                </select>
                                <i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-4">
                            <label class="label"> * نوع فعالیت</label>
                            <div class="form-group position-relative">
                                <select disabled class="form-select form-control ps-5 h-58" name="work_status" tas-data-modal="work_status" aria-label="Default select example">
                                    <option value="temporary_employment" class="text-dark">قراردادی دائم</option>
                                    <option value="permanent_employment" class="text-dark">قراردادی موقت</option>
                                    <option value="dismissal" class="text-dark">اخراج</option>
                                    <option value="suspension" class="text-dark">تعلیق</option>
                                    <option value="contract" class="text-dark">قراردادی</option>
                                    <option value="contractor" class="text-dark">پیمانکار</option>
                                </select>
                                <i class="ri-font-size position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">سن</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="age" name="age" placeholder="سن">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">ایمیل</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="email" name="email" placeholder="سن">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">شماره تلفن</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="phone_number" name="phone_number" placeholder="شماره تلفن">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">آیپی ورود به سامانه</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="static_ip" name="static_ip" placeholder="ip ورود به سامانه">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">تلگرام ID</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="telegram_id" name="telegram_id" placeholder="ID تلگرام">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">شماره تلگرام </label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="telegram_phone" name="telegram_phone" placeholder=" شماره تلگرام">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">کد ملی *</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="national_id" name="national_id" placeholder="ک  ملی">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">استان</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="state" name="state" placeholder="استان">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">شهر</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="city" name="city" placeholder="شهر">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label class="label">آدرس</label>
                            <div class="form-group position-relative">
                                <input disabled type="text" class="form-control text-dark ps-5 h-58" tas-data-modal="address" name="address" placeholder="آدرس">
                                <i class="ri-user-line position-absolute top-50 start-0 translate-middle-y fs-20 text-gray-light ps-20"></i>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger text-white btn-block" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>
