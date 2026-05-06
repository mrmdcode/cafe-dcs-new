{{-- Edit Customer Modal--}}
<div class="modal fade" id="customer_edit_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editCustomerForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">ویرایش اطلاعات مشتری</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>

                <div class="modal-body">
                    {{-- Hidden ID field --}}
                    <input type="hidden" id="edit_customer_id" name="customer_id">

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="edit_customer_name" class="form-label">نام کامل</label>
                        <input type="text" class="form-control" id="edit_customer_name" name="name" required>
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label for="edit_customer_phone" class="form-label">شماره تلفن</label>
                        <input type="text" class="form-control" id="edit_customer_phone" name="phone" required>
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label for="edit_customer_address" class="form-label">آدرس</label>
                        <textarea class="form-control" id="edit_customer_address" name="address" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-warning text-white">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
