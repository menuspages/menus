@extends('layouts.restaurant-manager-dashboard')

@section('head-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

@endsection

@section('content')
<button class="mx-4 btn btn-primary" id="btnPrint" onclick="printOrder()" >
طباعة       
        </button>
<div class="collapse" id="containerRecp" >
            
        <div>
            <img loading="lazy" src="/{{Auth::user()->restaurant->logoUrl()}}" alt="" width="100" height="100" class="border pull-left" style="">

        </div>
        <br>
        <div>
                <h3 class="text-center" >
                    @foreach(explode('/', Auth::user()->restaurant->name) as $info)
                                    {{$info}}
                        @endforeach
                </h3>
                
        </div>
        <div>
                <h5 class="text-center grey" >
                    {{Auth::user()->restaurant->subdomain}}
                </h5>
        </div>
        
        <hr>
        <div class="container"  >
        <dl class="row">
                    <dt class="col-sm-5 mt-2">اسم العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_name}}</dd>

                    <dt class="col-sm-5 mt-2">
                        رقم هاتف العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_phone}}</dd>

                    <dt class="col-sm-5 mt-2">
                        عنوان العميل

                    </dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_address}}</dd>

                    <dt class="col-sm-5 mt-2">
                        نوع التوصيل

                    </dt>
                    <dd class="col-sm-7 mt-2">{{$order->pickupLabel()}}</dd>

                    <dt class="col-sm-5 mt-2">
                        نوع التحويل

                    </dt>
                    <dd class="col-sm-7 mt-2">
                    
                    @if(isset($order->transfer_type->transfer_type))
                    <div>
                        {{$order->transfer_type->transfer_type}}       
                    </div>
                   @endif

                    @if(isset($order->transfer_type->image_path))
                    <div>
                        <img class="border" src="/{{$order->transfer_type->image_path}}" style="object-fit: contain;" width="50" height="50" aria-view="true" alt="">
                    </div>
                   @endif
                
                </dd>

                    <dt class="col-sm-5 mt-2">ملاحظات العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_notes}}</dd>

                    <dt class="col-sm-5 mt-2">الاجمالي</dt>
                    <dd class="col-sm-7 mt-2">{{$order->total}} ريال</dd>

                    @if($order->location != "null")
                    <dt class="col-sm-5 mt-2">اختر الفرع</dt>
                    <dd class="col-sm-7 mt-2">{{$order->location}} </dd>
                    @endif

                    <dt class="col-sm-5 mt-2">تم الانشاء</dt>
                    <dd class="col-sm-7 mt-2">{{$order->created_at->format('Y-m-d h:i A')}}</dd>

                    @if($order->noticed_at)
                        <dt class="col-sm-5 mt-2">تم الاطلاع علي الطلب</dt>
                        <dd class="col-sm-7 mt-2">{{$order->noticed_at->format('Y-m-d h:i A')}}</dd>
                    @endif

                    @if($order->finished_at)
                        <dt class="col-sm-5 mt-2">تم انهاء الطلب</dt>
                        <dd class="col-sm-7 mt-2">{{$order->finished_at->format('Y-m-d h:i A')}}</dd>
                    @endif

                    @if($order->admin_notes)
                       <dt class="col-sm-5 mt-2">ملاحظات الادمن</dt> 
                        <dd class="col-sm-7 mt-2">{{$order->admin_notes}}</dd>
                    @endif

                    @foreach($order->items as $Item)
                        <dt class="col-sm-5 mt-2 collapse">المنتج</dt> 
                        <dd class="col-sm-7 mt-2 collapse">
                           <div class="border px-2 py-2 collapse" >
                                <b> 
                                    @if($Item->type == "note")
                                        *{{$Item->name}}*    
                                    @else 
                                        {{$Item->type}}    
                                    @endif
                                </b>
                                   
                            </div> 
                        </dd>
                    @endforeach 
                    <br>
                    <br>
                    <br>   
                </dl>
                <table class="table" >
                              <thead>
                                  <th>
                                  اسم

                                  </th>
                                  <th>
                                  كمية

                                  </th>
                                  <th>
                                  المجموع الفرعي

                                  </th>
                              </thead>
                              <tbody>
                              @foreach($order->orderItems as $orderItem)
                                    <tr>
                                        <td>
                                        @if(isset($orderItem->item))
                                        <img class="border border-radius-10 px-2 py-2" src="/{{$orderItem->item->image_path}}" alt="{{$orderItem->item_name}}"
                                             height="50px" width="50px" aria-view="true">
                                    @else
                                        <img src="{{asset('images/no-image-available.png')}}"
                                             alt="{{$orderItem->item_name}}" height="50px" width="50px">
                                    @endif
                                       
                                          {{$orderItem->item_name}}
                                        <br>
                                          @foreach(json_decode($orderItem->sub_details_note) as $item)
                                                @if($item[2] == "item")
                                                <div class="border px-2 my-2" style="display:inline-block;border-radius:100px;" >

                                                  <i class="fa fa-check" style="font-size:10px;color:green"  >  </i>    
                                                    {{ $item[0]}} 
                                                  </div>   
                                                 <br>       
                                                @endif
                                          
                                        @endforeach            
                                        </td>
                                        <td>
                                             {{$orderItem->quantity}}
                                         </td>
                                         <td>
                                             {{$orderItem->quantity * $orderItem->price_per_unit }}
                                         </td>
                                    </tr>
                              @endforeach
                              </tbody>
                        </table>
        </div>
        
        </div>
    <div class="container " id="containerContent" >
       
        <div class="d-flex mt-4 mb-4" id="test" >
            <h2>تفاصيل الطلب</h2>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <dl class="row">
                    <dt class="col-sm-5 mt-2">اسم العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_name}}</dd>

                    <dt class="col-sm-5 mt-2">
                        رقم هاتف العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_phone}}</dd>

                    <dt class="col-sm-5 mt-2">
                        عنوان العميل

                    </dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_address}}</dd>

                    <dt class="col-sm-5 mt-2">
                        نوع التوصيل

                    </dt>
                    <dd class="col-sm-7 mt-2">{{$order->pickupLabel()}}</dd>

                    <dt class="col-sm-5 mt-2">
                        نوع التحويل

                    </dt>
                    <dd class="col-sm-7 mt-2">
                    
                    @if(isset($order->transfer_type->transfer_type))
                    <div>
                        {{$order->transfer_type->transfer_type}}       
                    </div>
                   @endif

                    @if(isset($order->transfer_type->image_path))
                    <div>
                        <img class="border" src="/{{$order->transfer_type->image_path}}" style="object-fit: contain;" width="50" height="50" aria-view="true" alt="">
                    </div>
                   @endif
                
                </dd>

                    <dt class="col-sm-5 mt-2">ملاحظات العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$order->customer_notes}}</dd>

                    <dt class="col-sm-5 mt-2">الاجمالي</dt>
                    <dd class="col-sm-7 mt-2">{{$order->total}} ريال</dd>

                    @if($order->location != "null")
                    <dt class="col-sm-5 mt-2">اختر الفرع</dt>
                    <dd class="col-sm-7 mt-2">{{$order->location}} </dd>
                    @endif

                    <dt class="col-sm-5 mt-2">تم الانشاء</dt>
                    <dd class="col-sm-7 mt-2">{{$order->created_at->format('Y-m-d h:i A')}}</dd>

                    @if($order->noticed_at)
                        <dt class="col-sm-5 mt-2">تم الاطلاع علي الطلب</dt>
                        <dd class="col-sm-7 mt-2">{{$order->noticed_at->format('Y-m-d h:i A')}}</dd>
                    @endif

                    @if($order->finished_at)
                        <dt class="col-sm-5 mt-2">تم انهاء الطلب</dt>
                        <dd class="col-sm-7 mt-2">{{$order->finished_at->format('Y-m-d h:i A')}}</dd>
                    @endif

                    @if($order->admin_notes)
                       <dt class="col-sm-5 mt-2">ملاحظات الادمن</dt> 
                        <dd class="col-sm-7 mt-2">{{$order->admin_notes}}</dd>
                    @endif

                    @foreach($order->items as $Item)
                        <dt class="col-sm-5 mt-2 collapse">المنتج</dt> 
                        <dd class="col-sm-7 mt-2 collapse">
                           <div class="border px-2 py-2 collapse" >
                                <b> 
                                    @if($Item->type == "note")
                                        *{{$Item->name}}*    
                                    @else 
                                        {{$Item->type}}    
                                    @endif
                                </b>
                                   
                            </div> 
                        </dd>
                    @endforeach    
                    <dt class="col-sm-5 mt-2">المنتجات</dt>
                    <dd class="col-sm-7 mt-2">
                        <ul class="list-group ">
                            @foreach($order->orderItems as $orderItem)
                                <li class="list-group-item my-2  align-items-center" style="border-radius:10px" >
                                    
                                <div class="d-flex" >
                                    
                                    @if(isset($orderItem->item))
                                        <img src="/{{$orderItem->item->image_path}}" alt="{{$orderItem->item_name}}"
                                             height="50px" width="50px" aria-view="true">
                                    @else
                                        <img src="{{asset('images/no-image-available.png')}}"
                                             alt="{{$orderItem->item_name}}" height="50px" width="50px">
                                    @endif
                                    <div class="grid mx-2" >
                                        {{$orderItem->item_name}}
                                        <strong>{{$orderItem->quantity}}</strong>
                                    </div>
                                </div>
                                            
                                     @if($orderItem->sub_details_note)
                                    <div class="mx-2 py-2 " >
                                        @foreach(json_decode($orderItem->sub_details_note) as $item)
                                                @if($item[2] == "item")
                                                <div class="border px-2 my-2" style="display:inline-block;border-radius:100px;" >

                                                  <i class="fa fa-check" style="font-size:10px;color:green"  >  </i>    

                                                    {{ $item[0]}} 
                                                  </div>   
                                                 <br>       
                                                @endif
                                          
                                        @endforeach                              
                                    </div>    
                                    @endif
                                    @if($orderItem->sub_details_note)
                                        @foreach(json_decode($orderItem->sub_details_note) as $item)
                                                @if($item[2] == "note")
                                                <div class="border px-2 my-2 mx-2" style="display:inline-block;border-radius:100px;" >
                                                    <b>*{{ $item[0]}}*   </b>
                                                </div>   
                                                <br>    
                                                @endif
                                           
                                        @endforeach                              
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </dd>


                </dl>
            </div>
            @if(!$order->isFinished())
                <div class="col-lg-6 col-md-12">
                    <form
                        action="{{route('finish-order', ['id'=> $order->id, 'subdomain' => auth()->user()->restaurant->subdomain])}}"
                        method="POST">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="admin_notes">ملاحظات الادمن</label>
                            <textarea name="admin_notes" class="form-control" id="admin_notes" cols="20"
                                      rows="5"></textarea>
                        </div>
                        <input type="submit" class="btn btn-outline-success" value="انهاء الطلب">
                    </form>
                </div>
            @endif
        </div>
        <div class="row" >
               @foreach($order->order_statuses as $item)
                <div class="d-grid border  col-lg-12 px-4 my-2 py-2" >
                        <div class="width-min-content" >
                         
                            <button style="display:inline-block" class="width-100 btn text-white btn-update-order-status-{{$item->status}}" >
                            {{\App\Constants\constOrderStatus::getUpdatedStatusByIndex($item->status)}} 
                            </button>
                        </div>
                      <div class="my-2 d-grid" >
                         @if($item->user_id > 0) 
                        <label>
                               <b> {{$item->user->name}}</b>
                        </label>
                        @endif
                         <label class="text-grey" >
                                {{ $item->created_at->format('d-m-Y h:m:s')}}
                        </label>
                      </div>
                       
                </div> 
               @endforeach 
        </div>
        @include('layouts.image-viewer')
    </div>
@endsection
@if($order->status === \App\Constants\constOrderStatus::NEW)
@section('body-scripts')
    <script>
        axios.patch('{{route('notice-order', ['id' => $order->id, 'subdomain' => auth()->user()->restaurant->subdomain])}}')
    </script>
@endsection
@endif
<script>
    window.addEventListener('afterprint', function()
    {
        $("#btnPrint").toggleClass("collapse");
        $("#containerContent").toggleClass("collapse");
        $("#containerRecp").toggleClass("collapse");
    } 
        
    );
    function printOrder()
    {
        $("#btnPrint").toggleClass("collapse");
        $("#containerContent").toggleClass("collapse");
        $("#containerRecp").toggleClass("collapse");
        
        print()
    }
</script>