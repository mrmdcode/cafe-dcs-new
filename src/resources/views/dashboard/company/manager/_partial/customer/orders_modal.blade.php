{{-- Show Customers Orders Modal --}}
<div class="modal fade" id="customer_orders_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="customer_orders_label">سفارش‌های مشتری</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>

            <div class="modal-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>شماره سفارش</th>
                            <th>مبلغ کل</th>
                            <th>تاریخ ثبت</th>
                        </tr>
                    </thead>
                    <tbody id="customer_orders_tbody">
                        {{-- Rows injected by JavaScript --}}
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>
