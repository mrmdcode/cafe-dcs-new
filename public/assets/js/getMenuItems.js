'use strict';

document.addEventListener('DOMContentLoaded', function () {
    const menuSelect = document.getElementById('menu_select');
    const itemSelect = document.getElementById('item_select');
    const qtyInput = document.getElementById('item_qty');
    const descInput = document.getElementById('item_desc');
    const addBtn = document.getElementById('add_item_btn');
    const cartBody = document.getElementById('cart_body');
    const submitBtn = document.getElementById('submit_order');
    const orderForm = document.getElementById('orderForm');

    let cartItems = []; // stores { id, name, qty, desc }

    // Load menu items when menu changes
    menuSelect.addEventListener('change', function () {
        const menuId = this.value;
        if (!menuId) {
            itemSelect.disabled = true;
            itemSelect.innerHTML = '<option value="">ابتدا منو را انتخاب کنید</option>';
            addBtn.disabled = true;
            return;
        }

        fetch(`/company/menu/${menuId}/items`)
            .then(res => res.json())
            .then(items => {
                itemSelect.disabled = false;
                itemSelect.innerHTML = '<option value="">-- انتخاب آیتم --</option>';
                items.forEach(item => {
                    itemSelect.innerHTML += `<option value="${item.id}" data-name="${item.name}">${item.name}</option>`;
                });
                addBtn.disabled = true;
            });
    });

    // Enable add button when an item is selected
    itemSelect.addEventListener('change', function () {
        addBtn.disabled = !this.value;
    });

    // Add item to cart
    addBtn.addEventListener('click', function () {
        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const itemId = itemSelect.value;
        const itemName = selectedOption.dataset.name;
        const qty = parseInt(qtyInput.value);
        if (!itemId || qty < 1) return;

        // Add to cart array
        cartItems.push({
            id: itemId,
            name: itemName,
            qty: qty,
            desc: descInput.value
        });

        renderCart();
        // Clear inputs (keep menu selection, reset item and qty)
        itemSelect.value = '';
        qtyInput.value = 1;
        descInput.value = '';
        addBtn.disabled = true;

        // Enable submit button if cart not empty
        submitBtn.disabled = false;
    });

    // Remove item from cart
    window.removeFromCart = function (index) {
        cartItems.splice(index, 1);
        renderCart();
        submitBtn.disabled = cartItems.length === 0;
    };

    function renderCart() {
        if (cartItems.length === 0) {
            cartBody.innerHTML = '<tr><td colspan="4" class="text-center">هیچ آیتمی انتخاب نشده است</td></tr>';
            return;
        }
        let html = '';
        cartItems.forEach((item, idx) => {
            html += `
                <tr>
                    <td>${item.name}<input type="hidden" name="items[${idx}][id]" value="${item.id}"></td>
                    <td>${item.qty}<input type="hidden" name="items[${idx}][qty]" value="${item.qty}"></td>
                    <td>${item.desc || '-'}<input type="hidden" name="items[${idx}][desc]" value="${item.desc || ''}"></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeFromCart(${idx})">حذف</button></td>
                </tr>
            `;
        });
        cartBody.innerHTML = html;
    }

    // Before form submit, we can optionally validate
    orderForm.addEventListener('submit', function (e) {
        if (cartItems.length === 0) {
            e.preventDefault();
            alert('حداقل یک آیتم به سفارش اضافه کنید.');
        }
    });
});
