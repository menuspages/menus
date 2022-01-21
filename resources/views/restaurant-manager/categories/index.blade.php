@extends('layouts.restaurant-manager-dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-4 mb-4">
            <h2>قائمة الأصناف</h2>
            <button class="btn btn-outline-primary"
                    onclick="window.location = '{{route('create-category', request()->route('subdomain'))}}'">
                اضافة صنف
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <div>
            @include('layouts.messages')
            <table class="table table-responsive w-100 d-block d-md-table table-bordered table-striped" id="users-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الصنف</th>
                    <th>الصورة</th>
                    <th></th>
                </tr>
                </thead>
                @if(count($categories))
                    <tbody id="tbl_categories_body" >
                    @foreach($categories as $index => $category)
                        <tr id="row_{{$category->id}}" >
                            <td> {{$index+1}}</td>
                            <td> 
                                <div class="row mx-4" >
                                    <div class="mx-2" >
                                        <!-- 0 for move to down and 1 for move to up -->
                                        <i class="fa fa-angle-up" onclick="replaceElements(document.getElementById('row_{{$category->id}}') , 1)" ></i>
                                        <br>
                                        <br>
                                        <i class="fa fa-angle-down" onclick="replaceElements(document.getElementById('row_{{$category->id}}') , 0)" ></i>
                                    </div>    

                                    <div>
                                        {{explode('---',$category->name)[0]}}
                                    </div>    
                                </div>
                        </td>
                            @if($category->image_path)
                                <td>
                                    <img loading="lazy" src="/{{$category->imageUrl()}}" alt="{{$category->name}}"
                                         class="details-image"
                                         aria-view=true>
                                </td>
                            @else
                                <td>ﻻ يوجد</td>
                            @endif
                            <td>
                                
                                <a href="{{route('edit-category', ['subdomain'=> request()->route('subdomain') ,'id'=>$category->id])}}"><i
                                        class="fas fa-pencil-alt text-secondary"></i></a>

                                <form class="d-inline"
                                      action="{{route('categories-delete-category',['id'=>$category->id,'subdomain'=> request()->route('subdomain')])}}"
                                      method="POST">
                                    @method('delete')
                                    @csrf()
                                    <a href="#" onclick="confirmDeletion(event)"><i
                                            class="fas fa-trash text-danger"></i></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tr>
                        <td colspan="8">ﻻ يوجد أصناف</td>
                    </tr>
                @endif

            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{$categories->render()}}
        </div>
    </div>

@endsection

@section('body-scripts')
    <script>
        function confirmDeletion(event) {
            if (confirm('هل تريد حذف الصنف؟ (هذا يتسبب في حذف المنتجات التابعة له)')) {
                $(event.target).closest('form').submit();
            }
        }
        function replaceElements(tag , direction)
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
            
            $("#tbl_categories_body tr").each(function(i,a)
            {
                  var id = $(this).attr('id').split("_")[1]
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
    </script>
    @include('layouts.image-viewer')
@endsection
