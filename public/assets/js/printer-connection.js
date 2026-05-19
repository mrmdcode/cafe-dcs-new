(function () {
    'use strict';

    var STORAGE_KEY = 'cashier_selected_printer';

    // Certificate
    qz.security.setCertificatePromise(function (resolve, reject) {
        fetch('api/company/printer/certificate', {
            cache: 'no-store',
            credentials: 'include',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="x-csrf-token"]').content }
        })
            .then(function (r) { return r.ok ? r.text() : Promise.reject('cert fetch failed'); })
            .then(resolve)
            .catch(reject);
    });

    //  Signature (demo/unsigned)
    qz.security.setSignatureAlgorithm('SHA512');
    qz.security.setSignaturePromise(function () {
        return function (resolve) { resolve(); };
    });

    // Internal state
    var _connectionPromise = null;

    function connect() {
        if (_connectionPromise) return _connectionPromise;

        _connectionPromise = qz.websocket.connect()
            .then(function () {
                console.log('[QZPrinter] Connected to QZ Tray.');
            })
            .catch(function (e) {
                _connectionPromise = null;
                return Promise.reject('اتصال به QZ Tray ناموفق بود. آیا QZ Tray اجرا است؟\n' + e);
            });

        return _connectionPromise;
    }

    // Printer picker modal

    /**
     * Inject the printer picker modal into the page (once).
     */
    function injectPickerModal() {
        if (document.getElementById('qz_printer_picker_modal')) return;

        var html = `
        <div class="modal fade" id="qz_printer_picker_modal" tabindex="-1" aria-hidden="true"
             data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">انتخاب پرینتر</h5>
                    </div>
                    <div class="modal-body">
                        <p id="qz_picker_status" class="text-muted">در حال دریافت لیست پرینترها...</p>
                        <select class="form-select d-none" id="qz_printer_select">
                            <option value="">-- پرینتر را انتخاب کنید --</option>
                        </select>
                        <div id="qz_picker_error" class="alert alert-danger d-none mt-2"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="qz_picker_reset">
                            تغییر پرینتر
                        </button>
                        <button type="button" class="btn btn-primary" id="qz_picker_confirm" disabled>
                            تأیید
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

        document.body.insertAdjacentHTML('beforeend', html);

        // Confirm button
        document.getElementById('qz_picker_confirm').addEventListener('click', function () {
            var select = document.getElementById('qz_printer_select');
            var chosen = select.value;
            if (!chosen) return;

            localStorage.setItem(STORAGE_KEY, chosen);

            var bsModal = bootstrap.Modal.getInstance(
                document.getElementById('qz_printer_picker_modal')
            );
            bsModal.hide();

            if (_pendingResolve) {
                _pendingResolve(chosen);
                _pendingResolve = null;
                _pendingReject = null;
            }
        });

        // Change printer button
        document.getElementById('qz_picker_reset').addEventListener('click', function () {
            localStorage.removeItem(STORAGE_KEY);
            loadPrinterList();
        });
    }

    // Pending promise callbacks when picker is opened mid-flow
    var _pendingResolve = null;
    var _pendingReject = null;

    /**
     * Populate the select with printers from QZ Tray.
     */
    function loadPrinterList() {
        var status = document.getElementById('qz_picker_status');
        var select = document.getElementById('qz_printer_select');
        var confirm = document.getElementById('qz_picker_confirm');
        var errBox = document.getElementById('qz_picker_error');

        status.textContent = 'در حال دریافت لیست پرینترها...';
        status.classList.remove('d-none');
        select.classList.add('d-none');
        confirm.disabled = true;
        errBox.classList.add('d-none');

        connect()
            .then(function () { return qz.printers.find(); })
            .then(function (printers) {
                select.innerHTML = '<option value="">-- پرینتر را انتخاب کنید --</option>';

                var list = Array.isArray(printers) ? printers : [printers];
                list.forEach(function (name) {
                    var opt = document.createElement('option');
                    opt.value = name;
                    opt.textContent = name;
                    select.appendChild(opt);
                });

                status.classList.add('d-none');
                select.classList.remove('d-none');

                select.onchange = function () {
                    confirm.disabled = !select.value;
                };
            })
            .catch(function (e) {
                status.classList.add('d-none');
                errBox.textContent = String(e);
                errBox.classList.remove('d-none');

                if (_pendingReject) {
                    _pendingReject(e);
                    _pendingResolve = null;
                    _pendingReject = null;
                }
            });
    }

    /**
     * Open the picker modal and return a Promise that resolves
     * with the chosen printer name.
     */
    function openPicker() {
        injectPickerModal();

        return new Promise(function (resolve, reject) {
            _pendingResolve = resolve;
            _pendingReject = reject;

            var modalEl = document.getElementById('qz_printer_picker_modal');
            var bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
            bsModal.show();

            loadPrinterList();
        });
    }

    //  Public: getConnection


    // Connect to QZ Tray and resolve with a printer name.
    function getConnection() {
        var saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            return connect().then(function () { return saved; });
        }
        return openPicker();
    }


    // Force-open the picker (e.g. from a settings button).
    function changePrinter() {
        localStorage.removeItem(STORAGE_KEY);
        return openPicker();
    }

    //  Public API
    window.QZPrinter = {
        getConnection: getConnection,
        changePrinter: changePrinter,
    };

    //  Auto-connect on page load (silent, no picker yet)
    document.addEventListener('DOMContentLoaded', function () {
        connect().catch(function (e) {
            console.warn('[QZPrinter]', e);
        });
    });

}());
