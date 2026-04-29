let adminData = {
    menus: [],
    tables: [],
    orders: []
};

document.getElementById('openAdminOrderModal')?.addEventListener('click', async () => {

    resetForm();
    $('#add_order').modal('show');

    let res = await fetch('/company/orders/tables-menus');
    let data = await res.json();

    adminData.menus = data.menus;
    adminData.tables = data.tables;

    initTableSelect();
    initMenuSelect();
});

const initTableSelect = () => {
    let select = $('#table_select');
    select.html(`<option value="">بدون میز</option>`);

    adminData.tables.forEach(table => {
        select.append(`
            <option value="${table.id}">
                میز ${table.name}
            </option>
        `);
    });
};

const initMenuSelect = () => {
    let select = $('#menu_select');
    select.html(`<option value="">انتخاب منو</option>`);

    adminData.menus.forEach((menu, i) => {
        select.append(`
            <option value="${i}">
                ${menu.name}
            </option>
        `);
    });
};

// when menu changes
$('#menu_select').on('change', function () {
    initMenuItemSelect(this.value);
});

const initMenuItemSelect = (menuIndex) => {

    let select = $('#menu_item_select');
    select.html(`<option value="">انتخاب آیتم</option>`);

    if (!adminData.menus[menuIndex]) return;

    adminData.menus[menuIndex].menu_item.forEach(item => {
        select.append(`
            <option value="${item.id}" data-name="${item.name}">
                ${item.name}
            </option>
        `);
    });
};


$('#qty_plus').click(() => {
    let val = +$('#item_qty').val();
    $('#item_qty').val(val + 1);
});

$('#qty_minus').click(() => {
    let val = +$('#item_qty').val();
    if (val > 1) $('#item_qty').val(val - 1);
});

const renderOrderList = () => {

    let container = $('#order_list');
    container.html('');

    adminData.orders.forEach(item => {

        container.append(`
            <div class="d-flex justify-content-between border-bottom py-2">

                <div>${item.name}</div>

                <div>${item.qty}</div>

                <div>
                    <button class="btn btn-sm btn-danger"
                        onclick="removeItem(${item.id})">حذف</button>
                </div>

            </div>
        `);
    });
};

$('#admin_send_btn').click(() => {
    console.log($('#customer_name').val());

    if (adminData.orders.length === 0) return alert('سفارشی نیست');

    $.ajax({
        url: '/order_recipient',
        method: 'post',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        data: JSON.stringify({
            customer_name: $('#customer_name').val(),
            customer_phone: $('#customer_phone').val(),
            tableSelected: $('#table_select').val(),
            ordersItem: adminData.orders,
        }),

        success: function (res) {
            $('#add_order').modal('hide');
            resetForm();
            alert('ثبت شد');
        },

        error: function (err) {
            console.log(err);
            alert('خطا');
        }
    });
});

const resetForm = () => {
    adminData.orders = [];

    $('#customer_name').val('');
    $('#customer_phone').val('');
    $('#item_qty').val(1);
    $('#order_list').html('');
};
