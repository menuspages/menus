@extends('layouts.restaurant-manager-dashboard')

@section('content')

    <div class="container">
        <div class="mt-4">
            <h2>تعديل منتج</h2>
        </div>

        <form action="{{route('update-item', ['subdomain'=>request()->route('subdomain'), 'id'=> $item->id])}}"
                  method="POST"
                  enctype="multipart/form-data">
        <div class="row" >

        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')

                {{csrf_field()}}
                @method('patch')

                <input type="text" class="item-id collapse"  value="{{$item->id}}" >

                <div class="form-group">
                    <label for="name">اسم المنتج</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم المنتج"
                           value="{{$item->name}}"
                           required>
                </div>
                <div class="form-group">
                    <label for="description">وصف المنتج</label>
                    <textarea
                        name="description"
                        class="form-control"
                        id="description"
                        cols="30"
                        rows="3"
                        placeholder="ادخل وصف المنتج">{{$item->description}}</textarea>
                </div>

                @if(count($categories))
                    <div class="form-group">
                        <label for="category_id">اختر صنف للمنتج</label>
                        <select name="category_id" id="category_id" class="custom-select">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                        class="form-control" {{($category->id == $item->category_id)? 'selected="selected"': ''}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <br>
                    <div class="form-group">
                        <p>لا يوجد اصناف، من فضلك اضغط هنا لاضافة صنف <a
                                href="/dashboard/categories/create?r=create-item"><i
                                    class="fas fa-external-link-alt"></i></a></p>
                    </div>
                @endif
                <div class="form-group">
                    <label for="new">الجديد</label>
                    <input type="checkbox" name="new" id="new" value="1" >
                 </div>
                <div class="form-group">
                    <label for="current_price">السعر الحالي</label>
                    <input type="text" name="current_price" id="current_price" class="form-control w-50"
                           placeholder="ادخل السعر الحالي"
                           value="{{$item->current_price}}"
                           >
                </div>
                <div class="form-group">
                    <label for="old_price">السعر القديم</label>
                    <input type="text" name="old_price" id="old_price" class="form-control w-50"
                           value="{{$item->old_price}}"
                           placeholder="ادخل السعر القديم">
                </div>

                <div class="form-group">
                    <label for="calories">السعرات الحرارية</label>
                    <input type="number" name="calories" id="calories" class="form-control w-50"
                           step=".01"
                           value="{{$item->calories}}"
                           placeholder="ادخل السعرات الحرارية">
                </div>

                <div class="form-group">
                    <label for="is_visible">مرئي</label>
                    <select name="is_visible" id="is_visible" class="custom-select">
                        <option value="1" {{$item->is_visible? 'selected="selected"': ''}}>مرئي</option>
                        <option value="0" {{$item->is_visible? '': 'selected="selected"'}}>غير مرئي</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="is_available">متاح</label>
                    <select name="is_available" id="is_available" class="custom-select">
                        <option value="1" {{$item->is_available? 'selected="selected"': ''}}>متاح</option>
                        <option value="0" {{$item->is_available? '': 'selected="selected"'}}>غير متاح</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">صورة للمنتج ( او اترك القديمة)</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>


        </div>

        <div class="col-lg-6 col-md-12 row px-4" style="display:block" >
         <div class="px-2" >
               <div  class="row align-items-center" >
                   
                    <input type="checkbox" {{ !is_null(json_decode($item->allergens)) ? count(json_decode($item->allergens))  > 0 ? 'checked' : '' : '' }} onchange="enableAllergens(this)" value="1" >
                    <h3 class="mx-2" >
                        <b>
                            Set Allergens
                        </b>
                    </h3>
                </div>
                <div class="direction-ltr {{ !is_null(json_decode($item->allergens)) ? count(json_decode($item->allergens))  > 0 ? '' : 'collapse' : 'collapse' }}" id="containerAllergens" >
                          <div class="form-group" id="" >
                                    <label for="">
                                        <b> celery </b>
                                    </label>
                                    <img src="/public/allergens/celery.png" class="celery  icon-allergens border-radius-100" width="25" height="25" alt="">
                                    <input type="checkbox" value="celery.png" name="allergens[]" {{ !is_null(json_decode($item->allergens)) ? in_array('celery.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >
                            </div>
                            <div class="form-group" >
                                    <label for="">
                                        <b> crustacean </b>
                                    </label>
                                    <img src="/public/allergens/crustacean.png" class=" crustacean icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="crustacean.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ?in_array('crustacean.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }}  >

                            </div>
                            <div class="form-group" >
                                    <label for="">
                                        <b> eggs </b>
                                    </label>
                                    <img src="/public/allergens/eggs.png" class=" icon-allergens eggs border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="eggs.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('eggs.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> fish </b>
                                    </label>
                                    <img src="/public/allergens/fish.png" class=" icon-allergens fish border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="fish.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('fish.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> gulten</b>
                                    </label>
                                    <img src="/public/allergens/gulten.png" class=" icon-allergens gulten border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="gulten.png" name="allergens[]"   {{ !is_null(json_decode($item->allergens)) ? in_array('gulten.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }}>

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> lupins </b>
                                    </label>
                                    <img src="/public/allergens/lupins.png" class=" lupins icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="lupins.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('lupins.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> milk </b>
                                    </label>
                                    <img src="/public/allergens/milk.png" class=" milk icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="milk.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('milk.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> mustard </b>
                                    </label>
                                    <img src="/public/allergens/mustard.png" class=" mustard icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="mustard.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('mustard.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> nuts</b>
                                    </label>
                                    <img src="/public/allergens/nuts.png" class=" nuts icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="nuts.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('nuts.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> peanuts </b>
                                    </label>
                                    <img src="/public/allergens/peanuts.png" class="peanuts icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="peanuts.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('peanuts.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> sesame </b>
                                    </label>
                                    <img src="/public/allergens/sesame.png" class=" sesame icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="sesame.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('sesame.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> shellfish </b>
                                    </label>
                                    <img src="/public/allergens/shellfish.png" class=" shellfish icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="shellfish.png" name="allergens[]"  {{ !is_null(json_decode($item->allergens)) ? in_array('shellfish.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }} >

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> soya </b>
                                    </label>
                                    <img src="/public/allergens/soya.png" class=" soya icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="soya.png" name="allergens[]"   {{ !is_null(json_decode($item->allergens)) ? in_array('soya.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }}>

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> sulphite </b>
                                    </label>
                                    <img src="/public/allergens/sulphite.png" class=" sulphite icon-allergens border-radius-100" width="25" height="25" alt="">

                                    <input type="checkbox" value="sulphite.png" name="allergens[]" {{ !is_null(json_decode($item->allergens)) ? in_array('sulphite.png',json_decode($item->allergens))  == true ? 'checked' : '' : '' }}>

                            </div>
                </div>    
           </div>
            <div class="px-2" >
            <div class="row align-items-center" >
            <input type="checkbox" {{  $item->quantity_summary  ? $item->quantity_summary['input_quantity_summary'] == 1 ? 'checked' : '' : '' }} name="input_quantity_summary" onchange="enableProductQuantity(this)" value="1" >
            <h3 class="mx-2" >
                <b>
                    Set Quantity
                </b>
            </h3>
           </div>
           <div class="{{ $item->quantity_summary ? $item->quantity_summary['input_quantity_summary'] == 1 ? '' : 'collapse' : 'collapse' }}" id="containerQuantitySummary" >
            <div class="form-group" >
                            <label for="">
                                <b>  Target Quantity </b>
                            </label>
                            <input type="text" value="{{ $item->quantity_summary ? $item->quantity_summary['target'] : '' }}" name="input_target_quantity" onclick="showPopUp('Item will be out of stock when reach at this quantity')" class="form-control" >
                    </div>
                    <div class="form-group" >
                            <label for="">
                                <b> Total Quantity </b>
                            </label>
                            <input type="text" value="{{ $item->quantity_summary ? $item->quantity_summary['total'] : '' }}" name="input_total_quantity" class="form-control" >

                    </div>
           </div> 

            </div>

                <div class="mt-4">
                    <h2> التفاصيل الفرعية </h2>
                </div>
               <div class="px-2 border-radius-10 border py-2" >
                <div class="col-lg-12 col-md-12"  >
                    <div  >
                        <input type="text"  class="form-control label-name"  placeholder="Add name for new column in sub details">
                    </div>
                    <div  class="d-flex my-2" >
                        <button type="button"  id="btnAddSubDetail" class="btn  btn-primary mx-2" >+</button>
                        <button type="button" class="btn btn-success btn-add-sub-details collapse">
                        <i class="fas fa-check "></i>
                    </button>
                        <button type="button" class="btn border py-2 mx-2">
                            <i class="fa fa-arrow-down btn-toggle-sub-menu "></i>
                            <b class="sub-details-items-count" ></b>
                        </button>
                    </div>
                    </div>

                    <div class="subdetails-component collapse col-lg-12 col-md-12 ">

                    </div>
               </div>
               
        </div>

        <div class="col-lg-12 col-md-12 row px-4" >
        <div class="form-group mt-4 mb-4">
                    <button class="btn btn-outline-primary btn-block">
                        تعديل منتج
                        <i class="fas fa-plus"></i>
                    </button>

                </div>
        </div>

        </div>
        </form>
    </div>
@endsection


<style>
    .sub-detail-category-item{
        background-color: #e7e7e7;
    padding: 4px;
    display: block;
    width: 100%;
    border-radius: 10px;
    border: solid 1px #d5d5d5;
}
    .item-sub-detail  input ,   .item-sub-detail  textarea
    {
        background-color:white;
        border:none;
    }
    .fa-angle-down 
    {
        font-size:22px;
        margin-right:5px;
        padding:3px 6px  3px  6px !important; 
    }
    .item-sub-detail
    {

        border-radius: 10px;
        padding: 10px;
    }
    .new
    {
          border:solid 1px #dfdfdf;
    }
    .old
    {
        background-color: #f7f7f7;
    }
    .sub-detail-category-item-inner 
    {
        display:flex;
        align-items:center;
    }
    .sub-detail-category-item-inner label 
    {
        margin:0px;
        font-size:25px;
    }
    .btn-add-category-item{
        border: solid 1px #cdcdcd;
    padding: 5px;
    border-radius: 40px;
    }
</style>
@section('body-scripts')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>
    function  enableAllergens(e)
    {
            if($(e).is(':checked'))
            {
                    $("#containerAllergens").show()
            }
            else
            {
                $("#containerAllergens").hide()
            }
    }

$(function()
{

   getSubDetails();

});
function getSubDetailsItemSubject(value,totalItems)
            {
                $(".btn-add-sub-details").removeClass("collapse");
                ele =
                 $('<div class="my-2 mx-2 col-lg-12 col-md-12 row container-sub-details-item" id="containerSubDetailsComponents'+totalItems+'" >  <div class="sub-detail-category-item" id="subjectSubDetailsComponents'+totalItems+'" style="display:block;width: 100%;" >   <div  style="display:flex;justify-content:space-between" > <div class="sub-detail-category-item-inner" ><label class="category-item-label mx-2" > '+value+' </label> <i class="btn-add-category-item fa fa-plus" onclick="addItem(this,categoryItems'+totalItems+')" ></i> <i class="btn-add-category-item fa fa-angle-down" onclick="toggleContainer('+totalItems+')" ></i> </div> <i class="fa fa-times btn-remove-sub-details-item" onclick="removeContainerSubDetails(this,containerSubDetailsComponents'+totalItems+')" ></i> </div> </div> <div id="categoryItems'+totalItems+'" class="sub-detail-category-items" style="display:block;width: 100%;" ></div> </div>');

                return ele;
            }
function showPopUp(message)
    {
        alert(message);
    }
    function toggleContainer(id)
    {
        $("#subjectSubDetailsComponents"+id).siblings('.item-sub-detail').toggle('slow')
    }
function enableProductQuantity(e)
    {
            if($(e).is(':checked'))
            {
                    $("#containerQuantitySummary").show()
            }
            else
            {
                $("#containerQuantitySummary").hide()
            }
    }
function getSubDetails()
{
    var product_id = $(".item-id").val();
    $.ajax({
        url: '/dashboard/items/get-sub-details?id='+product_id,
        type: 'GET',
        success: function (data) {
            console.log(data)
            var count = data.length;
          
            if(data.length == undefined)
            {
                count = 0;
            }
            $(".sub-details-items-count").text("( "+count+" )");
            
            $.each(data , function(a, b)
            {
                totalItems = $(".subdetails-component").children().length;
                $(".subdetails-component").append(getSubDetailsItemSubject(b[0]['subject'],totalItems));
                $('.subdetails-component').removeClass("collapse");
                if(b[1] != undefined)
                {
                    $.each( b[1]["items"] , function(c, d)
                    {
                        // console.log(b[1]["items"][c])
                          var lbl = d["label"];
                          var price = d["price"];
                          var desc = d["desc"];
                          parentID = "#containerSubDetailsComponents"+totalItems;  
                          AddNewSubDetailItem(parentID,false,lbl,price==null?'':price,desc == null ? '':desc,"collapse") 
                    });
                }

            });
        }
    });
}

function AddSubDetails()
            {
                var Items = [];
                var isValid = true;
                $('.subdetails-component').find('.container-sub-details-item').each( (index, element) => {
                            
                            var subItems = [];

                            var category = $(element).find(".category-item-label").text() 
                            
                           
                            $(element).find(".item-sub-detail").each((i,e,) => {

                                var lbl = $(e).find(".item-label").val()
                                var price = $(e).find(".item-price").val()
                                var desc = $(e).find(".item-desc").val()
                                

                                if (!isNaN(price) && price <= 2147483647 && price >= -2147483647)
                                {
                                    var item = 
                                    {
                                        "label" : lbl,
                                        "price" : price,
                                        "desc" : desc,
                                    }
                                    subItems.push(item);
                                    isValid = true;
                                    // children's element
                                }
                                else
                                {
                                    alert("price should include only numbers");
                                    isValid = false;
                                }
                            }); 
                            var product = [
                                { subject: category },
                                { items: subItems }
                            ]
                            Items.push(product);
                        });
                        
                        if(isValid)
                        {
                            var product_id = $(".item-id").val();
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: '/dashboard/items/add-sub-details',
                                type: 'POST',
                                data: {_token: CSRF_TOKEN, Id : product_id , data : Items  },
                                dataType: 'JSON',

                                success: function (data) {
                                    console.log(data)
                                    $('.subdetails-component').empty();
                                    getSubDetails();
                                    alert("Sub Details updated successfully")
                                }
                            });
                        }
            }

function removeContainerSubDetails(ethis,ele)
{
    if (confirm("Do you want to delete")){

        $(ele).remove();

    if($('.subdetails-component').children().length == 0)
    {
    $(".btn-add-sub-details").addClass("collapse");
      AddSubDetails();
    }
    else
    {
    $(".btn-add-sub-details").removeClass("collapse");
    }

}
    
}
function remove(tag)
            {

                if (confirm("Do you want to delete")){

                    $(tag).parents('.item-sub-detail').remove();

                        if($('.subdetails-component').children().length == 0)
                        {
                        $(".btn-add-sub-details").addClass("collapse");
                        AddSubDetails();
                        }
                        else
                        {
                        $(".btn-add-sub-details").removeClass("collapse");
                        }

                    }

            }
            function AddNewSubDetailItem(parentID,isTop=true,name='',price='',desc='',collapse='')
            {
                ele = $('<div class="my-2 '+collapse+' col-lg-12 col-md-12 new  item-sub-detail" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > <input class="item-label border" value="'+name+'" placeholder="name" > <i class="fa fa-times btn-remove-sub-details-item" onclick="remove(this)" ></i> </div>   <input class="my-2 border item-price" value="'+price+'" placeholder="سعر" type="text" />  </div>   <textarea class="form-control item-desc border" >'+desc+'</textarea></div>');
                if(isTop)
                {
                    $(parentID).prepend(ele);
                }
                else 
                {
                    $(parentID).append(ele);
                }
            }
            function addItem(e , id)
            {
                AddNewSubDetailItem(id) 
            }
            $(document).ready(function(){

              $('.btn-toggle-sub-menu').on('click' , function()
              {
                    $('.subdetails-component').toggleClass("collapse");
              });

              $(".btn-add-sub-details").on("click" , function()
              {

                      AddSubDetails();
              });




            $("#btnAddSubDetail").on('click' , function()
            {
                AddNewSubDetailItemSubject();
            });
            function AddNewSubDetailItemSubject() 
            {
                value = $('.label-name').val();
                if(value == "")
                {
                    alert("input label name");
                    return;
                }
                totalItems = $(".subdetails-component").children().length;
                    $(".subdetails-component").prepend(getSubDetailsItemSubject(value,totalItems));
                    $('.subdetails-component').removeClass("collapse");
            }

});

</script>
@endsection
