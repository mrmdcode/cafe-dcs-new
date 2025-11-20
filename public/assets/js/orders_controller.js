let menus ;
let data ={
    today : true,
    yesterday : false,
    older : false,
    start : '',
    end : '',
    paid : false
};
let ordersItem = [];

const refreshPage = async () => {
    $.ajax({
        url: 'orders/indexData',
        method: 'post',
        headers:{
            'Content-Type' : 'application/json',
            'Accept' : 'application/json',
            'X-CSRF-Token': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        data:JSON.stringify(data),
        success: function(response) {
            console.log(response)
            $('#orders').html('');

            response.map((item,i)=>{
                let total = 0;
                item.menu_item.map((newitem)=>{
                    total += newitem.pivot.per * newitem.pivot.qty;
                });
                $('#orders').append(`
                        <tr>
                                <th scope="row">${i +1}</th>
                                <td>${item.customer.name}</td>
                                <td>${item.table.id} - ${item.table.name}</td>
                                <td><a href="/${item.id}-${item.unique_key}">${item.id}-${item.unique_key}</a></td>
                                <td>${total}</td>
                                <td>${item.order_recipient.name} ${item.order_recipient.family}</td>
                                <td>${item.status} </td>
                                <td>
                                    <button type="button" class="btn btn btn-primary py-2 px-4 text-white fw-semibold" onclick="init_view_modal(${item.id},'${item.unique_key}')">
                                        نمایش
                                    </button>
                                    <button type="button" class="btn btn btn-warning py-2 px-4 text-white fw-semibold" ${item.status== "finish" || item.status== "paid" ?"disabled":''} onclick="edit_order(${item.id},'${item.unique_key}')">
                                        ویرایش
                                    </button>
                                </td>
                        </tr>
                    `)
            })
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error(status, error);
        }
    });
}
const filter_time_refresh = (day) => {
    if (day == 'today'){
        $('#time_today').removeClass('btn-outline-primary').addClass('btn-primary')
        $('#time_yesterday').addClass('btn-outline-primary').removeClass('btn-primary')
        $('#time_older').addClass('btn-outline-primary').removeClass('btn-primary')
        data.today = true;
        data.yesterday = false;
        data.older = false;
    }
    else if(day =='yesterday') {
        $('#time_yesterday').removeClass('btn-outline-primary').addClass('btn-primary')
        $('#time_today').addClass('btn-outline-primary').removeClass('btn-primary')
        $('#time_older').addClass('btn-outline-primary').removeClass('btn-primary')
        data.today = false;
        data.yesterday = true;
        data.older = false;
    }
    else{
        $('#time_older').removeClass('btn-outline-primary').addClass('btn-primary')
        $('#time_today').addClass('btn-outline-primary').removeClass('btn-primary')
        $('#time_yesterday').addClass('btn-outline-primary').removeClass('btn-primary')
        data.older = true;
        data.today = false;
        data.yesterday = false;

    }
    refreshPage()
}
const filter_paid_refresh = () => {
    if(data.paid){
        data.paid = false;
    }
    else{
        data.paid = true;
    }
    refreshPage()
}
const edit_order = (id,unique_key) => {
    console.log(id)
    $.ajax({
        url: 'orders/edit/'+id+'-'+unique_key,
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
            $('#customer_name').val(response.customer.name);
            $('#customer_phone').val(response.customer.phone);

            init_modal();
            $('#edit_order').modal('show');
            ordersref()
            console.log(response);
        },

        error: function(xhr, status, error) {
            // Handle errors here
            console.error(status, error);
        }
    });
}
const init_modal = () => {
    $.ajax({
        url: 'orders/init_modal',
        method: 'get',
        headers:{
            'Content-Type' : 'application/json',
            'Accept' : 'application/json',
        },
        success: function(response) {
            menus = response.menus;
            initMenus(menus)
        },

        error: function(xhr, status, error) {
            // Handle errors here
            console.error(status, error);
        }
    });
}
const init_view_modal = (id,unique_key) => {
    $.ajax({
        url: 'orders/view/'+id+'-'+unique_key,
        method: 'get',
        headers:{
            'Content-Type' : 'application/json',
            'Accept' : 'application/json',
        },
        success: function(response)
        {
            console.log(response)
            $('#view_order_modal .items').html('');
            ordersItem = [];
            total = 0;
            response.menu_item.map((item,i)=>{
                // console.log(item)
                $('#view_order_modal .items').append(`<tr>
                            <td>${i}</td>
                            <td>${item.name}</td>
                            <td>${item.pivot.qty}</td>
                            <td>${item.pivot.per}</td>
                            <td>${item.pivot.per * item.pivot.qty}</td>

                        </tr>`);
                total += item.pivot.per * item.pivot.qty;
            });

            if (response.customer){
                $('#view_order_modal_label').text('سفارش '+response.customer.name+" عزیز");
            }
            else if (response.table){
                $('#view_order_modal_label').text('سفارش میز '+response.table.name);
            }
            else {
                $('#view_order_modal_label').text('سفارش '+response.id+"-"+response.unique_key);
            }

            if (response.status != 'paid' ){
                $('#view_order_modal #paid').attr('onclick',"paidding("+id+",'"+unique_key+"')");
            }
            else {
                $('#view_order_modal #paid').addClass('disabled').attr('disabled','disabled')
                $('#view_order_modal #finish').addClass('disabled').attr('disabled','disabled')
                $('#view_order_modal #delete').addClass('disabled').attr('disabled','disabled')
            }
            $('#view_order_modal #discount').text(response.discount);
            $('#view_order_modal #tax').text(0);
            $('#view_order_modal #total_all').text(total);
            $('#view_order_modal').modal('show');

            console.log(response);
        },

        error: function(xhr, status, error) {
            // Handle errors here
            console.error(status, error);
        }
    });
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
document.addEventListener('DOMContentLoaded',refreshPage)
const paidding = (id,unique_key) => {
    Swal.fire({
        title: `آیا تمایل به تصویه فاکتور ${unique_key}-${id} هستید .`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "تسویه !"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `orders/padding/${id}-${unique_key}`,
                method: 'post',
                headers:{
                    'Content-Type' : 'application/json',
                    'Accept' : 'application/json',
                    'X-CSRF-Token': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                data:JSON.stringify({
                    id : id,
                    unique_key : unique_key
                }),
                success: function(response) {

                    Swal.fire({
                        position: "top-end",
                        title:'تسویه شد .',
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });

                },
                error: function(xhr, status, error) {
                    console.error(xhr,status, error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: xhr.responseJSON,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });

        }
    });
}
const finishing = (id,unique_key) => {
    Swal.fire({
        title: ` فاکتور ${unique_key}-${id}برای مشتری ارسال شد .`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "اتمام !"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `orders/finish/${id}-${unique_key}`,
                method: 'post',
                headers:{
                    'Content-Type' : 'application/json',
                    'Accept' : 'application/json',
                    'X-CSRF-Token': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                success: function(response) {

                    Swal.fire({
                        position: "top-end",
                        title: 'فاکتور ارسال شد .' ,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });

                },
                error: function(xhr, status, error) {
                    console.error(xhr,status, error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: xhr.responseJSON,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });

        }
    });
}

