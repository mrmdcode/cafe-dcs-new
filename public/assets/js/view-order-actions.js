(function () {
    'use strict';

    //  State
    var currentOrder = null; // holds the last fetched order object

    // DOM refs (resolved after DOMContentLoaded)
    var modal, modalTitle, tbody, elDiscount, elTax, elTotal, btnPrint;

    //  Helpers
    function fmt(n) {
        return Number(n || 0).toLocaleString('fa-IR');
    }

    // Populate modal with order data
    function populateModal(order) {
        currentOrder = order;

        // Title
        modalTitle.textContent = 'سفارش #' + order.id +
            (order.customer ? ' – ' + order.customer.name : '');

        // Items
        tbody.innerHTML = '';
        var items = order.menu_item || [];
        var itemTotal = 0;

        items.forEach(function (item, i) {
            var per = Number(item.pivot.per || 0);
            var qty = Number(item.pivot.qty || 0);
            var line = per * qty;
            itemTotal += line;

            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td>' + (i + 1) + '</td>' +
                '<td>' + item.name + '</td>' +
                '<td>' + qty + '</td>' +
                '<td>' + fmt(per) + '</td>' +
                '<td>' + fmt(line) + '</td>';
            tbody.appendChild(tr);
        });

        // Totals
        var discount = Number(order.discount || 0);
        var tax = Number(order.tax || 0);
        var total = itemTotal - discount + tax;

        elDiscount.textContent = fmt(discount);
        elTax.textContent = fmt(tax);
        elTotal.textContent = fmt(total);
    }

    // Build customer receipt HTML
    function buildReceipt(order) {
        var items = order.menu_item || [];
        var itemTotal = 0;

        var rows = items.map(function (item, i) {
            var per = Number(item.pivot.per || 0);
            var qty = Number(item.pivot.qty || 0);
            var line = per * qty;
            itemTotal += line;

            return '<tr>' +
                '<td style="border:1px solid #000;padding:2px 4px;">' + (i + 1) + '</td>' +
                '<td style="border:1px solid #000;padding:2px 4px;">' + item.name + '</td>' +
                '<td style="border:1px solid #000;padding:2px 4px;text-align:center;">' + qty + '</td>' +
                '<td style="border:1px solid #000;padding:2px 4px;text-align:left;">' + fmt(per) + '</td>' +
                '<td style="border:1px solid #000;padding:2px 4px;text-align:left;">' + fmt(line) + '</td>' +
                '</tr>';
        }).join('');

        var discount = Number(order.discount || 0);
        var tax = Number(order.tax || 0);
        var total = itemTotal - discount + tax;

        var now = new Date();
        var printTime = now.toLocaleTimeString('fa-IR');
        var printDate = now.toLocaleDateString('fa-IR');
        var tableName = (order.table ? order.table.name : '–');
        var custName = (order.customer ? order.customer.name : '–');

        return '<div style="width:270px;direction:rtl;font-family:Tahoma,sans-serif;font-size:12px;">' +

            // Header
            '<div style="text-align:center;border-bottom:1px dashed #000;padding-bottom:6px;margin-bottom:6px;">' +
            '<strong style="font-size:15px;">فاکتور مشتری</strong><br>' +
            'شماره سفارش : ' + order.id + '<br>' +
            'میز : ' + tableName + ' | مشتری : ' + custName + '<br>' +
            printDate + ' &nbsp; ' + printTime +
            '</div>' +

            // Items table
            '<table style="width:100%;border-collapse:collapse;">' +
            '<thead>' +
            '<tr style="background:#f0f0f0;">' +
            '<th style="border:1px solid #000;padding:2px 4px;">#</th>' +
            '<th style="border:1px solid #000;padding:2px 4px;">آیتم</th>' +
            '<th style="border:1px solid #000;padding:2px 4px;">تعداد</th>' +
            '<th style="border:1px solid #000;padding:2px 4px;">قیمت</th>' +
            '<th style="border:1px solid #000;padding:2px 4px;">جمع</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' + rows + '</tbody>' +
            '</table>' +

            // Totals
            '<div style="margin-top:8px;border-top:1px dashed #000;padding-top:6px;">' +
            '<div style="display:flex;justify-content:space-between;"><span>جمع اقلام :</span><span>' + fmt(itemTotal) + '</span></div>' +
            '<div style="display:flex;justify-content:space-between;"><span>تخفیف :</span><span>' + fmt(discount) + '</span></div>' +
            '<div style="display:flex;justify-content:space-between;"><span>مالیات :</span><span>' + fmt(tax) + '</span></div>' +
            '<div style="display:flex;justify-content:space-between;font-weight:bold;font-size:14px;margin-top:4px;">' +
            '<span>مبلغ کل :</span><span>' + fmt(total) + '</span>' +
            '</div>' +
            '</div>' +

            // Footer
            '<div style="text-align:center;margin-top:10px;font-size:11px;border-top:1px dashed #000;padding-top:6px;">' +
            'با تشکر از خرید شما' +
            '</div>' +
            '</div>';
    }

    // Print via QZ Tray
    function printOrder() {
        if (!currentOrder) return;

        btnPrint.disabled = true;
        btnPrint.textContent = 'در حال اتصال...';

        window.QZPrinter.getConnection()
            .then(function (printerName) {
                var config = qz.configs.create(printerName);
                console.log(config);

                var data = [{
                    type: 'pixel',
                    format: 'html',
                    flavor: 'plain',
                    data: buildReceipt(currentOrder),
                }];
                return qz.print(config, data);
            })
            .then(function () {
                btnPrint.textContent = 'پرینت شد ✓';
                setTimeout(function () {
                    btnPrint.disabled = false;
                    btnPrint.textContent = 'پرینت';
                }, 2000);
            })
            .catch(function (e) {
                alert('خطا در پرینت:\n' + e);
                btnPrint.disabled = false;
                btnPrint.textContent = 'پرینت';
            });
    }

    // Fetch order and open modal
    function openOrderModal(orderId, orderKey) {
        fetch('/api/company/orders/' + orderId, {
            credentials: 'include',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="x-csrf-token"]').content
            }
        })
            .then(function (r) {
                if (r.status === 401) throw new Error('خطای احراز هویت');
                if (!r.ok) throw new Error('خطا در دریافت اطلاعات سفارش');
                return r.json();
            })
            .then(function (order) {
                populateModal(order);
                var bsModal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('view_order_modal')
                );
                bsModal.show();
            })
            .catch(function (e) {
                alert(e.message || e);
            });
    }

    // Boot
    document.addEventListener('DOMContentLoaded', function () {

        // Resolve DOM refs
        modal = document.getElementById('view_order_modal');
        modalTitle = document.getElementById('view_order_modal_label');
        tbody = modal.querySelector('tbody.items');
        elDiscount = document.getElementById('discount');
        elTax = document.getElementById('tax');
        elTotal = document.getElementById('total_all');
        btnPrint = document.getElementById('print');

        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.view-btn');
            if (!btn) return;
            openOrderModal(btn.dataset.id, btn.dataset.key);
        });

        // Print button inside modal
        btnPrint.addEventListener('click', printOrder);
    });

}());
