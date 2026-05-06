@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
    <div class="row justify-content-center">
        {{-- Session alert --}}
        <div
            class="@if (session('status') == 'success') alert alert-success @elseif(session('status') == 'error') alert alert-danger @endif col-11">
            <div class="alert-body ">{{ session('message') }}</div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>مشتریان</h4>
                </div>
                <div class="card-body">
                    <table class="table bg-white table-hover table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>نام</th>
                            <th>تلفن</th>
                            <th>آدرس</th>
                            <th>تعداد سفارش‌ها</th>
                            <th>عملیات</th>
                        </thead>
                        <tbody>
                            @forelse($customers as $i => $customer)
                                <tr class="text-center">
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->address ?? '—' }}</td>
                                    <td>{{ $customer->orders->count() }}</td>
                                    <td class="d-flex justify-content-around">
                                        {{-- ویرایش --}}
                                        <button data-url="{{ route('company.customer.edit', $customer) }}"
                                            onclick="editCustomer(this.getAttribute('data-url'))"
                                            class="btn btn-outline-warning btn-sm">
                                            ویرایش
                                        </button>
                                        {{-- مشاهده سفارش‌ها --}}
                                        <button data-url="{{ route('company.customer.orders', $customer) }}"
                                            onclick="showOrders(this.getAttribute('data-url'))"
                                            class="btn btn-outline-primary btn-sm">
                                            سفارش‌ها
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">هیچ مشتری‌ای ثبت نشده است.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- مودال ویرایش مشتری --}}
    @include('dashboard.company.manager._partial.customer.edit_modal')
    {{-- مودال نمایش سفارش‌ها --}}
    @include('dashboard.company.manager._partial.customer.orders_modal')
@endsection

@section('js')
    <script>
        /**
         * دریافت اطلاعات مشتری و نمایش در مودال ویرایش
         */
        const editCustomer = async (url) => {
            try {
                const response = await fetch(url, {
                    headers: {
                        'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();

                // پر کردن فیلدهای مودال
                $('#edit_customer_id').val(data.customer.id);
                $('#edit_customer_name').val(data.customer.name);
                $('#edit_customer_phone').val(data.customer.phone);
                $('#edit_customer_address').val(data.customer.address ?? '');

                // تنظیم action فرم ویرایش
                $('#editCustomerForm').attr('action', '{{ route('company.customer.update', ':id') }}'.replace(':id',
                    data.customer.id));

                // نمایش مودال
                $('#customer_edit_modal').modal('show');
            } catch (error) {
                console.error('Error fetching customer data:', error);
                alert('خطا در دریافت اطلاعات مشتری');
            }
        };

        // Intercept form submission
        $('#editCustomerForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');
            const data = {
                name: $('#edit_customer_name').val(),
                phone: $('#edit_customer_phone').val(),
                address: $('#edit_customer_address').val(),
                _method: 'PUT',
                _token: $('meta[name="x-csrf-token"]').attr('content')
            };

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    // Show success SweetAlert
                    Swal.fire({
                        title: 'موفقیت!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Close modal
                        $('#customer_edit_modal').modal('hide');

                        // Update the table row (optional)
                        const customer = response.customer;
                        const row = $('button[data-url*="/customer/' + customer.id + '/edit"]')
                            .closest('tr');
                        row.find('td:eq(1)').text(customer.name);
                        row.find('td:eq(2)').text(customer.phone);
                        row.find('td:eq(3)').text(customer.address ?? '—');
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'خطایی رخ داده است.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMsg = Object.values(errors).flat().join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'خطا!',
                        html: errorMsg,
                        icon: 'error',
                        confirmButtonText: 'باشه'
                    });
                }
            });
        });

        /**
         * دریافت سفارش‌های مشتری و نمایش در مودال
         */
        const showOrders = async (url) => {
            try {
                const response = await fetch(url, {
                    headers: {
                        'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();
                console.log(data);


                // نام مشتری را در عنوان مودال قرار دهیم
                $('#customer_orders_label').text('سفارش‌های ' + data.customer.name);

                // ساخت سطرهای جدول سفارش‌ها
                let rows = '';
                if (data.orders.length === 0) {
                    rows = '<tr><td colspan="4" class="text-center">هیچ سفارشی یافت نشد</td></tr>';
                } else {
                    data.orders.forEach((order, index) => {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${order.key}</td>
                                <td>${order.total ?? '—'}</td>
                                <td>${order.created_at ?? '—'}</td>
                            </tr>
                        `;
                    });
                }
                $('#customer_orders_tbody').html(rows);

                // نمایش مودال
                $('#customer_orders_modal').modal('show');
            } catch (error) {
                console.error('Error fetching orders:', error);
                alert('خطا در دریافت سفارش‌ها');
            }
        };
    </script>
@endsection
