@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
    <div class="container mt-4">
        <h4>ویرایش سفارش #{{ $order->id }}</h4>

        <form method="POST" action="{{ route('company.order.update', $order) }}">
            @csrf
            @method('PATCH')

            {{-- Customer & Table --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">نام مشتری</label>
                    <input type="text" name="customer_name" class="form-control"
                        value="{{ old('customer_name', $order->customer->name ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">شماره مشتری</label>
                    <input type="text" name="customer_phone" class="form-control"
                        value="{{ old('customer_phone', $order->customer->phone ?? '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">میز</label>
                <select name="table_id" class="form-select">
                    <option value="">بدون میز</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}"
                            {{ old('table_id', $order->table_id) == $table->id ? 'selected' : '' }}>
                            {{ $table->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <hr>

            {{-- Add item section (same as your Add Order JS, but here we use Blade for initial rendering) --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <select id="menu_select" class="form-select">
                        <option value="">-- منو --</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="item_select" class="form-select" disabled>
                        <option value="">ابتدا منو را انتخاب کنید</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" id="item_qty" class="form-control" value="1" min="1">
                </div>
                <div class="col-md-2">
                    <button type="button" id="add_item_btn" class="btn btn-primary w-100" disabled>افزودن</button>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" id="item_desc" class="form-control" placeholder="توضیحات (اختیاری)">
            </div>

            <hr>

            {{-- Cart table (existing items rendered on page load via Blade, then managed by JS) --}}
            <h6>آیتم‌های انتخاب شده</h6>
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="cart_table">
                    <thead>
                        <tr>
                            <th>آیتم</th>
                            <th>تعداد</th>
                            <th>توضیحات</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="cart_body">
                        @php
                            $cart =
                                old('items') ??
                                $order->menu_item
                                    ->map(
                                        fn($i) => [
                                            'id' => $i->id,
                                            'name' => $i->name,
                                            'qty' => $i->pivot->qty,
                                            'description' => $i->pivot->description ?? '',
                                            'price' => $i->pivot->price ?? 0,
                                        ],
                                    )
                                    ->toArray();
                        @endphp

                        @foreach ($cart as $idx => $cartItem)
                            <tr>
                                <td>
                                    <input type="hidden" name="items[{{ $idx }}][id]"
                                        value="{{ $cartItem['id'] }}">
                                    {{ $cartItem['name'] }}
                                </td>
                                <td>
                                    <input type="number" name="items[{{ $idx }}][qty]"
                                        value="{{ $cartItem['qty'] }}" min="1" class="form-control form-control-sm"
                                        style="width:80px">
                                </td>
                                <td>
                                    <input type="text" name="items[{{ $idx }}][description]"
                                        value="{{ $cartItem['description'] }}" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger remove-item">حذف</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary mt-3">بروزرسانی سفارش</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        // menus with items
        const menus = @json($menus);

        let itemIndex = {{ count($cart) }};

        const menuSelect = document.getElementById('menu_select');
        const itemSelect = document.getElementById('item_select');
        const addBtn = document.getElementById('add_item_btn');
        const cartBody = document.getElementById('cart_body');

        // =========================
        // Load items when menu changes
        // =========================
        menuSelect.addEventListener('change', function() {

            const menuId = this.value;

            itemSelect.innerHTML = '';

            if (!menuId) {

                itemSelect.disabled = true;
                addBtn.disabled = true;

                itemSelect.innerHTML = `
                <option value="">ابتدا منو را انتخاب کنید</option>
            `;

                return;
            }

            const menu = menus.find(m => m.id == menuId);

            if (!menu || !menu.menu_item.length) {

                itemSelect.innerHTML = `
                <option value="">آیتمی وجود ندارد</option>
            `;

                itemSelect.disabled = true;
                addBtn.disabled = true;

                return;
            }

            itemSelect.innerHTML = `
            <option value="">-- انتخاب آیتم --</option>
        `;

            menu.menu_item.forEach(item => {

                itemSelect.innerHTML += `
                <option
                    value="${item.id}"
                    data-name="${item.name}">
                    ${item.name}
                </option>
            `;
            });

            itemSelect.disabled = false;
        });

        // =========================
        // Enable add button
        // =========================
        itemSelect.addEventListener('change', function() {

            addBtn.disabled = !this.value;
        });

        // =========================
        // Add item to table
        // =========================
        addBtn.addEventListener('click', function() {

            const selected = itemSelect.options[itemSelect.selectedIndex];

            const itemId = selected.value;
            const itemName = selected.dataset.name;

            const qty = document.getElementById('item_qty').value || 1;

            const desc = document.getElementById('item_desc').value || '';

            if (!itemId) return;

            const row = `
            <tr>

                <td>
                    <input
                        type="hidden"
                        name="items[${itemIndex}][id]"
                        value="${itemId}">

                    ${itemName}
                </td>

                <td>
                    <input
                        type="number"
                        name="items[${itemIndex}][qty]"
                        value="${qty}"
                        min="1"
                        class="form-control form-control-sm"
                        style="width:80px">
                </td>

                <td>
                    <input
                        type="text"
                        name="items[${itemIndex}][description]"
                        value="${desc}"
                        class="form-control form-control-sm">
                </td>

                <td>
                    <button
                        type="button"
                        class="btn btn-danger btn-sm remove-item">
                        حذف
                    </button>
                </td>

            </tr>
        `;

            cartBody.insertAdjacentHTML('beforeend', row);

            itemIndex++;

            // reset fields
            item_qty.value = 1;
            item_desc.value = '';
            itemSelect.selectedIndex = 0;

            addBtn.disabled = true;
        });

        // =========================
        // Remove row
        // =========================
        document.addEventListener('click', function(e) {

            if (e.target.classList.contains('remove-item')) {

                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
