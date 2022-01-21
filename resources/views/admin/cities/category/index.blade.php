
@extends('layouts.admin-dashboard')

@section('content')


    <div class="container">
        <div class="d-flex justify-content-between mt-4 mb-4">
            <h2>قائمة المدن</h2>
            <a class="btn btn-outline-primary" href="/category/add-category">
            أضف فئة   
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <div>
            <table class="table table-bordered table-responsive table-striped full-table">
               <thead>
               <tr>
                    <th>#</th>
                   
                    <th>اسم المدينة</th>
                    <th></th>
                   
                  
                </tr>
               </thead>
               <tbody>

               @if(count($category))
                    @foreach($category as $index => $category)
                        <tr id="{{$category->id}}" >
                            <td>{{$index+1}}</td>
                           
                            <td>{{$category->name}}</td>
                          
                            <td> 
                                        <i class="fa fa-trash" onclick="confirmDeletion({{$category->id}})" >

                                        </i>

                                         <a href="/category/add-category?id={{$category->id}}">
                                         <i class="fa fa-edit"  >

                                        </i>
                                         </a>   

                             </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">لا توجد فئات</td>
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
                    url: '/category/delete-category?id='+id,
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










































