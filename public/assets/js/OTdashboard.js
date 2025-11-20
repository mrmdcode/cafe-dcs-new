let ordersItem = [];

const handler_subscription_code = (subscription_code_value) => {
    console.log(subscription_code_value)
    if (subscription_code_value >0 && subscription_code_value != ''){
        $.ajax({
            url: '/order_recipient/subscription_code',
            method: 'post',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-Token': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            data: JSON.stringify({
                subscription_code_value: subscription_code_value,
            }),
            success: function (response) {
                $('#customer_name').val(response.name);

            },
            error: function (xhr, status, error) {
                console.log(xhr.responseJSON.message)
                Swal.fire({
                    position: "bottom-start",
                    icon: "error",
                    title: xhr.responseJSON.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
}
const tableSelect = (data) => {
    console.log(data.getAttribute('table-id'))

    $('#order_register_label ').text('سفارشات '+data.innerText);
    $('#send_btn ').attr('onclick',"send("+data.getAttribute('table-id')+")");
    $('#order_register').modal('show');
}
const initTableSelector = (tables) => {
    $('#customer_name').val('')
    $('#customer_phone').val('')
    $('#tables').html(`<div class="col-md-12 py-3 ">
                <button class="btn btn-warning w-100" >بدون میز</button>
            </div>`);
    tables.map((item)=>{
        console.log(item)
        if (item.orders !== null && item.orders.length > 0) {
            // اگر سفارش وجود دارد و وضعیت سفارش "registration" است
            if (item.orders[0].status === "registration") {
                $('#tables').append(`
                        <div class="col-md-3 py-3">
                            <button class="btn btn-warning w-100" table-id='${item.id}' onclick="edit(this.getAttribute('table-id'))">
                                میز ${item.name}
                            </button>
                        </div>
                    `);
            }
            else if (item.orders[0].status === "edit") {
                $('#tables').append(`
                        <div class="col-md-3 py-3">
                            <button class="btn btn-warning w-100" table-id='${item.id}' onclick="edit(this.getAttribute('table-id'))">
                                میز ${item.name} (ویرایش شده)
                            </button>
                        </div>
                    `);
            }
        } else {
            // اگر سفارش وجود ندارد
            $('#tables').append(`
        <div class="col-md-3 py-3">
            <button class="btn btn-outline-warning w-100" table-id='${item.id}' onclick="tableSelect(this)">
                میز ${item.name}
            </button>
        </div>
    `);
        }

    })
}
const initMenus = (menus) => {
    $('#menus').html('');
    menus.map((item,i)=>{
        $('#menus').append(`<button class="btn text-secondary col-lg-2 col-md-3 col-sm-5 " style="border-left: 1px solid #000;" onclick="initMenusItem(${i})">${item.name}</button>`);
    });
    initMenusItem(0);
}
const initMenusItem = (index) => {
    console.log(index)
    $('#menu_items').html('');
    menus[index].menu_item.map((item)=>{
        $('#menu_items').append(`<button class="btn btn-secondary m-0 my-1  w-100 " style="white-space: normal;word-wrap: break-word;" onclick="addItemToOrder(${item.id},'${item.name}')">${item.name}(${item.description? item.description.slice(0,25):''})</button>`);
    });
}
const addItemToOrder = (id,name) => {
    if(!!ordersItem.filter((item)=>{
        return item.id == id ;
    })[0]){
        ordersItem.map((item)=>{
            if (item.id == id){
                item.qty += 1
            }
        });
    }
    else{
        ordersItem.push({id : id ,name:name,description:'',qty:1})
    }

    ordersref();
}
const ordersref = () => {
    $('#order_items').html('');
    ordersItem.map((item)=>{
        $('#order_items').append(  `<div class="row d-flex justify-content-between border-bottom border-secondary">
                    <span class="name col-4">${item.name}</span>
                    <span class="col-4 p-2"><input type="text" placeholder="توضیحات" onkeyup="addDescription(this.value,${item.id})" class="bg-transparent w-75 border-0 border-bottom border-black" value="${item.description}" ></span>
                    <span class="qty col-4 d-flex">
                        <button class="btn" onclick="qtyMinus(${item.id})">-</button>
                        <input class=" w-50" type="number" id="qty_${item.id}" style="background-color: transparent; appearance: none; border: none;" value="${item.qty}">
                        <button class="btn" onclick="qtyPlus(${item.id})">+</button>
                    </span>
                </div>`);
    })
}
const addDescription = (des,id) => {
    ordersItem.map((item)=>{
        if (item.id == id){
            item.description = des;
        }
    });
    console.log(ordersItem)
}
const qtyPlus = (id) => {
    ordersItem.map((item)=>{
        if (item.id == id){
            item.qty += 1
        }
    });
    ordersref();
}
const qtyMinus = (id) => {
    ordersItem.map((item,i)=>{
        if (item.id == id){
            if (item.qty >1){
                item.qty -= 1
            }
            else{
                ordersItem.splice(i,1);
            }
        }
    });
    ordersref()
}
const initPage = async () => {
    let response = await fetch('/order_recipient/indexData')
    let responseJson = await response.json();
    console.log(responseJson)
    let tables = await responseJson.tables;
    let menu =await responseJson.menus;
    menus = menu;
    await initTableSelector(tables)
    await initMenus(menu);
}
document.addEventListener('DOMContentLoaded',initPage)
const send = async (table_id) => {

    console.log($('#customer_name').val(), $('#customer_phone').val() , table_id , ordersItem , $('meta[name="X-CSRF-TOKEN"]').attr('content'))


    if ($('#customer_name').val() === null || $('#customer_name').val() == ''){
        Swal.fire({
            position: "bottom-start",
            icon: "error",
            title: "نام مشتری را وارد کنید .",
            showConfirmButton: false,
            timer: 1500
        });
    }
    else if($('#customer_phone').val() === null || $('#customer_phone').val() == ''){
        Swal.fire({
            position: "bottom-start",
            icon: "error",
            title: "شماره مشتری را وارد کنید .",
            showConfirmButton: false,
            timer: 1500
        });
    }
    else if(ordersItem === [] ){
        Swal.fire({
            position: "bottom-start",
            icon: "error",
            title: "سفارش مشتری را وارد کنید .",
            showConfirmButton: false,
            timer: 1500
        });
    }
    else {
        $("#loader").css('display', 'flex');
        $('#order_register').modal('hide');

        $.ajax({
            url: '/order_recipient',
            method: 'post',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-Token': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            data: JSON.stringify({
                customer_phone: $('#customer_phone').val(),
                customer_name: $('#customer_name').val(),
                tableSelected: table_id,
                ordersItem: ordersItem,
            }),
            success: function (response) {
                console.log(response)
                $("#loader").css('display', 'none');
                //after send
                $('#customer_name').val('')
                $('#customer_phone').val('')
                ordersItem = [];
                initPage();
                ordersref();
                Swal.fire({
                    position: "bottom-start",
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function (xhr, status, error) {

                $("#loader").css('display', 'none');
                //after send
                $('#customer_name').val('')
                $('#customer_phone').val('')
                ordersItem = [];
                initPage();
                ordersref();
                Swal.fire({
                    position: "bottom-start",
                    icon: "error",
                    title: xhr.responseJSON.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

    }




}
const edit = async (id) => {
    $.ajax({
        url: '/order_recipient/'+id,
        method: 'get',
        headers:{
            'Content-Type' : 'application/json',
            'Accept' : 'application/json',
        },
        success: function(response)
        {
            console.log(response)
            ordersItem = [];
            response.menu_item.map((item)=>{
                // console.log(item)
                ordersItem.push({
                    id:item.id,
                    name:item.name,
                    qty:item.pivot.qty,
                    description:item.pivot.description
                })
            });
            $('#customer_name').val(response.customer.name).attr('disabled','disabled');
            $('#customer_phone').val(response.customer.phone).attr('disabled','disabled');


            $('#order_register_label ').text('ویرایش سفارشات '+response.id+'-'+response.unique_key);
            $('#send_btn ').attr('onclick',"update('"+response.id+'-'+response.unique_key+"'),this.getAttribute('table-id')").text("بروزرسانی");
            $('#order_register').modal('show');
            ordersref()
        },

        error: function(xhr, status, error) {
            // Handle errors here
            console.error(status, error);
        }
    });
}
const update = (url,table_id) => {
    console.log($('#customer_name').val(), $('#customer_phone').val() , table_id , ordersItem , $('meta[name="X-CSRF-TOKEN"]').attr('content'))


    if ($('#customer_name').val() === null || $('#customer_name').val() == ''){
        Swal.fire({
            position: "bottom-start",
            icon: "error",
            title: "نام مشتری را وارد کنید .",
            showConfirmButton: false,
            timer: 1500
        });
    }
    else if($('#customer_phone').val() === null || $('#customer_phone').val() == ''){
        Swal.fire({
            position: "bottom-start",
            icon: "error",
            title: "شماره مشتری را وارد کنید .",
            showConfirmButton: false,
            timer: 1500
        });
    }
    else if(ordersItem === [] ){
        Swal.fire({
            position: "bottom-start",
            icon: "error",
            title: "سفارش مشتری را وارد کنید .",
            showConfirmButton: false,
            timer: 1500
        });
    }
    else {
        $("#loader").css('display', 'flex');
        $('#order_register').modal('hide');

        $.ajax({
            url: '/order_recipient/update/'+url,
            method: 'post',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-Token': $('meta[name="X-CSRF-TOKEN"]').attr('content')
            },
            data: JSON.stringify({
                // customer_phone: $('#customer_phone').val(),
                // customer_name: $('#customer_name').val(),
                tableSelected: table_id,
                ordersItem: ordersItem,
            }),
            success: function (response) {
                console.log(response)
                $("#loader").css('display', 'none');
                //after send
                $('#customer_name').val('')
                $('#customer_phone').val('')
                ordersItem = [];
                initPage();
                ordersref();
                Swal.fire({
                    position: "bottom-start",
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseJSON.message)
                $("#loader").css('display', 'none');
                //after send
                $('#customer_name').val('')
                $('#customer_phone').val('')
                ordersItem = [];
                initPage();
                ordersref();
                Swal.fire({
                    position: "bottom-start",
                    icon: "error",
                    title: xhr.responseJSON.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

    }
}
