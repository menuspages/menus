@extends('layouts.restaurant-manager-dashboard')

<style>
    .category-header
    {
        position:relative;
    }
    .container-btn-shifting {

        position: absolute;
    top: 12%;
    z-index: 10;
    left: 10%;
    }
    .container-btn-shifting i 
    {
        background-color:#9fcbe3;
        margin:3px;
        color:white;
        padding:2px 4px 2px 4px;
    }
    .limited-width-250px 
    {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .limited-width-150px{
        width: 150px;
        justify-content: inherit;
    }
    .icon-round {
        padding: 6px 10px 6px 10px;
        background-color: white;
        border-radius: 100px;
    }
    .bg-brown {
        background-color: brown !important;
        color: white !important;
    }
    .fa-2x 
    {
        font-size: 1.5em !important;
    }
    .bg-dark-grey {
        border-color :#c7c7c7 !important; 
        background-color:#c7c7c7 !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-4 mb-4">
            <h2>قائمة المنتجات</h2>
            <button class="btn btn-outline-primary"
                    onclick="window.location = '{{route('create-item', request()->route('subdomain'))}}'">
                اضافة منتج
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <div>
            @include('layouts.messages')
<input id="myInput" class="form-control col-lg-4 col-md-12 col-sm-12 my-4"  type="text" placeholder="Search..">
<div>
@foreach($restaurant->categories->sortBy('priority') as $CategoryIndex => $category)
@foreach(explode('---', $category->name ) as $index => $info)

@if($index == 0)
<div class="parent-items" id="parent_items_{{$category->id}}" >    
<div  class="alert category-header alert-info bg-dark-grey " style="cursor:pointer;display:flex;justify-content:space-between" >  
<b class="limited-width-250px" >{{$info}}</b>

    <div class="d-flex align-items-center limited-width-150px" >
        <i class="icon-round fa fa-angle-up fa-2x" onclick="replaceElementsCategories(document.getElementById('parent_items_{{$category->id}}') , 1)" ></i>
        <i class="icon-round fa fa-angle-down fa-2x" onclick="replaceElementsCategories(document.getElementById('parent_items_{{$category->id}}') , 0)" ></i>
        <i onclick="toggleItems(document.getElementById('categoryItems_{{$CategoryIndex}}'))" id="categoryItem_{{$CategoryIndex}}" class="fa fa-angle-down icon-round bg-brown fa-2x" ></i>
    </div>
</div>  
<table class="table table-responsive w-100 d-md-table table-bordered table-striped"
id="categoryItems_{{$CategoryIndex}}">
                <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المنتج</th>
                    <th>وصف المنتج</th>
                    <th>السعر الحالي</th>
                    <th>الصنف</th>
                    <th>مرئي</th>
                    <th>متاح</th>
                    <th>الصورة</th>
                    <th>Quantity</th>
                    <th></th>
                </th>   
                </tr>
                </thead>
                
                <tbody id="tbody_{{$category->id}}" >
                        @foreach($category->items->sortBy('priority') as $item)
                        <tr class="
                            
                            {{$item->quantity_summary? 
                                $item->quantity_summary['input_quantity_summary'] == 1 ? 
                                $item->quantity_summary['remaining'] == 0? 
                            'disabled' : ''
                            : ''
                                 : ''}}
                            "    
                        id="row_{{$item->id}}"
                        
                        >
                           
                            <td>{{$index+1}}
                            <div class="out-of-stock collapse" >
                                 <label class="no-margin" for="">
                                     <b>
                                         Out of Stock
                                     </b>
                                     </label>
                            </div>      
                            <div class="mx-2" >
                                            <!-- 0 for move to down and 1 for move to up -->
                                            <i class="icon-round fa-2x fa fa-angle-up" onclick="replaceElements(document.getElementById('row_{{$item->id}}') ,1, 'tbody_{{$category->id}}')" ></i>
                                            <br>
                                            <br>
                                            
                                            <i class="icon-round fa-2x fa fa-angle-down" onclick="replaceElements(document.getElementById('row_{{$item->id}}'),0, 'tbody_{{$category->id}}' )" ></i>
                                        </div>   
                            </td>
                            <td>
                                <div class="row" >
                                       <div class="px-2" >
                                            {{$item->name}}
                                        </div>     
                                       
                                    </div>
                            </td>
                            <td>{{$item->description??'ﻻ يوجد'}}</td>
                            @if($item->current_price > $item->old_price)
                                <td>{{$item->current_price}} ريال</td>
                            @else
                                <td>
                                    <span class="d-block fs-12">{{$item->current_price}} ريال</span>
                                    <span class="strike">{{$item->old_price}} ريال</span>
                                </td>
                            @endif
                            <td>{{isset($item->category)? $item->category->name : 'ﻻ يوجد'}}</td>
                            <td class="{{$item->is_visible? 'bg-success': 'bg-danger'}} align-middle text-center">{{$item->is_visible? 'مرئي' : 'غير مرئي'}}</td>
                            <td class="{{$item->is_available? 'bg-success': 'bg-danger'}} align-middle text-center">{{$item->is_available? 'متاح' : 'غير متاح'}}</td>
                            @if($item->image_path)
                                <td>
                                    <img loading="lazy" src="/{{$item->image_path}}" alt="{{$item->name}}"
                                         class="details-image"
                                         aria-view=true
                                    >
                                </td>
                            @else
                                <td>ﻻ يوجد</td>
                            @endif
                           
                            <td>

                                <div id="quantitySummary{{$item->id}}" >
                                    @if($item->quantity_summary && $item->quantity_summary['total'] != null)

                                    <div  >
                                        <label class="line-height margin-0" for="">
                                            <table>
                                                <tr>
                                                    <td>
                                                    <label class="" for="">
                                                        <b>     
                                                            {{$item->quantity_summary['remaining']}}
                                                        </b>
                                                    </label>                                                        
                                                    </td>
                                                    <td>
                                                        Remaining
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <label  for="">
                                                        <b>     
                                                            {{$item->quantity_summary['total']}}
                                                        </b>
                                                    </label>                                                        
                                                    </td>
                                                    <td>
                                                        Total
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <label  for="">
                                                        <b>     
                                                            {{$item->quantity_summary['target']}}
                                                        </b>
                                                    </label>                                                        
                                                    </td>
                                                    <td>
                                                        Target
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </label>
                                        
                                 </div>
                                     
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="px-2 py-2" >
                                    <a href="{{route('edit-item', ['subdomain'=> request()->route('subdomain') ,'id'=>$item->id])}}"><i
                                            class="fas fa-pencil-alt text-secondary"></i></a>

                                </div>
                                <div class="px-2 py-2" >
                                    <form class="d-inline"
                                        action="{{route('delete-item',['id'=>$item->id,'subdomain'=> request()->route('subdomain')])}}"
                                        method="POST">
                                        @method('delete')
                                        @csrf()
                                        <a href="#" onclick="confirmDeletion(event)"><i
                                                class="fas fa-trash text-danger"></i></a>
                                    </form>
                                </div>          
                              
                            </td>
                        </tr>     
@endforeach
</tbody>
</table>
</div>
@endif
@endforeach
@endforeach
</div>
        </div>

        <div class="d-flex justify-content-center">
            {{$items->render()}}
        </div>
    </div>

@endsection

@section('body-scripts')
<script>

$(function()
{
    checkIfInStock()
});
function checkIfInStock()
{
    $('.disabled').find('.out-of-stock').removeClass('collapse');
}
function replaceElementsCategories(tag , direction)
{
    if(direction == 1)
            {
                $(tag).insertBefore($(tag).prev());
            }   
            else 
            {
                $(tag).insertAfter($(tag).next());   
            }             
            priorities = []
            
            $(".parent-items").each(function(i,a)
            {
                  var id = $(this).attr('id').split("_")[2]
                  priorities.push(
                      {"id":id , "pr":i}
                  )

            });
            var data = { 
                "items" : priorities
            }
            $.ajax({
                   url: "/dashboard/categories/set-priority",
                    type: "get",
                    data: data, 
                    success: function (response) {
                        console.log(response)
                        // cartTotalItems();
                    // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    }
                });
}

function replaceElements(tag , direction , tbody_id)
        {

            if(direction == 1)
            {
                $(tag).insertBefore($(tag).prev());
            }   
            else 
            {
                $(tag).insertAfter($(tag).next());   
            }             
            priorities = []
            
            $("#" +tbody_id+ " tr").each(function(i,a)
            {
                  
                  var id = $(this).attr('id').split("_")[1]
                  priorities.push(
                      {"id":id , "pr":i}
                  )

            });
            var data = { 
                "items" : priorities
            }
            console.log(data)
            $.ajax({
                   url: "/dashboard/items/set-priority",
                    type: "get",
                    data: data, 
                    success: function (response) {
                        console.log(response)
                        // cartTotalItems();
                    // You will get response from your PHP page (what you echo or print)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    }
                });
        }

function toggleItems(tag)
{
    $(tag).slideToggle();
}
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

        function confirmDeletion(event) {
            if (confirm('هل تريد حذف المنتج؟')) {
                $(event.target).closest('form').submit();
            }
        }
    </script>
    @include('layouts.image-viewer')
@endsection
