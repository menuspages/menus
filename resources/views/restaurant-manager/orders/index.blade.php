@extends('layouts.restaurant-manager-dashboard')

@section('content')
<div class="container">

    <div class="justify-content-between mt-4 mb-4 collapse">
        <h2>{{isset($type)? $type : 'الطلبات الجديدة'}}</h2>
        <button class="btn btn-outline-primary" onclick="window.location = '{{route('get-orders', auth()->user()->restaurant->subdomain) . ((isset($type) && $type === 'الطلبات السابقة')? '' : '?past=true')}}'">
            {{(isset($type) && $type === 'الطلبات السابقة')? 'الطلبات الجديدة' : 'الطلبات السابقة'}}
            <i class="fas fa-list"></i>
        </button>
    </div>
  
    <div class="total">
        @include('layouts.menu-partials.orders_summary_partial')
    </div>
    <label>
            <b>
            اختر الفرع
            </b>
    </label>    
    <div class="col-lg-4 col-md-12 col-sm-12">
        <form method="POST" action="/dashboard/orders">
            {{ csrf_field() }}
            <div class="d-flex my-2">
                <select class="form-control" id="location" name="location">
                    @foreach($shops as $item)
                    @if($location == $item)
                    <option selected>
                        @else
                    <option>
                        @endif
                        {{$item}}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                    تحديث
                </button>
            </div>
        </form>
    </div>
    <form method="POST" action="/dashboard/orders" style="display:none">
        {{ csrf_field() }}

        <div class="row">
            <div>
                <label>
                    From :
                </label>
                <input class="form-control" type="date" name="from_date">
            </div>

            <div>
                <label>
                    To :
                </label>
                <div style="display:flex">
                    <input class="form-control" type="date" name="to_date">
                    <button type="submit" class="btn btn-primary">
                        تحديث
                    </button>
                </div>
            </div>


        </div>
    </form>

    <div>
        @include('layouts.messages')
        <table class="table table-responsive w-100 d-block d-md-table table-bordered table-striped" id="users-table">
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>اسم العميل</th>
                    <th>رقم هاتف العميل</th>
                    <th>عنوان العميل</th>
                    <th>نوع التوصيل</th>
                    <th>ملحوظات</th>
                    <th>الاجمالي</th>
                    @if((isset($type) && $type === 'الطلبات السابقة'))
                    <th>ملحوظات الادمن</th>
                    @endif
                    <th>وقت الطلب</th>
                    <th>التفاصيل</th>
                </tr>
            </thead>
            @if(count($orders))
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td>
                        {{$index+1}}
                        @if($order->status === \App\Constants\constOrderStatus::NEW)
                        <img src="{{asset('images/new.ico')}}" alt="new" class="order-flag">
                        @elseif($order->status === \App\Constants\constOrderStatus::NOTICED)
                        <img src="{{asset('images/seen.ico')}}" alt="seen" class="order-flag">
                        @endif
                    </td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->customer_phone}}
                        @php
                        $whatsappLink = is_mobile()? "whatsapp://send?phone=$order->customer_phone" : "https://web.whatsapp.com/send?phone=$order->customer_phone";
                        @endphp
                        <a target="_blank" href="{{$whatsappLink}}" class="mr-1"><i class="fab fs-12 fa-whatsapp whatsapp"></i>
                        </a>
                    </td>
                    <td>{{$order->customer_address}}</td>
                    <td>{{$order->pickupLabel()}}</td>
                    <td>{{$order->customer_notes}}</td>
                    <td>{{$order->total}}</td>
                    @if((isset($type) && $type === 'الطلبات السابقة'))
                    <td>{{$order->admin_notes??'ﻻ يوجد'}}</td>
                    @endif
                    <td>{{$order->created_at->format('d-m-Y')}}</td>
                    <td>
                        @foreach($order->order_statuses as  $index=>$item)
                            @if($index == count($order->order_statuses)-1)
                                 <label id="lblordreStatus{{$order->id}}" for="">
                                     {{\App\Constants\constOrderStatus::getStatusByIndex($item->status)}} 
                                 </label>    
                            @endif         
                        @endforeach  
                        </td>
                        <td class="text-center" >
                                @if($order->status == 0)
                                
                                    <button class="btn  border" disabled>
                                         {{\App\Constants\constOrderStatus::getStatusByIndex(0  , true)}}       
                                    </button> 
                                @else
                                @foreach($order->order_statuses as  $index=>$item)
                                
                                    @if($index == count($order->order_statuses)-1)
                                    <button id="btnUpdateOrderStatus{{$item->status+1}}{{$order->id}}" onclick="updateStatus('{{$item->status+1}}' , '{{$order->id}}' , document.getElementById('btnCancelOrder{{$order->id}}'))" class="btn text-white btn-update-order-status btn-update-order-status-{{$item->status+1}} border">
                                         {{\App\Constants\constOrderStatus::getStatusByIndex($item->status+1)}}       
                                    </button>     
                                    @endif         
                                @endforeach  
                                @endif
                        </td>
                        <td class="text-center" >
                        <a href="{{route('show-order', ['subdomain'=> auth()->user()->restaurant->subdomain, 'id' => $order->id])}}" class="btn btn-outline-info">التفاصيل</a>
                        @foreach($order->order_statuses as  $index=>$item)
                                    @if($index == count($order->order_statuses)-1 && $item->status < 3 && $item->status >0)
                                    <button id="btnCancelOrder{{$order->id}}" onclick="CancelOrder(this,'{{$order->id}}' , document.getElementById('btnUpdateOrderStatus{{$item->status+1}}{{$order->id}}'),document.getElementById('btnUpdateOrderStatus{{$item->status+1+1}}{{$order->id}}'), document.getElementById('lblordreStatus{{$order->id}}'))" class="btn btn-danger btn-cancel-order-status text-white border">
                                         إلغاء     
                                    </button>     
                                    @endif         
                        @endforeach  
                    </td>
                </tr>
                @endforeach
            </tbody>
            @else
            <tr>
                <td colspan="9">ﻻ يوجد طلبات</td>
            </tr>
            @endif

        </table>
    </div>

    <div id="containerPagination" class="d-flex ">
        {{$orders->render()}}
    </div>
