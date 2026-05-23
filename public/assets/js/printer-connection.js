(function () {
    'use strict';

    //  Helpers

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    // Certificate (fetched from server)
    qz.security.setCertificatePromise(function (resolve, reject) {
        fetch('/api/company/printer/certificate', {
            cache: 'no-store',
            credentials: 'include',
            headers: { 'X-CSRF-TOKEN': csrfToken() }
        })
            .then(function (r) {
                return r.ok ? r.text() : Promise.reject('cert fetch failed: ' + r.status);
            })
            .then(resolve)
            .catch(reject);
    });

    //  Signature (unsigned demo cert)
    qz.security.setSignatureAlgorithm('SHA512');
    qz.security.setSignaturePromise(function () {
        return function (resolve) { resolve(); };
    });

    //  Internal state
    var _connectionPromise = null;
    var _printerName       = null; // cached after first fetch

    //  Connect (once)
    function connect() {
        if (_connectionPromise) return _connectionPromise;

        _connectionPromise = qz.websocket.connect()
            .then(function () {
                console.log('[QZPrinter] Connected to QZ Tray.');
            })
            .catch(function (e) {
                _connectionPromise = null; // allow retry
                return Promise.reject('اتصال به QZ Tray ناموفق بود. آیا QZ Tray اجرا است؟\n' + e);
            });

        return _connectionPromise;
    }

    //  Fetch cashier printer local_address from DB (once)
    function fetchPrinterName() {
        if (_printerName) return Promise.resolve(_printerName);

        return fetch('/api/company/printer/cashier-data', {
            cache: 'no-store',
            credentials: 'include',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken()
            }
        })
            .then(function (r) {
                return r.ok ? r.json() : Promise.reject('printer fetch failed: ' + r.status);
            })
            .then(function (data) {
                if (!data.printer) {
                    return Promise.reject('پرینتر صندوقدار در سیستم تعریف نشده است. لطفاً از پنل مدیریت پرینتر تعریف کنید.');
                }
                _printerName = data.printer;
                console.log('[QZPrinter] Cashier printer:', _printerName);
                return _printerName;
            });
    }

    //  Public: getConnection
    /**
     * Connects to QZ Tray and resolves with the cashier printer local_address.
     * Both manager and cashier use this — always prints to the cashier printer.
     */
    function getConnection() {
        return connect().then(fetchPrinterName);
    }

    //  Public API
    window.QZPrinter = {
        getConnection: getConnection,
    };

    //  Auto-connect on page load (silent)
    // document.addEventListener('DOMContentLoaded', function () {
    //     fetch('/sanctum/csrf-cookie', { credentials: 'include' })
    //         .then(function () {
    //             connect().catch(function (e) {
    //                 console.warn('[QZPrinter]', e);
    //             });
    //         });
    // });

}());
