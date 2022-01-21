@extends('layouts.restaurant-manager-dashboard')

@section('content')

<div class="container">


    <form action="{{route('manager-update-restaurant',$restaurant->subdomain)}}" method="POST" enctype="multipart/form-data" onsubmit="submitForm(event)">
        @method('patch')
        {{csrf_field()}}

        <input type="text" class="rest-id collapse" value="{{$restaurant->id}}">

        <div class="mt-4">
            <h2>تعديل متجر</h2>
        </div>
        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')
            <input class="colors collapse" name="colors" type="text" />
            <div class="form-group">
                <label for="name"> اسم المتجر </label>
                <textarea cols="30" rows="3" type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم المتجر" required>
                {{$restaurant->name}}
                </textarea>
                <input type="color" onchange="setColor('shop_name' , this)" />
            </div>

            <div class="form-group">
                <label for="user_email"> إرسال بريد إلكتروني للحصول على إشعار </label>
                <input type="text" name="user_email" id="name" class="form-control" placeholder="أدخل البريد الإلكتروني" required value="{{$restaurant->user_email}}">
            </div>


            <div class="form-group note1">
                <label for="description"> ملاحظات#1 </label>
                <textarea name="notes1" class="form-control" id="description" cols="30" rows="3" placeholder="ادخل وصف المتجر">{{$restaurant->notes1}}</textarea>
                <input type="color" onchange="setColor('note_1' , this)" />
            </div>



            <div class="form-group note2">
                <label for="description"> ملاحظات#2 </label>
                <textarea name="notes2" class="form-control" id="description" cols="30" rows="3" placeholder="ادخل وصف المتجر">{{$restaurant->notes2}}</textarea>
                <input type="color" onchange="setColor('note_2' , this)" />
            </div>


            <div class="form-group">
                <select class="form-control" name="font_style">
                    <option value="none">
                        None
                    </option>

                    <option value="GE SS Two Medium" {{($restaurant->font_style == "GE SS Two Light")? 'selected="selected"': ''}}>
                        GE SS Two Light
                    </option>

                    <option value="GE SS Two Medium" {{($restaurant->font_style == "GE SS Two Medium")? 'selected="selected"': ''}}>
                        GE SS Two Medium
                    </option>

                    <option value="GE SS Two Bold" {{($restaurant->font_style == "GE SS Two Bold")? 'selected="selected"': ''}}>
                        GE SS Two Bold
                    </option>


                    <option style="font-family: 'El Messiri' " value="fantasy" {{($restaurant->font_style == "fantasy")? 'selected="selected"': ''}}>
                        fantasy
                    </option>
                    <option style="font-family: 'El Messiri' " value="'Cairo', cursive" {{($restaurant->font_style == "'Cairo', cursive")? 'selected="selected"': ''}}>
                        'Cairo', cursive
                    </option>

                </select>

            </div>


            <div class="form-group">
                <select id="currency" class="form-control" name="currency">
                    <option value="ريال" selected>
                        ريال
                    </option>
                    <option value="دينار">
                        دينار
                    </option>

                    <option value="درهم">
                        درهم
                    </option>

                </select>

            </div>

            <div class="form-group">
                <select id="phone_code" class="form-control" name="phone_code">
                    <option value="966" selected>
                        966
                    </option>
                    <option value="971">
                        971
                    </option>

                    <option value="973">
                        973
                    </option>

                </select>

            </div>


            <div class="form-group">
                <label for="description">وصف المتجر</label>
                <textarea name="description" class="form-control" id="description" cols="30" rows="3" placeholder="ادخل وصف المتجر">{{$restaurant->description}}</textarea>
            </div>

            <div class="form-group">

                <div>
                    <label for="logo">لوجو المتجر (ارفع صورة جديدة او اترك القديمة)</label>
                    <div class="mx-2">
                        <label class="mx-2" for=""><b>تفعيل الشعار</b></label>
                        <input type="checkbox" name="is_logo_active" @if($restaurant->is_logo_active == 1)
                        checked
                        @endif
                        >
                    </div>
                </div>


                <input type="file" name="logo" id="logo" class="form-control-file">
            </div>

            <div class="form-group">

                <label for="background_image">صورة خلفية المتجر (ارفع صورة جديدة او اترك القديمة)</label>
                <input type="file" name="background_image[]" accept=".png, .jpg, .jpeg" multiple>
            </div>

            <div class="form-group">
                <label for="current_theme">
                    الشكل الحالي
                    <i class="fas fa-paint-roller"></i>
                </label>
                @php
                $availableThemes = json_decode($restaurant->available_themes, true);
                @endphp
                <select name="current_theme" id="current_theme" class="custom-select">
                    @foreach($availableThemes as $availableTheme)
                    <option value="{{$availableTheme}}" {{($availableTheme == $restaurant->current_theme)? 'selected="selected"': ''}}>{{$availableTheme}}</option>
                    @endforeach
                </select>
            </div>

            <fieldset class="mb-2">
                <legend>
                    اوقات العمل
                    <i class="fas cursor-pointer ml-2 fa-times" title="احذف اوقات العمل" onclick="resetWorkingHours()"></i>
                </legend>
                <div class="form-group">
                    <label for="open_from">
                        يفتح من الساعة
                        <i class="fas fa-door-open"></i>
                    </label>
                    <input type="time" name="open_from" id="open_from" class="form-control" style="width: 9rem" placeholder="ادخل توقيت فتح المتجر" value="{{$restaurant->open_from? \Carbon\Carbon::createFromTimeString($restaurant->open_from)->format('H:i'): ''}}">
                </div>
                <div class="form-group">
                    <label for="open_to">
                        يغلق الساعة
                        <i class="fas fa-door-closed"></i>
                    </label>
                    <input type="time" name="open_to" id="open_to" class="form-control" style="width: 9rem" placeholder="ادخل توقيت غلق المتجر" value="{{$restaurant->open_to? \Carbon\Carbon::createFromTimeString($restaurant->open_to)->format('H:i'): ''}}">
                </div>
            </fieldset>

            <div class="form-group">
                <label for="phone">
                    رقم الهاتف
                    <i class="fas fa-phone-alt"></i>
                </label>
                <input type="number" name="phone" id="phone" class="form-control" placeholder="ادخل رقم الهاتف" value="{{$restaurant->phone}}">
            </div>

            <div class="form-group">
                <label for="whatsapp_number">
                    رقم الواتساب
                    <i class="fab fa-whatsapp"></i>
                </label>
                <input type="number" name="whatsapp_number" id="whatsapp_number" class="form-control" placeholder="ادخل رقم الواتساب" value="{{$restaurant->whatsapp_number}}">
            </div>

            <div class="form-group">
                <label for="google_map_location_link">
                    العنوان علي الخريطة (ادخل رابط خرائط جوجل)
                    <i class="fas fa-map-marker-alt"></i>
                </label>
                <input type="text" name="google_map_location_link" id="google_map_location_link" class="form-control" placeholder="ادخل رابط خرائط جوجل" value="{{$restaurant->google_map_location_link}}">
            </div>

            <div class="form-group">
                <label for="facebook_link">
                    رابط فيسبوك
                    <i class="fab fa-facebook"></i>
                </label>
                <input type="text" name="facebook_link" id="facebook_link" class="form-control" placeholder="ادخل رابط فيسبوك" value="{{$restaurant->facebook_link}}">
            </div>

            <div class="form-group">
                <label for="twitter_link">
                    رابط تويتر
                    <i class="fab fa-twitter"></i>
                </label>
                <input type="text" name="twitter_link" id="twitter_link" class="form-control" placeholder="ادخل رابط تويتر" value="{{$restaurant->twitter_link}}">
            </div>

            <div class="form-group">
                <label for="instagram_link">
                    رابط انسجرام
                    <i class="fab fa-instagram"></i>
                </label>
                <input type="text" name="instagram_link" id="instagram_link" class="form-control" placeholder="ادخل رابط انسجرام" value="{{$restaurant->instagram_link}}">
            </div>

            <div class="form-group">
                <label for="snapchat_link">
                    رابط سناب شات
                    <i class="fab fa-snapchat"></i>
                </label>
                <input type="text" name="snapchat_link" id="snapchat_link" class="form-control" placeholder="رابط سناب شات" value="{{$restaurant->snapchat_link}}">
            </div>

            <div style="display:flex">
                <div class="form-group">
                    <label class="border  btn-toggle-payment-options" for=""> خيار الدفع <i class="fa fa-angle-down"></i> </label>
                    <button type="button" class="mx-2 btn btn-success btn-add-other-accounts">
                                <i class="fas fa-check "></i>
                    </button> 
                </div>
                
            </div>

            <div class="form-group payment-methods collapse">

                <div>
                    <input type="checkbox" onchange="selectPaymentMethod(this,'other_details')" name="other_transfer" id="other_transfer">
                        <label for="">
                        آخر
                        </label>
                </div>
                
                    <div class="collapse" id="other_details">
                        <div class="col-lg-12 col-md-12 row" style="display:flex">
                        <div>
                            <button type="button" class="mx-2 btn btn-success btn-add-other-accounts">
                                <i class="fas fa-check "></i>
                            </button>
                            <!-- Name , number, note -->
                        </div>
                            <div>
                                <input type="text" placeholder="اسم الحساب المصرفي" name="other_account_name"  class="other-account-name form-control">
                            </div>

                            <div>
                                <button type="button" class="btn btn-add-other-account-item border mx-2">+</button>
                                <button type="button" class="btn border py-2">
                                    <i class="fa fa-arrow-down btn-toggle-add-other-accounts"></i>
                                    <b class="add-other-accounts-items-count"></b>
                                </button>
                            </div>
                        </div>

                        <div class="addOtheraccounts-component collapse col-lg-12 col-md-12 row ">

                        </div>
                    </div>
            
                <div>
                    <input type="checkbox" onchange="selectPaymentMethod(this,'bank_details')" name="money_transfer" id="money_transfer">
                    <label for="">
                        تحويل بنكي
                    </label>
                </div>

                <div class="collapse" id="bank_details">
                    <div class="col-lg-12 col-md-12 row" style="display:flex">
                    <div>
                        <button type="button" class="mx-2 btn btn-success btn-add-accounts">
                            <i class="fas fa-check "></i>
                        </button>

                    </div>
                        <div>
                            <input type="text" placeholder="اسم الحساب المصرفي" name="bank_account_name" class="account-name form-control">
                        </div>

                        <div>
                            <button type="button" class="btn btn-add-account-item border mx-2">+</button>
                            <button type="button" class="btn border py-2">
                                <i class="fa fa-arrow-down btn-toggle-add-accounts"></i>
                                <b class="add-accounts-items-count"></b>
                            </button>
                        </div>
                    </div>

                    <div class="addaccounts-component collapse col-lg-12 col-md-12 row ">

                    </div>
                </div>

                <div>

                    <input type="checkbox" id="cash_on_delievery" name="cash_on_delievery" value="cash_on_delievery">
                    <label for="">
                        الدفع عند الاستلام
                    </label>
                </div>

            </div>

            <div>
                <div class="form-group">
                    <label class="border px-2   btn-toggle-order-options" for=""> خيارات التوصيل والاستلام <i class="fa fa-angle-down"></i> </label>
                    <button type="button" class="mx-2 btn btn-success btn-add-accounts">
                            <i class="fas fa-check "></i>
                        </button>
                </div>
            </div>

            <div class="order-methods collapse">

                <div>

                    <input type="checkbox" id="delivery" name="delivery" value="delivery">
                    <label for="">
                        توصيل
                    </label>
                </div>

                <div>

                    <input type="checkbox" id="receipt" name="receipt" value="Receipt">
                    <label for="">
                        استلام
                    </label>
                </div>

                <div>

                    <input type="checkbox" id="sweetened" name="sweetened" value="Sweetened">
                    <label for="">
                        محلى
                    </label>
                </div>

            </div>

            <div class="form-group">
                <label for="main_theme_color_code">
                    اختر لون الشكل الاساسي
                    <i class="fas fa-palette"></i>
                </label>
                <div class="d-flex mb-1">
                    <input type="color" id="main_theme_color_code" class="cursor-pointer" value="{{$restaurant->main_theme_color_code}}" onchange="changeColorTextValue(event)" style="display: {{$restaurant->main_theme_color_code? 'block' : 'none'}};">
                    <i class="fas {{!$restaurant->main_theme_color_code? 'fa-plus': 'fa-times'}} cursor-pointer ml-2" onclick="toggleMainColorCode(event)"></i>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">#</div>
                    </div>
                    <input type="text" class="form-control" id="main_theme_color_code_text" name="main_theme_color_code" maxlength="6" value="{{$restaurant->main_theme_color_code? substr($restaurant->main_theme_color_code,1) : ''}}" onkeyup="validateColorCode(event)" style="display: {{$restaurant->main_theme_color_code? 'block' : 'none'}};">
                </div>
            </div>


            <div class="form-group background-inputs">

                <label for="back_theme_color_code">
                     اختر لون الظهر    
                    <i class="fas fa-palette"></i>
                </label>

                <div>
                    <div>
                      <input type="radio" id="back_color" value="0" name="back_theme_select" onchange="changeBackElements(document.getElementsByClassName('back-color'))" checked />  <label> Color </label> 
                    </div>              
                   <div class="back-color" id="back_color_ele" >
                        <div class="d-flex mb-1" >
                                <input type="color" id="back_theme_color_code" class="cursor-pointer"  onchange="changeBackColorTextValue(event)" style="display: {{$restaurant->back_theme_color_code? 'block' : 'none'}};">
                                <i class="fas {{!$restaurant->back_theme_color_code? 'fa-plus': 'fa-times'}} cursor-pointer ml-2" onclick="toggleBackColorCode(event)"></i>
                            </div>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">#</div>
                                </div>
                                <input type="text" class="form-control" id="back_theme_color_code_text"  name="back_theme_input" maxlength="6" onkeyup="validateBackColorCode(event)" style="display: {{$restaurant->back_theme_color_code? 'block' : 'block'}};">
                            </div>
                   </div>
                </div>  
                
                <div class="" >
                    <div>
                      <input type="radio" id="back_image" value="1" name="back_theme_select" onchange="changeBackElements(document.getElementsByClassName('back-image'))" />  <label> Image </label> 
                    </div>              
                    <div class="back-image" id="back_image_ele" >
                           <div>
                               <input type="hidden" id="input_back_image_hide_val"   name="back_image_hide_val" class="form-control" />                                
                                <input type="file" id="input_back_image" onchange="changeBackImage()"  name="back_image" class="form-control" /> 
                           </div>     
                    </div>    
                </div>  
            </div>

            <div class="form-group">
                <label for="back_theme_color_code">
                    مذكرة تحويل الأموال
                    <i class="fas fa-note"></i>
                </label>
                <textarea cols="30" rows="3" name="money_trasnfer_note" class="form-control">{{$restaurant->admin_note}}</textarea>
            </div>

        </div>

        <div class=" px-4" style="display:block">
            <div class="mt-4">
                <h2> إضافة جهة اتصال </h2>
            </div>

            <div class="col-lg-12 col-md-12 row" style="display:flex">
                <div>
                    <select name="" class="contacts form-control">
                        <option value="">
                            Select Contact
                        </option>
                        <option value="">
                            WhatsApp
                        </option>
                        <option value="">
                            Instagram
                        </option>
                        <option value="">
                            Weblink
                        </option>
                        <option value="">
                            Snapchat
                        </option>
                        <option value="">
                            Facebook
                        </option>
                        <option value="">
                            Phone
                        </option>
                        <option value="">
                            Location
                        </option>

                        <option value="">
                            Other
                        </option>
                    </select>
                </div>

                <div>
                    <button type="button" class="btn btn-primary mx-2">+</button>
                    <button type="button" class="btn btn-success btn-add-contacts collapse">
                        <i class="fas fa-check "></i>
                    </button>
                    <button type="button" class="btn border py-2">
                        <i class="fa fa-arrow-down btn-toggle-add-contacts "></i>
                        <b class="add-contacts-items-count"></b>
                    </button>
                </div>
            </div>

            <div class="addcontacts-component collapse col-lg-12 col-md-12 row ">

            </div>


        </div>

        <div class="col-lg-12 col-md-12 row px-4">

            <div class="form-group mt-4 mb-4">
                <button class="btn btn-outline-primary btn-block">
                    تعديل متجر
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </form>
</div>


