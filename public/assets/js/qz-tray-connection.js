"use strict"

const echo = new Echo({
    broadcaster: 'pusher',
    key: 'EJCRgmPCFGb_lSx0e2UU',
    wsHost: 'socket.cafe-dcs.ir',
    wsPort: 443,
    forceTLS: true,
    disableStats: true,
    cluster: 'eu',
});


// ========================================
// QZ SECURITY
// ========================================

qz.security.setCertificatePromise((resolve, reject) => {
    fetch('/company/qz/certificate')
        .then(response => response.text())
        .then(resolve)
        .catch(reject);
});


// ========================================
// TEST CONNECTION
// ========================================

async function testQZ() {
    try {
        if (!qz.websocket.isActive()) {
            await qz.websocket.connect();
        }

        console.log('QZ Connected');
        const printers = await qz.printers.find();
        console.log(printers);

        alert(
            'QZ Connected Successfully\n\n' +
            printers.join('\n')
        );

    } catch (error) {
        console.error(error);
        alert(error);
    }
}
