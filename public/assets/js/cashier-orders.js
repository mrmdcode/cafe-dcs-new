$(function () {
    // ======== VIEW MODAL ========
    $(document).on('click', '.view-btn', function () {
        const id = $(this).data('id');
        const key = $(this).data('key');
        loadViewModal(id, key);
    });

    // ======== STATUS CHANGE (inside view modal) ========
    $('#view_order_modal').on('click', '#paid, #finish', function () {
        const status = $(this).attr('id');  // 'paid' or 'finish'
        const btn = $(this);
        const id = btn.data('id');
        const key = btn.data('key');
        if (!id || !key) return;  // safety
        updateOrderStatus(id, key, status);
    });

    // Send button – update the order (you can implement this later)
    $('#send_btn').on('click', function () {
        alert('Update order not implemented yet');  // placeholder
    });
});

// ----------- Global variables for edit -----------
let orderItems = [];      // current items in the edit order
let _menus = null;        // menus with their items

// ----------- VIEW MODAL -----------
function loadViewModal(id, key) {
    $.get(`/cashier/orders/${id}`)
        .done(function (order) {
            const modal = $('#view_order_modal');
            modal.find('.items').empty();

            let total = 0;
            if (order.menu_item && order.menu_item.length) {
                order.menu_item.forEach((item, i) => {
                    const subtotal = item.pivot.per * item.pivot.qty;
                    total += subtotal;
                    modal.find('.items').append(`
                        <tr>
                            <td>${i + 1}</td>
                            <td>${item.name}</td>
                            <td>${item.pivot.qty}</td>
                            <td>${item.pivot.per}</td>
                            <td>${subtotal}</td>
                        </tr>
                    `);
                });
            }

            // Title
            let label = `سفارش ${order.id}-${order.unique_key}`;
            if (order.customer) label = `سفارش ${order.customer.name} عزیز`;
            else if (order.table) label = `سفارش میز ${order.table.name}`;
            modal.find('.modal-title').text(label);

            // Toggle buttons based on status
            const paidBtn = modal.find('#paid');
            const finishBtn = modal.find('#finish');
            const deleteBtn = modal.find('#delete');

            if (order.status === 'paid') {
                paidBtn.addClass('disabled').attr('disabled', true);
                finishBtn.addClass('disabled').attr('disabled', true);
                deleteBtn.addClass('disabled').attr('disabled', true);
            } else {
                paidBtn.removeClass('disabled').attr('disabled', false);
                finishBtn.removeClass('disabled').attr('disabled', false);
                deleteBtn.removeClass('disabled').attr('disabled', false);
                // Store order id/key on buttons for status updates
                paidBtn.data({ id: order.id, key: order.unique_key });
                finishBtn.data({ id: order.id, key: order.unique_key });
            }

            modal.find('#discount').text(order.discount ?? 0);
            modal.find('#tax').text(0);
            modal.find('#total_all').text(total.toLocaleString());

            modal.modal('show');
        })
        .fail(function (xhr) {
            alert('Error loading order: ' + (xhr.responseJSON?.message || ''));
        });
}

// ----------- STATUS UPDATE -----------
function updateOrderStatus(id, key, newStatus) {
    Swal.fire({
        title: `تغییر وضعیت به ${newStatus === 'paid' ? 'پرداخت شده' : 'اتمام آماده سازی'}؟`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله',
        cancelButtonText: 'خیر',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/cashier/orders/${id}/status`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="x-csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                data: JSON.stringify({ status: newStatus }),
                success: function () {
                    Swal.fire({ icon: 'success', title: 'انجام شد', timer: 1500, showConfirmButton: false });
                    location.reload();  // refresh the whole page to reflect status change
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'خطا',
                        timer: 2000,
                    });
                },
            });
        }
    });
}
