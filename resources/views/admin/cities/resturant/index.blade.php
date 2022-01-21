
@extends('layouts.admin-dashboard')

@section('content')


    <div class="container">
        <div class="d-flex justify-content-between mt-4 mb-4">
            <h2>قائمة المدن</h2>
            <a class="btn btn-outline-primary" href="/city-restaurants/add-city-restaurants">
            إضافة مطعم 
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <div>
            <table class="table table-bordered table-responsive table-striped full-table">
               <thead>
               <tr>
                    <th>#</th>
                   
                    <th>صورة </th>
                    <th>اسم المدينة</th>
                    <th>وصف</th>
                    <th>ارتباط القائمة</th>
                    <th>ارتباط الخريطة</th>
                    <th>هاتف</th>
                    
                    <th></th>
                   
                  
                </tr>
               </thead>
               <tbody>

               @if(count($restaurant))
                    @foreach($restaurant as $index => $item)
                        <tr id="{{$item->id}}" >
                            <td>{{$index+1}}</td>
                           
                            <td> <img id="image_preview" src="data:image/png;base64,{{$item->image}}" width="70" height="70" /> <td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->menu_link}}</td>
                            <td>{{$item->map_link}}</td>
                            <td>{{$item->phone}}</td>
                            
                          
                            <td> 
                                        <i class="fa fa-trash" onclick="confirmDeletion({{$item->id}})" >

                                        </i>

                                         <a href="/city-restaurants/add-city-restaurants?id={{$item->id}}">
                                         <i class="fa fa-edit"  >

                                        </i>
                                         </a>   

                             </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10"> لا توجد مطاعم </td>
                    </tr>
               
               </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection

@section('body-scripts')
    @include('layouts.image-viewer')


<style>

.dataTables_filter input 
{
    outline: none;
    padding:6px;
}

.dataTables_length label font font{
  display: none;
}

#DataTables_Table_0_filter label font font{
  display: none;
}

.dataTables_info {
    margin-bottom: 10px;
}

.dataTables_paginate a
{
    background-color:#c0c0c1;
    margin-top:10px;
    color:black;
    padding:10px;
    cursor: pointer;
}

</style>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"> </script>

<!--Data Table-->
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script>

$(document).ready( function () {
    $('.table').DataTable();
} );

        function confirmDeletion(id) {
            
            if (confirm('هل تريد حذف المتجر؟')) 
            {
                $.ajax({
                    url: '/city-restaurants/delete-city-restaurants?id='+id,
                    type: 'GET',
                    success : function()
                    {
                        $("#"+id).hide();
                    },  
                    
                });
            }
        }
    </script>
@endsection










































