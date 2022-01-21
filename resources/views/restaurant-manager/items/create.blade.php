@extends('layouts.restaurant-manager-dashboard')

@section('content')
<div class="container">
    <div class="mt-4">
        <h2>انشاء منتج جديد</h2>
    </div>
    <form action="{{route('store-item', request()->route('subdomain'))}}" method="POST" enctype="multipart/form-data">

        <div class="row" >
        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')
            {{csrf_field()}}
            <div class="form-group">
                <label for="name">اسم المنتج</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم المنتج" required>
            </div>
            <div class="form-group">
                <label for="description">وصف المنتج</label>
                <textarea name="description" class="form-control" id="description" cols="30" rows="3" placeholder="ادخل وصف المنتج"></textarea>
            </div>
           

            @if(count($categories))
            <div class="form-group">
                <label for="category_id">اختر صنف للمنتج</label>
                <select name="category_id" id="category_id" class="custom-select">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" class="form-control">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            @else
            <br>
            <div class="form-group">
                <p>لا يوجد اصناف، من فضلك اضغط هنا لاضافة صنف <a href="/dashboard/categories/create?r=create-item"><i class="fas fa-external-link-alt"></i></a></p>
            </div>
            @endif
            <div class="form-group">
                <label for="new">الجديد</label>
                <input type="checkbox" name="new" id="new" value="1" >
            </div>
            <div class="form-group">
                <label for="current_price">السعر الحالي</label>
                <input type="number" name="current_price" id="current_price" class="form-control w-50" step=".01" placeholder="ادخل السعر الحالي">
            </div>
            <div class="form-group">
                <label for="old_price">السعر القديم</label>
                <input type="number" name="old_price" id="old_price" class="form-control w-50" step=".01" placeholder="ادخل السعر القديم">
            </div>

            <div class="form-group">
                <label for="calories">السعرات الحرارية</label>
                <input type="number" name="calories" id="calories" class="form-control w-50" step=".01" placeholder="ادخل السعرات الحرارية">
            </div>

            <div class="form-group">
                <label for="is_visible">مرئي</label>
                <select name="is_visible" id="is_visible" class="custom-select">
                    <option value="1">مرئي</option>
                    <option value="0">غير مرئي</option>
                </select>
            </div>

            <div class="form-group">
                <label for="is_available">متاح</label>
                <select name="is_available" id="is_available" class="custom-select">
                    <option value="1">متاح</option>
                    <option value="0">غير متاح</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">صورة للمنتج</label>
                <input type="file" name="image" id="image" class="form-control-file" required>
            </div>


        </div>
        <div class="col-lg-6 col-md-12 px-4" >
           <div class="px-2" >
                <div class="row align-items-center" >
                    <input type="checkbox" name="input_quantity_summary" onchange="enableProductQuantity(this)" value="1" >
                    <h3 class="mx-2" >
                        <b>
                            Set Quantity
                        </b>
                    </h3>
                </div>
                <div class="collapse" id="containerQuantitySummary" >
                    <div class="form-group" >
                                    <label for="">
                                        <b> Target Quantity </b>
                                    </label>
                                    <input type="text" title="target quantity" onclick="showPopUp('Item will be out of stock when reach at this quantity')" name="input_target_quantity" class="form-control" >
                            </div>
                            <div class="form-group" >
                                    <label for="">
                                        <b> Total  Quantity </b>
                                    </label>
                                    <input type="text" name="input_total_quantity" class="form-control" >

                            </div>
                </div>    
           </div>
                
           <div class="px-2" >
               <div  class="row align-items-center px-2" >
                    <input type="checkbox" onchange="enableAllergens(this)" value="1" >
                    <h3 class="mx-2" >
                        <b>
                            Set Allergens
                        </b>
                    </h3>
                </div>
                <div class="collapse direction-ltr  " id="containerAllergens" >
                          <div class="form-group" id="" >
                                    <label for="">
                                        <b> celery </b>
                                    </label>
                                    <input type="checkbox" value="celery.png" name="allergens[]" >
                            </div>
                            <div class="form-group" >
                                    <label for="">
                                        <b> crustacean </b>
                                    </label>
                                    <input type="checkbox" value="crustacean.png" name="allergens[]" >

                            </div>
                            <div class="form-group" >
                                    <label for="">
                                        <b> eggs </b>
                                    </label>
                                    <input type="checkbox" value="eggs.png" name="allergens[]" >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> fish </b>
                                    </label>
                                    <input type="checkbox" value="fish.png" name="allergens[]" >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> gulten</b>
                                    </label>
                                    <input type="checkbox" value="gulten.png" name="allergens[]" >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> lupins </b>
                                    </label>
                                    <input type="checkbox" value="lupins.png" name="allergens[]" >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> milk </b>
                                    </label>
                                    <input type="checkbox" value="milk.png" name="allergens[]" >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> mustard </b>
                                    </label>
                                    <input type="checkbox" value="mustard.png" name="allergens[]" >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> nuts</b>
                                    </label>
                                    <input type="checkbox" value="nuts.png" name="allergens[]" >

                            </div> <div class="form-group" >
                                    <label for="">
                                        <b> peanuts </b>
                                    </label>
                                    <input type="checkbox" value="peanuts.png" name="allergens[]" >

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> sesame </b>
                                    </label>
                                    <input type="checkbox" value="sesame.png" name="allergens[]" >

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> shellfish </b>
                                    </label>
                                    <input type="checkbox" value="shellfish.png" name="allergens[]" >

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> soya </b>
                                    </label>
                                    <input type="checkbox" value="soya.png" name="allergens[]" >

                            </div>
                             <div class="form-group" >
                                    <label for="">
                                        <b> sulphite </b>
                                    </label>
                                    <input type="checkbox" value="sulphite.png" name="allergens[]" >

                            </div>
                </div>    
           </div>
                
        </div>
        
        </div>
        <div class="col-lg-6 col-md-12 row px-4" style="display:none">
            <div class="mt-4">
                <h2> التفاصيل الفرعية </h2>
            </div>
            <div class="col-lg-12 col-md-12 row" style="display:flex">
                <div>
                    <input type="text" class="form-control label-name" placeholder="Add name for new column in sub details">
                </div>
                <div>
                    <button type="button" class="btn btn-primary mx-2">+</button>
                    <button type="button" class="btn border py-2">
                        <i class="fa fa-arrow-down btn-toggle-sub-menu "></i>
                        <b class="sub-details-items-count"></b>
                    </button>
                    <button type="button" class="btn btn-success btn-add-sub-details collapse">
                        <i class="fas fa-check "></i>
                    </button>
                </div>
            </div>

            <div class="subdetails-component collapse col-lg-12 col-md-12 row ">

            </div>


        </div>

        <div class="form-group mt-4 mb-4">
            <button class="btn btn-outline-primary btn-block">
                اضافة منتج
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </form>
</div>
@endsection
<style>
    .item-sub-detail input,
    .item-sub-detail textarea {
        background-color: white;
        border: none;
        box-shadow: rgb(0 0 0 / 18%) 0px 2px 5px;
    }

    .item-sub-detail {

        border-radius: 10px;
        padding: 10px;
    }

    .new {
        border: solid 1px #dfdfdf;
    }

    .old {
        background-color: #f7f7f7;
    }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    var Items = [];
    $(function() {

        getSubDetails();

    });
    function showPopUp(message)
    {
        alert(message);
    }
    function enableProductQuantity (e)
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
    
    function getSubDetails() {
        $(".subdetails-component").empty();
        var count = Items.length;
        if (Items.length == undefined) {
            count = 0;
        }
        $(".sub-details-items-count").text("( " + count + " )");
        $.each(Items, function(a, b) {
            var lbl = b[0];
            var price = b[1];
            var desc = b[2];
            ele = $('<div class="my-2 mx-2 col-lg-12 col-md-12 row old item-sub-detail" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > <label class="item-label" > ' + lbl + ' </label> <i class="fa fa-times btn-remove-sub-details-item" onclick="remove(this)" ></i> </div>   <input class="my-2 item-price" readonly placeholder="سعر" value="' + price + '" type="text" />  </div>   <textarea class="form-control item-desc" >' + desc + '</textarea></div>');
            $(".subdetails-component").prepend(ele);
        });

        $("#sub_details").val(String(Items));
    }

    function AddSubDetails() {

        var isValid = true;
        Items = [];
        $('.subdetails-component').children().each((index, element) => {

            var subItems = [];
            var lbl = $(element).find(".item-label").text();
            var price = $(element).find(".item-price").val();
            var desc = $(element).find(".item-desc").val();

            if (!isNaN(price) && price <= 2147483647 && price >= -2147483647) {
                subItems.push(lbl);
                subItems.push(price);
                subItems.push(desc);
                Items.push(subItems);
                isValid = true;
                // children's element
            } else {
                alert("price should include only numbers");
                isValid = false;
            }
        });

        if (isValid) {

            getSubDetails();
        }
    }


    function remove(tag) {

        if (confirm("Do you want to delete")) {

            $(tag).parents('.item-sub-detail').remove();

            if ($('.subdetails-component').children().length == 0) {
                $(".btn-add-sub-details").addClass("collapse");
                AddSubDetails();
            } else {
                $(".btn-add-sub-details").removeClass("collapse");
            }

        }

    }
    $(document).ready(function() {

        $('.btn-toggle-sub-menu').on('click', function() {
            $('.subdetails-component').toggleClass("collapse");
        });

        $(".btn-add-sub-details").on("click", function() {

            AddSubDetails();
        });


        $(".btn-primary").on('click', function() {
            value = $('.label-name').val();
            if (value == "") {
                alert("input label name");
            } else {
                $(".btn-add-sub-details").removeClass("collapse");
                ele = $('<div class="my-2 mx-2 col-lg-12 col-md-12 new row item-sub-detail" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > <label class="item-label" > ' + value + ' </label> <i class="fa fa-times btn-remove-sub-details-item" onclick="remove(this)" ></i> </div>   <input class="my-2 item-price" placeholder="سعر" type="text" />  </div>   <textarea class="form-control item-desc" >وصف</textarea></div>');
                $(".subdetails-component").prepend(ele);
                $('.subdetails-component').removeClass("collapse");
            }
        });

    });
</script>