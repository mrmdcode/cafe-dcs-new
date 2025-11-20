var echo = new Echo({
    broadcaster: 'pusher',
    key: 'EJCRgmPCFGb_lSx0e2UU',
    forceTLS: true,
    wsHost: 'socket.cafe-dcs.ir',
    wsPort: 443,
    cluster: 'eu',
    enableStats: false,
});


var publicKey = `-----BEGIN CERTIFICATE-----
MIIECzCCAvOgAwIBAgIGAZKLwC9vMA0GCSqGSIb3DQEBCwUAMIGiMQswCQYDVQQG
EwJVUzELMAkGA1UECAwCTlkxEjAQBgNVBAcMCUNhbmFzdG90YTEbMBkGA1UECgwS
UVogSW5kdXN0cmllcywgTExDMRswGQYDVQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMx
HDAaBgkqhkiG9w0BCQEWDXN1cHBvcnRAcXouaW8xGjAYBgNVBAMMEVFaIFRyYXkg
RGVtbyBDZXJ0MB4XDTI0MTAxMzE1NTgwMVoXDTQ0MTAxMzE1NTgwMVowgaIxCzAJ
BgNVBAYTAlVTMQswCQYDVQQIDAJOWTESMBAGA1UEBwwJQ2FuYXN0b3RhMRswGQYD
VQQKDBJRWiBJbmR1c3RyaWVzLCBMTEMxGzAZBgNVBAsMElFaIEluZHVzdHJpZXMs
IExMQzEcMBoGCSqGSIb3DQEJARYNc3VwcG9ydEBxei5pbzEaMBgGA1UEAwwRUVog
VHJheSBEZW1vIENlcnQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQC+
zro4aAFXK0cB4cl7w6PBU6VvCCKwCdIr+j9QRYDy4eA7PPRxWE7ED53XhPsKue1G
cND3XIqG8dekE9fJ10IbmJ7bpqlSC27ARyMazhgoABnUpXPWwguhz816e3u5G4fZ
KnkqJxlfl3LrQed53wBFQkAUDQeudQSbHUay4+EAEVeIKHlMTNvquvS6RbTGPhuP
bzSU00Idfxev+kgr2NAD3sq2wL67cp2j0SersPvtBjGPL+qiNgCt18yusUHOs0+a
gB/mPzGgVb+0HQMvjmPgnjdzvcZGJqAY7+4SqTvDgmpJyFldheTzCGlFHFM3AISx
DoXSfFwQXqJCN2EyFd5TAgMBAAGjRTBDMBIGA1UdEwEB/wQIMAYBAf8CAQEwDgYD
VR0PAQH/BAQDAgEGMB0GA1UdDgQWBBQtkZ96BMP+UYfgjLkQaY2nWszcBTANBgkq
hkiG9w0BAQsFAAOCAQEAppSeJr/bpvvTeJonJ+wjHmIuSerSsAGXaLS1KSKLJ634
bvkC5IzeHF9fPUu/S5mT2IBMigdfqOzdesCwciYTgDP+5o6Y/HnrEPDhI0yzWloM
1+h/0+USD1+OJ7rjW5kZXw43Jcd3eUtDhIo3PkqaCEOqKNUNStH7MFerr/EOKuJP
qH5cSg3vukKSJi3NDjmXoY7EtV7RgARAzKddK315loBizwKNeCnB4UqeG4x2iz/X
8Arn3qnVSyk5IgbY1FhfdyeRe2wNtrTTw9EjEX5dyvje1Rs6nfCpNUrV/sCFWapG
3GNi1Af1bPIWL/JZcQ0Wlo4scK71hkmtNELgVjolVQ==
-----END CERTIFICATE-----`;

qz.security.setCertificatePromise(function(resolve, reject) {
    resolve(publicKey);
});



// گوش دادن به یک کانال
echo.channel('order').listen('.don_club',(data) => {
    let datas = data.orders;
    console.log(datas);
    refreshPage()
    qz.websocket.connect().then(()=>{
        return qz.printers.find('cash');
    }).then((found)=>{
        //alert(found)
        var config = qz.configs.create(found);
        var data = [{
            type : 'pixel',
            format : 'html',
            flavor : 'plain',
            data : create_invoice(datas.id,datas.customer.name,datas.menu_item,datas.table.name,'15:00:00','15:05:00','1403/07/22','دن کلاب','*'),
        }]
        return qz.print(config,data)
    }).catch((e)=>{
        alert(e);
    })
});
const create_invoice =(order_id=0,customer_name ,orders,table,time_create,time_print,date,company_name,printer_name)=>{
    des_total = 0;
    orders.map((item)=>{
        if (item.description != '')
            des_total ++;
    });
    return `<div style="width: 250px; direction: rtl; border: 1px solid #000; box-sizing: border-box; padding: 0; margin: 0; ">
            <h2 style="display: flex; align-items: center; justify-content: center; margin: 9px 0;">${company_name} - ${printer_name}</h2>
            <div style="display: flex; flex-direction: row; margin: 0;box-sizing: border-box;padding:0 5.5px">
                <h1 style="border: 1px solid; display: flex; justify-content: center; align-items: center; padding: 0.5rem 0; margin:0; flex: 1;height: calc(80px - 1rem);">${order_id}</h1>
                <strong style="display: flex; justify-content: center; align-items: flex-end; flex: 1; height: 80px;">${time_print}</strong>
                <div style="border: 1px solid; display: flex; flex-direction: column; justify-content: center; align-items: center; flex: 1;height: 80px;">
                    <strong style="margin: 0;">${time_create}</strong>
                    <strong style="margin-top: 10px;">${date}</strong>
                </div>
            </div>
            <div style="padding: 0.25rem .90rem 0 .90rem; display: flex; flex-direction: row;">
                <div style="flex: 5;"><span>میز : </span><strong style="font-size: 20px;">${table}</strong></div>
                <div style="flex: 2;"><span>توضیح : </span><strong style="font-size: 20px;">${des_total}</strong></div>
            </div>
            <div style="padding: 0.25rem .90rem .25rem .90rem; display: flex; flex-direction: row;">
                <div style="flex: 1;"><span>میهمان : </span><strong style="font-size: 20px;">${customer_name}</strong></div>
            </div>
            <table style="border: 1px solid; width: 100%; margin: 0; padding: 0; border-collapse: collapse;" >
                <thead >
                    <tr style="display: flex; flex-direction: row;">
                        <th style="flex: 11; border: 1px solid;"><strong>نام</strong></th>
                        <th style="flex: 1; border: 1px solid;"><strong>تعداد</strong></th>
                    </tr>
                </thead>
                <tbody>
                    ${orders.map((item)=>{
        return `<tr style="display: flex; flex-direction: row;">
                            <td style="flex: 11; border: 1px solid;">${item.name} ${item.pivot.description ? '| <span style="font-size:13px;">'+item.pivot.description+'</span>':''} </td>
                            <td style="flex: 1; border: 1px solid; text-align: center">${item.pivot.qty}</td>
                        </tr>`
    }).join('')  }
                </tbody>
            </table>
        </div>`;
}