</div>

@endsection
@section('body-scripts')
<script>
    $(function()
    {
        $("#containerPagination").css({"overflow" : "auto"})
    })
    function hideAndDisableBtn(id)
    {
        $(id).attr('disabled', 'disabled');
        $(id).removeClass("text-white")
    }
    function CancelOrder(btnCancel ,order_id,btnUpdateStatus1 , btnUpdateStatus2 , lblordreStatus)
    {
        $("#btnCancelOrder").html('<i class="fas fa-spinner fa-pulse"></i>')
        $.ajax({
                type:"GET",
                url:"/dashboard/orders/cancel-order-status?order_id="+order_id,
                success : function(e)
                {
                    hideAndDisableBtn(btnUpdateStatus1)
                    hideAndDisableBtn(btnUpdateStatus2)

                    $(btnUpdateStatus1).text("ألغيت")
                    $(btnUpdateStatus2).text("ألغيت")
                    
                    $(btnUpdateStatus1).addClass("border")
                    $(btnUpdateStatus2).addClass("border")
                    
                    $(btnUpdateStatus1).css({"background-color" : "white"})
                    $(btnUpdateStatus2).css({"background-color" : "white"})
                    
                    $(btnCancel).hide();
                    $(lblordreStatus).text("ألغيت")
                }
          })  ;
    }
    function updateStatus(status ,order_id , btnCancel)
    {
        btnUpdateStatus = document.getElementById("btnUpdateOrderStatus"+status+order_id)
        $(btnUpdateStatus).html('<i class="fas fa-spinner fa-pulse"></i>')
          $.ajax({
                type:"GET",
                url:"/dashboard/orders/update-order-status?order_id="+order_id+"&status="+status,
                success : function(e)
                {
                    
                    var nextUpdateStatus = parseInt(status)+1;
                    if(nextUpdateStatus == 4)
                    {
                        hideAndDisableBtn(btnUpdateStatus)
                        $(btnCancel).hide();
                        $(btnUpdateStatus).addClass("border")
                    }
                    $("#lblordreStatus"+order_id).text(e.nextUpdatedStatus)
                    $(btnUpdateStatus).attr("id" , "btnUpdateOrderStatus"+nextUpdateStatus+order_id)
                    $(btnUpdateStatus).removeClass("btn-update-order-status-"+(nextUpdateStatus-1))
                    $(btnUpdateStatus).addClass("btn-update-order-status-"+nextUpdateStatus)
                    btnCancel
                    $(btnUpdateStatus).attr("onclick" , "updateStatus('"+(nextUpdateStatus)+"' , '"+order_id+"' ,'"+btnCancel+"')")
                    $(btnUpdateStatus).text(e.nextStatus)   
                }
          })  ;
    }   

    function doSearch(fr, t) {
        var d1 = fr.split("-");
        var d2 = t.split("-");
        var from = new Date(d1[2], d1[1] - 1, d1[0]);
        var to = new Date(d2[2], d2[1] - 1, d2[0]);
        var targetTable = document.getElementById('users-table');
        var targetTableColCount;
        for (var rowIndex = 0; rowIndex < targetTable.rows.length; rowIndex++) {
            var rowData = [];
            if (rowIndex == 0) {
                targetTableColCount = targetTable.rows.item(rowIndex).cells.length;
                continue;
            }

            for (var colIndex = 0; colIndex < targetTableColCount; colIndex++) {
                rowData.push(targetTable.rows.item(rowIndex).cells.item(colIndex).textContent);
            }

            for (var i = 0; i < rowData.length; i++) {
                var c = rowData[i].split("-");
                var check = new Date(c[2], c[1] - 1, c[0]);
                if ((check >= from) && (check <= to))
                    targetTable.rows.item(rowIndex).style.display = 'table-row';
                else
                    targetTable.rows.item(rowIndex).style.display = 'none';
            }

        }
    }

    $(document).ready(
        function() {
            $("#btn-filter").on('click', function() {
                to_date = $("#to_date").val();
                from_date = $("#from_date").val();

                console.log(to_date);
                console.log(from_date);

                if (to_date != '' && from_date != '') {
                    doSearch(from_date, to_date);
                } else {
                    alert("dates are not valid");
                }

            });
        }
    );
</script>
@endsection