@endsection

<style>
    .item-add-contacts input,
    .item-add-contacts textarea {
        background-color: white;
        border: none;
        box-shadow: rgb(0 0 0 / 18%) 0px 2px 5px;
    }

    .item-add-contacts {

        border-radius: 10px;
        padding: 10px;
    }

    .new {
        border: solid 1px #dfdfdf;
    }

    .old {
        background-color: #f7f7f7;
    }

    .item-add-accounts input {
        margin: 5px;
    }

    .item-add-accounts , .item-add-other-accounts  {
        background-color: #f1f1f1;
        padding: 3px;
        border-radius: 10px;
    }
</style>

@section('body-scripts')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    var type = "social";
    var rest_id = $(".rest-id").val();
    CONTACTS_ICONS = {
        "Location": "fa fa-map-marker",
        "WhatsApp": "fab fa-whatsapp",
        "Instagram": "fab fa-instagram",
        "Weblink": "fab fa-chrome",
        "Snapchat": "fab fa-snapchat",
        "Facebook": "fab fa-facebook",
        "Phone": "fas fa-phone-alt",
    }
    var ACCOUNT_ITEMS = [];
    COLORS = {}
    // settting color for shop name , note 1 , note 2
    function setColor(name, tag) {
        COLORS[name] = $(tag).val();
        $('.colors').val(JSON.stringify(COLORS));
    }

    function changeBackImage()
    {
        // input_back_image_hide_val
        var file = $('#input_back_image')[0].files[0]
        if (file){
            $("#input_back_image_hide_val").removeAttr('value');
        }
    }
    function selectPaymentMethod(tag1 , tag2) {
            if ($(tag1).is(":checked")) {
                $('#'+tag2).removeClass('collapse');
            } else {
                $('#'+tag2).addClass('collapse');
            }
    }

    // setting back elements like color or image
    function changeBackElements(tag) {
        $('.back-image').addClass("collapse");    
        $('.back-color').addClass("collapse");    
        var id = $(tag).attr('id');
        $("#"+id).removeClass("collapse");
      
        if(id == "back_image_ele")
        {
            $("#input_back_image").attr('required' , true)
        }
        else
        {
            $("#input_back_image").attr('required' , false)
        }
    }

    function  setBackElements(tag, tag2, tag3)
    {
        $('.back-image').addClass("collapse");    
        $('.back-color').addClass("collapse");    
            
        var data = "{{$restaurant->back_theme_color_code}}";
        if(data)
        {
            data = JSON.parse(data.replace(/&quot;/g,'"'));
            if(data["type"] == 1)
            {
                $("#back_image_ele").removeClass("collapse");
                $("#back_image").prop("checked", true);
                $("#"+$(tag3).attr('id')+"_hide_val").attr("value" , data["value"]);
            }
            else 
            {
                $("#back_color_ele").removeClass("collapse");
                $("#back_color").prop("checked", true);
                $("#"+$(tag2).attr('id')).attr("value" , data["value"]);
                $("#input_back_image").attr('required' , false)
            }
                
        }
        else 
        {
            $("#"+id).removeClass("collapse");    
        }
    }
    function initColors() {
        var colors = "{{$restaurant->colors}}";
        if(colors)
        {
            COLORS = JSON.parse(colors.replace(/&quot;/g, '"'));
            $('.colors').val(JSON.stringify(COLORS));
        }
    }
    // code for adding multiple contacts started
    $(function() {
        initColors();
        setCurrency();
        getSubDetails();
        getSubAccounts();
        setPhone();
        setBackElements(document.getElementsByClassName("back-color"), document.getElementById('back_theme_color_code_text'), document.getElementById('input_back_image'));
    });

    function setPhone() {
        var value = '<?php echo $restaurant->phone_code ?>';
        if (value) {
            $("#phone_code").val(value).trigger("chosen:updated");
        }
    }

    function setCurrency() {
        var value = '<?php echo $restaurant->currency ?>';
        $("#currency").val(value).trigger("chosen:updated");
    }

    function getSubDetails() {
        var rest_id = $(".rest-id").val();
        $.ajax({
            url: '/dashboard/get-contacts?id=' + rest_id,
            type: 'GET',
            success: function(data) {
                var count = data.length;
                if (data.length == undefined) {
                    count = 0;
                }
                $(".add-contacts-items-count").text("( " + count + " )");
                $.each(data, function(a, b) {
                    var lbl = b[0];
                    var lbl_tag = '<i id="' + lbl + '" class="fa-2x item-label ' + lbl + '" > </i>';

                    var price = b[1];
                    var desc = b[2];
                    var type = b[3];
                    if (type == "app") {

                        lbl_tag = '<img class="item-label" width="30" height="30" style="border-radius:40px" id="' + lbl + '" src ="/storage/images/' + lbl + '" />'
                    }

                    ele = $('<div class="my-2 py-2 mx-2 col-lg-12 col-md-12 row old item-sub-detail" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > ' + lbl_tag + ' <i class="  fa fa-times btn-remove-sub-details-item" onclick="remove(this)" ></i> </div>   <input class="my-2  item-contact form-control" placeholder="سعر" value="' + price + '" type="text" />  </div>   <textarea class="form-control item-desc" >' + desc + '</textarea></div>');
                    $(".addcontacts-component").append(ele);

                });
            }
        });
    }

    function getSubAccounts() {
        $.ajax({
            url: '/dashboard/get-accounts?id=' + rest_id,
            type: 'GET',
            success: function(data) {
                var money_transfer_count = 0;
                var other_transfer_count = 0;
                
                $.each(data, function(a, b) {
                   
                    if(b["type"] == "money_transfer")
                    {
                        money_transfer_count = money_transfer_count+1;
                    }
                    else if(b["type"] == "other_transfer")
                    {
                        other_transfer_count = other_transfer_count+1;
                    }

                    if (b["type"] == "money_transfer") {
                        var lbl = b["bankName"];
                        var lbl_tag = '<label  class="bank-name-label" > ' + lbl + '  </label>';
                        var desc = b[1];
                        ele = $('<div class="my-2 mx-2 col-lg-12 col-md-12 new row item-add-accounts" style="padding:10px" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > ' + lbl_tag + ' <i class="fa fa-times btn-remove-sub-account-item" onclick="removeAccount(this)" ></i> </div>   <div>  <input type="text" value="' + b["personName"] + '" class="form-control person-name" placeholder = "اسم المحول له" />  <input type="text" value="' + b["accountNumber"] + '" placeholder = "رقم الحساب" class="form-control account-number" /> <input type="text" value="' + b["fullAccountNumber"] + '" placeholder = "رقم الايبان" class="form-control full-account-number" />    </div>');
                        $(".addaccounts-component").append(ele);
                    }
                    if (b["type"] == "other_transfer") {
                        var lbl = b["Name"];
                        var lbl_tag = '<label  class="other-account-name-label" > ' + lbl + '  </label>';
                        var desc = b[1];
                        ele = $('<div class="my-2 mx-2 col-lg-12 col-md-12 new row item-add-other-accounts" style="padding:10px" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > ' + lbl_tag + ' <i class="fa fa-times btn-remove-sub-other-account-item" onclick="removeOtherAccount(this)" ></i> </div>   <div>  <input type="text" value="' + b["Number"] + '" class="form-control other-account-number" placeholder = "اسم المحول له" /> <input type="text" value="' + b["note"] + '" placeholder = "رقم الحساب" class="form-control other-account-note" /> </div>');
                        $(".addOtheraccounts-component").append(ele);
                    }
                        $("#" + b["type"]).prop("checked", true);
                 
                });

                $(".add-accounts-items-count").text("( " + money_transfer_count + " )");
                $(".add-other-accounts-items-count").text("( " + other_transfer_count + " )");
                
            }
        });
    }

    function AddSubDetails() {
        var Items = [];
        IS_VALID = true;
        $('.addcontacts-component').children().each((index, element) => {

            var subItems = [];
            type = "social";
            var lbl = $(element).find(".item-label").attr('id');
            var link_tag = $(element).find(".item-contact");
            var desc_tag = $(element).find(".item-desc");

            if (link_tag.val().trim() == "") {
                IS_VALID = false;
                link_tag.css({
                    "border": "solid 1px red "
                });
            } else if (desc_tag.val().trim() == "") {
                IS_VALID = false;

                desc_tag.css({
                    "border": "solid 1px red "
                });
            } else {
                link = link_tag.val();

                if (lbl.indexOf("fab fa-whatsapp") >= 0) {
                    if (link.indexOf("https://wa.me/") >= 0) {
                        link = "" + link;
                    } else {
                        link = "https://wa.me/" + link;
                    }

                }
                if (lbl.indexOf("fas fa-phone") >= 0) {
                    if (link.indexOf("tel:") >= 0) {
                        link = "" + link;
                    } else {
                        link = "tel:" + link;
                    }
                }
                if (lbl.indexOf(" fa-") < 0) {
                    type = "app";
                }

                if (lbl.indexOf("fa fa-map-marker") >= 0) {
                    type = "location";
                }
                subItems.push(lbl);
                subItems.push(link);
                subItems.push(desc_tag.val());
                subItems.push(type);

                Items.push(subItems); // children's element
            }
        });


        if (!IS_VALID) {
            alert("Fill all the fields")
        }

        if (IS_VALID) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/dashboard/add-contacts',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    Id: rest_id,
                    data: Items
                },
                dataType: 'JSON',

                success: function(data) {

                    $('.addcontacts-component').empty();
                    getSubDetails();
                    alert("Sub details updated successfully")
                }
            });

        }
    }

    function AddOtherAccounts() 
    {
        ACCOUNT_ITEMS = [];
        IS_VALID = true;
        $('.addOtheraccounts-component').children().each((index, element) => {

            var subItems = [];
            var bankName = $(element).find(".other-account-name-label").text();
            var accountNumber = $(element).find(".other-account-number").val();
            var note = $(element).find(".other-account-note").val();
            console.log(bankName);
            console.log(accountNumber);
            console.log(note);
                
            if (bankName == "" || accountNumber == "" || note == "") {
                alert("Fill all the fields");
                IS_VALID = false;
            } else {
                type = "other_transfer";

                var data = {
                    "Name": bankName,
                    "Number": accountNumber,
                    "note": note,
                    "type": type,
                    "category": "payment"
                }
                ACCOUNT_ITEMS.push(data); // children's element
            }
        });
        $('.addaccounts-component').children().each((index, element) => {

                var subItems = [];
                var bankName = $(element).find(".bank-name-label").text();
                var personName = $(element).find(".person-name").val();
                var accountNumber = $(element).find(".account-number").val();
                var fullAccountNumber = $(element).find(".full-account-number").val();

                if (personName == "" || accountNumber == "" || fullAccountNumber == "") {
                    alert("Fill all the fields");
                    IS_VALID = false;
                } else {
                    type = "money_transfer";

                    var data = {
                        "bankName": bankName,
                        "personName": personName,
                        "accountNumber": accountNumber,
                        "fullAccountNumber": fullAccountNumber,
                        "type": type,
                        "category": "payment"

                    }
                    ACCOUNT_ITEMS.push(data); // children's element
                }
                });
                saveAccountDetails(IS_VALID,1);    
        
    }

    function AddSubAccounts() {
        ACCOUNT_ITEMS = [];
        IS_VALID = true;
        $('.addOtheraccounts-component').children().each((index, element) => {

        var subItems = [];
        var bankName = $(element).find(".other-account-name-label").text();
        var accountNumber = $(element).find(".other-account-number").val();
        var note = $(element).find(".other-account-note").val();
        console.log(bankName);
        console.log(accountNumber);
        console.log(note);
            
        if (bankName == "" || accountNumber == "" || note == "") {
            alert("Fill all the fields");
            IS_VALID = false;
        } else {
            type = "other_transfer";

            var data = {
                "Name": bankName,
                "Number": accountNumber,
                "note": note,
                "type": type,
                "category": "payment"
            }
            ACCOUNT_ITEMS.push(data); // children's element
        }
        });
        $('.addaccounts-component').children().each((index, element) => {

            var subItems = [];
            var bankName = $(element).find(".bank-name-label").text();
            var personName = $(element).find(".person-name").val();
            var accountNumber = $(element).find(".account-number").val();
            var fullAccountNumber = $(element).find(".full-account-number").val();

            if (personName == "" || accountNumber == "" || fullAccountNumber == "") {
                alert("Fill all the fields");
                IS_VALID = false;
            } else {
                type = "money_transfer";

                var data = {
                    "bankName": bankName,
                    "personName": personName,
                    "accountNumber": accountNumber,
                    "fullAccountNumber": fullAccountNumber,
                    "type": type,
                    "category": "payment"

                }
                ACCOUNT_ITEMS.push(data); // children's element
            }
        });
        saveAccountDetails(IS_VALID,1);
    }

    function saveAccountDetails(IS_VALID,status) 
    {
        var cash_on_delievery = $("#cash_on_delievery").is(':checked');
        if (cash_on_delievery) {
            type = "cash_on_delievery";
            var data = {
                "name": "Cash on Delievery",
                "type": type,
                "category": "payment"
            }
            ACCOUNT_ITEMS.push(data);
        }

        var delivery = $("#delivery").is(':checked');
        if (delivery) {
            type = "delivery";
            var data = {
                "name": "delivery",
                "type": type,
                "category": "delivery"
            }
            ACCOUNT_ITEMS.push(data);
        }

        var Receipt = $("#receipt").is(':checked');
        if (Receipt) {
            type = "receipt";
            var data = {
                "name": "Receipt",
                "type": type,
                "category": "delivery"
            }
            ACCOUNT_ITEMS.push(data);
        }

        var Sweetened = $("#sweetened").is(':checked');
        if (Sweetened) {
            type = "sweetened";
            var data = {
                "name": "Sweetened",
                "type": type,
                "category": "delivery"
            }
            ACCOUNT_ITEMS.push(data);
        }

        if (IS_VALID) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({

                url: '/dashboard/add-accounts',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    Id: rest_id,
                    data: ACCOUNT_ITEMS
                },
                dataType: 'JSON',
                success: function(data) {

                    $('.addaccounts-component').empty();
                    $('.addOtheraccounts-component').empty();
                    getSubAccounts();
                    alert("Account info updated successfully")
                }

            });
        }   
    }

    function saveIcon(tag) {
        var data = new FormData();
        data.append('file', tag.files[0]);
        data.append('name', $(tag).attr('id'));

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        data.append('_token', CSRF_TOKEN);
        $.ajax({
            url: '/dashboard/save-icon',
            type: 'POST',
            data: data,
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,

            success: function(data) {
                console.log(data);
                // $('.addcontacts-component').empty();
                // getSubDetails();
                // alert("Sub details updated successfully")
            }
        });
    }

    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0,
                v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    function remove(tag) {

        if (confirm("Do you want to delete")) {

            $(tag).parents('.item-sub-detail').remove();

            if ($('.addcontacts-component').children().length == 0) {
                $(".btn-add-contacts").addClass("collapse");
                AddSubDetails();
            } else {

                $(".btn-add-contacts").removeClass("collapse");
            }

        }

    }

    function removeAccount(tag) {

        if (confirm("Do you want to delete")) {

            $(tag).parents('.item-add-accounts').remove();

            if ($('.addaccounts-component').children().length == 0) {
                AddSubAccounts();
            } else {
                $(".btn-add-accounts").removeClass("collapse");
            }

        }

    }

    function removeOtherAccount(tag) {

if (confirm("Do you want to delete")) {

    $(tag).parents('.item-add-other-accounts').remove();

    if ($('.addOtheraccounts-component').children().length == 0) {
        AddOtherAccounts();

    } else {
        $(".btn-add-other-accounts").removeClass("collapse");
    }

}

}

    $(document).ready(function() {


        //              code to add accounts started
        $(".btn-add-accounts").on("click", function() {
            AddSubAccounts();
        });

        //              code to add other accounts started
        $(".btn-add-other-accounts").on("click", function() {
            
            AddOtherAccounts();
        });
        $(".btn-add-other-account-item").on('click', function() {
            label = $('.other-account-name').val().trim();
            label = label.trim();
            if (label == "") {
                alert("input account name");
            } else {
                link_tag = '<label  class="other-account-name-label" > ' + label + '  </label>';

                $(".btn-add-other-accounts").removeClass("collapse");
                ele = $('<div class="my-2 mx-2 col-lg-12 col-md-12 new row item-add-other-accounts" style="padding:10px" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > ' + link_tag + ' <i class="fa fa-times btn-remove-sub-other-account-item" onclick="removeOtherAccount(this)" ></i> </div>   <div>  <input type="text" placeholder = "رقم الحساب" class="form-control other-account-number" /> <input type="text" placeholder = "ملاحظة" class="form-control other-account-note" />    </div>');
                $(".addOtheraccounts-component").prepend(ele);
                $('.addOtheraccounts-component').removeClass("collapse");
            }
        });
        

        $(".btn-add-account-item").on('click', function() {
            label = $('.account-name').val().trim();
            label = label.trim();
            if (label == "") {
                alert("input bank name");
            } else {
                link_tag = '<label  class="bank-name-label" > ' + label + '  </label>';

                $(".btn-add-accounts").removeClass("collapse");
                ele = $('<div class="my-2 mx-2 col-lg-12 col-md-12 new row item-add-accounts" style="padding:10px" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > ' + link_tag + ' <i class="fa fa-times btn-remove-sub-account-item" onclick="removeAccount(this)" ></i> </div>   <div>  <input type="text" class="form-control person-name" placeholder = "اسم المحول له" />  <input type="text" placeholder = "رقم الحساب" class="form-control account-number" /> <input type="text" placeholder = "رقم الايبان" class="form-control full-account-number" />    </div>');
                $(".addaccounts-component").prepend(ele);
                $('.addaccounts-component').removeClass("collapse");
            }
        });

        $('.btn-toggle-add-accounts').on('click', function() {
            $('.addaccounts-component').toggleClass("collapse");
            $(".btn-add-accounts").removeClass("collapse");
        });

        $('.btn-toggle-add-other-accounts').on('click', function() {
            $('.addOtheraccounts-component').toggleClass("collapse");
            $(".btn-add-other-accounts").removeClass("collapse");
        });
        
        //              code to add accounts ended

        $('.btn-toggle-payment-options').on("click", function() {
            $('.payment-methods').toggleClass('collapse');
        });
        $('.btn-toggle-order-options').on("click", function() {
            $('.order-methods').toggleClass('collapse');
        });


        $('.btn-toggle-add-contacts').on('click', function() {
            $('.addcontacts-component').toggleClass("collapse");
            $(".btn-add-contacts").removeClass("collapse");
        });

        $(".btn-add-contacts").on("click", function() {
            AddSubDetails();
        });


        $(".btn-primary").on('click', function() {
            value = $('.contacts option:selected').text().trim();
            value = value.trim();
            if (value == "Select Contact") {
                alert("input contact name");
            } else {
                link_tag = '<i id="' + CONTACTS_ICONS[value] + '" class="item-label ' + CONTACTS_ICONS[value] + '" >  </i>';
                type = "social";
                if (value == "Other") {
                    link_tag = '<input id="' + uuidv4() + '.png" class="item-label" onchange="saveIcon(this)" type = "file" />';
                    type = "app";
                }

                $(".btn-add-contacts").removeClass("collapse");
                ele = $('<div class="my-2 mx-2 col-lg-12 col-md-12 new row item-add-contacts" >  <div style="display:block;width: 100%;" >   <div style="display:flex;justify-content:space-between" > ' + link_tag + ' <i class="fa fa-times btn-remove-sub-details-item" onclick="remove(this)" ></i> </div>   <input class="my-2 item-contact form-control" placeholder="الارتباط أو الرقم" type="text" />  </div>   <textarea class="form-control item-desc" >وصف</textarea></div>');
                $(".addcontacts-component").prepend(ele);
                $('.addcontacts-component').removeClass("collapse");
            }
        });

    });
    // code for adding mulitple contacts ended
    function submitForm(event) {
        event.preventDefault();
        if ($('#main_theme_color_code_text').val()) {
            $('#main_theme_color_code_text').val("#" + $('#main_theme_color_code_text').val().toLowerCase());
        }
        event.target.submit();
    }

    function toggleBackColorCode(event) {
        if ($(event.target).hasClass('fa-plus')) {
            $('#back_theme_color_code').attr('type', 'color').val('').show();
            $('#back_theme_color_code_text').attr('type', 'text').val('').show();
        } else {
            $('#back_theme_color_code').attr('type', 'text').val('').hide();
            $('#back_theme_color_code_text').attr('type', 'text').val('').hide();
        }
        $(event.target).toggleClass('fa-times fa-plus');
    }


    function toggleMainColorCode(event) {
        if ($(event.target).hasClass('fa-plus')) {
            $('#main_theme_color_code').attr('type', 'color').val('').show();
            $('#main_theme_color_code_text').attr('type', 'text').val('').show();
        } else {
            $('#main_theme_color_code').attr('type', 'text').val('').hide();
            $('#main_theme_color_code_text').attr('type', 'text').val('').hide();
        }
        $(event.target).toggleClass('fa-times fa-plus');
    }


    function validateBackColorCode(e) {
        $('#back_theme_color_code').val('#' + e.target.value);
    }

    function validateColorCode(e) {
        $('#main_theme_color_code').val('#' + e.target.value);
    }

    function changeColorTextValue(e) {
        $('#main_theme_color_code_text').val(e.target.value.substring(1));
    }

    function changeBackColorTextValue(e) {
        $('#back_theme_color_code_text').val(e.target.value.substring(1));
    }

    function resetWorkingHours() {
        $('#open_from').val('');
        $('#open_to').val('');
    }
</script>
@endsection