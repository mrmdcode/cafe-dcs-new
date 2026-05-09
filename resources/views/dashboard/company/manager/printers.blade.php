@extends('Layouts.app')
@section('aside_menu')
    @include('dashboard.company.manager._partial._menu')
@endsection
@section('top_menu')
    @include('dashboard.company.manager._partial._topMenu')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-11">
            <!-- Flash messages (only shown after delete redirect) -->
            @if(session('status'))
            <div class="alert alert-{{ session('status') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4>پرینتر ها</h4>
                    <div>
                        {{-- <a href="{{ route('company.printer.private_key') }}" class="btn btn-outline-info btn-sm">
                            <i class="ri-download-2-line"></i> دانلود کلید خصوصی
                        </a> --}}
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#printerModal" onclick="resetForm()">
                            <i class="ri-add-line"></i> افزودن پرینتر
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table bg-white table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>آدرس داخلی</th>
                                <th>صندوق</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($printers as $i => $printer)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $printer->name }}</td>
                                    <td><code>{{ $printer->local_address }}</code></td>
                                    <td>{!! $printer->cashier ? '✅' : '❌' !!}</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm edit-btn"
                                                data-id="{{ $printer->id }}"
                                                data-name="{{ $printer->name }}"
                                                data-local_address="{{ $printer->local_address }}"
                                                data-cashier="{{ $printer->cashier }}"
                                                data-bs-toggle="modal" data-bs-target="#printerModal">
                                            ویرایش
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $printer->id }})">
                                            حذف
                                        </button>
                                        <form id="delete-form-{{ $printer->id }}" action="{{ route('company.printer.destroy', $printer->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">هیچ پرینتری ثبت نشده</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Small note about private key -->
            {{-- <div class="card bg-white border-0 mt-3">
                <div class="card-body p-3">
                    <i class="ri-information-line"></i>
                    کلید خصوصی QZ Tray را در مسیر نصب نرم‌افزار QZ Tray قرار دهید و برنامه را مجدداً راه‌اندازی کنید.
                </div>
            </div> --}}
        </div>
    </div>
</div>

<!-- Create / Edit Modal -->
<div class="modal fade" id="printerModal" tabindex="-1" aria-labelledby="printerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="printerForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printerModalLabel">افزودن پرینتر</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" id="printerId" name="printer_id" value="">

                    <div class="mb-3">
                        <label class="form-label">نام</label>
                        <input type="text" class="form-control" id="printerName" name="name" required>
                        <div class="invalid-feedback" id="error-name"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">آدرس داخلی (System Name in QZ Tray)</label>
                        <input type="text" class="form-control" id="printerAddress" name="local_address" required>
                        <div class="invalid-feedback" id="error-local_address"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">صندوق</label>
                        <select class="form-select" id="printerCashier" name="cashier" required>
                            <option value="1">صندوق</option>
                            <option value="0">سایر</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary" id="saveButton">ذخیره</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    // Reset form for create mode
    function resetForm() {
        $('#printerModalLabel').text('افزودن پرینتر');
        $('#formMethod').val('POST');
        $('#printerId').val('');
        $('#printerName').val('').removeClass('is-invalid');
        $('#printerAddress').val('').removeClass('is-invalid');
        $('#printerCashier').val('1');
        $('.invalid-feedback').text('');
        $('#saveButton').text('ایجاد');
    }

    // Populate form for edit mode using data attributes
    $('.edit-btn').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const address = $(this).data('local_address');
        const cashier = $(this).data('cashier');

        $('#printerModalLabel').text('ویرایش پرینتر');
        $('#formMethod').val('PUT');
        $('#printerId').val(id);
        $('#printerName').val(name).removeClass('is-invalid');
        $('#printerAddress').val(address).removeClass('is-invalid');
        $('#printerCashier').val(cashier);
        $('.invalid-feedback').text('');
        $('#saveButton').text('بروزرسانی');
    });

    // Handle AJAX form submission
    $('#printerForm').on('submit', function(e) {
        e.preventDefault();

        let url, method;
        const printerId = $('#printerId').val();
        if (!printerId) {
            // Create
            url = '{{ route('company.printer.store') }}';
            method = 'POST';
        } else {
            // Update
            url = '{{ route('company.printer.update', '') }}/' + printerId;
            method = 'PUT';
        }

        const formData = {
            name: $('#printerName').val(),
            local_address: $('#printerAddress').val(),
            cashier: $('#printerCashier').val(),
            _token: $('input[name="_token"]').val(),
        };

        $.ajax({
            url: url,
            method: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Show success message and reload page
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    // Clear previous errors
                    $('.invalid-feedback').text('');
                    $('.form-control').removeClass('is-invalid');

                    // Display validation errors
                    if (errors.name) {
                        $('#printerName').addClass('is-invalid');
                        $('#error-name').text(errors.name[0]);
                    }
                    if (errors.local_address) {
                        $('#printerAddress').addClass('is-invalid');
                        $('#error-local_address').text(errors.local_address[0]);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'مشکلی پیش آمد. لطفاً دوباره تلاش کنید.'
                    });
                }
            }
        });
    });

    // Delete confirmation
    function confirmDelete(printerId) {
        Swal.fire({
            title: "آیا از حذف پرینتر اطمینان دارید؟",
            text: "این عملیات قابل بازگشت نیست.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "بله، حذف شود",
            cancelButtonText: "انصراف"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + printerId).submit();
            }
        });
    }
</script>
@endsection
