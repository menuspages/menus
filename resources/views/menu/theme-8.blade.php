@extends('layouts.app')
@section('head-scripts')
<link rel="stylesheet" href="{{asset('css/theme-8.css'). '?_=' . config('app.version_date')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
@include('layouts.main-color-style', ['color' => $restaurant->main_theme_color_code??'#8140a8'])

<script>
    // code for category animation started
    $(document).ready(function() {
        $(".category-items-box").children('label').click(function() {
            id = $(this).attr('id');
            $(".category-items-box").children('label').removeClass("selected");
            $(this).addClass("selected");
            // $("#items-container").hide();
            $("#items-container").animate({
                scrollTop: $("#box" + id).offset().top
            }, 100);
        });

    });
    // code for category animation is ended
    function phone_code() {
        return '<?php echo $restaurant->phone_code ?>';
    }
</script>

<style>
  .place-order button 
  {
    background-color:transparent;
    font-size: 20px;
  }
  .place-order 
  {

  }
    .logo 
    {
        top: 10%;
        right: 2%;
        z-index: 1;
    }
    #app_main 
    {
        height: 100vh;
        overflow: auto;
    }
    body {
        background: #f5f5e9;
        font-size: 14px;
    }


    .item {
        border: none;
        border-radius: 0px;
    }

    .label-allergens 
    {
        font-size:20px;
    }

    @media only screen and (max-width: 600px) {

        .items-container,
        .container-fluid {
            padding: 0px !important;
            margin-top: 3px;
        }

        .disabled {
            margin: 0px;
        }

        .slide {
            height: 200px;
            width:100%;
        }

        .titles {

            position: absolute !important;
            z-index: 100 !important;
            bottom: -2%;
            left: 2%;
            right: 2%;

        }

        .logo {
                        /* box-shadow: 0 6px 15px rgb(0 0 0 / 18%); */
                        position: absolute;
            right: 2%;
            justify-content: center;
            display: flex;
            left: 2%;
            top:30%;
            border-radius: 100px;
        }
        .frame-parent 
        {
            height: 300px;
        } 

    }

    @media only screen and (min-width: 600px) {
      #items-container {
        width: 60%;
      }
        .d-flex
        {
            justify-content:space-around;
        }
        .frame-parent 
        {
            height: 600px;
        }    
        .titles {

            position: absolute !important;
            z-index: 100 !important;
            left: 30% !important;
            right: 30% !important;
            bottom: 3%;

        }

        .slide {
            height: 600px;
        }

        .space {
            height: 300px;
        }

        .logo {
            /* box-shadow: 0 6px 15px rgb(0 0 0 / 18%); */
            position: absolute;
            right: 2%;
            justify-content: center;
            display: flex;
            left: 2%;
            border-radius: 100px;
        }
    }
    
    .item-image {
        box-shadow: none;
    }

    .item-action-button:hover {
        background-color: black !important;
        color: white !important;
        border-radius:40px;border:solid 1px black !important;color:black
    }
    .item-action-button
    {

    }
    h2.category-header {
        background: none;
        display: inline-block;
        border-radius: 25px;font-size:20px;font-weight:900;overflow:hidden;width: fit-content;
    }


    .cart {
        outline: none;
        border: none;
    }

    .category-box label {
        padding: 10px;
        margin: 10px;
        border: solid 1px grey;
        white-space: nowrap;
        border-radius: 10px;

    }

    .category-items-box {
        background-color: white;
        display: flex;
        overflow: auto;
    }


    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: grey;
        border-radius: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #b30000;
    }


    .category-box-fixed {
        width: 100%;
        position: fixed;
        z-index: 100;
        top: 2%;
    }

    .language 
    {
        position: fixed;
        font-size: 10px;
        z-index: 4;
    }
    .selected {
        color: white;
        background-color: brown;
    }
    .frame-parent 
    {
        
        position: relative;
    }
    .frame
    {
        position: absolute;
        bottom: 3%;
        top: 3% !important;
        z-index: 10;
        right: 3%;
        left: 3%;
    }
    .allergens {
        font-size:2px;
        text-align:center;
    }
    .item-allergens 
    {
        margin:6px;
    }
    .language
    {
        margin:6px
    }
    .language a
    {
        padding:6px;
    }
    .center 
    {
        text-align: center;
    }
    .restuarant-title 
    {
        font-size: 20px;font-weight: bold
    }

    #app 
    {
        padding: 0px 10px 10px 10px;
    }
    .no-padding 
    {
        padding:0px !important;
    }
    .position-relative 
    {
        position: relative;
    }
    .logo img 
    {
        z-index: 1;border: solid 2px #383838;border-radius: 100px;box-shadow: rgb(0 0 0 / 18%) 0px 6px 15px;
    }
    .item-wrapper 
    {
        overflow: hidden;
    width: 80%;
    background-color: white;
    font-size: 10px;
    margin-bottom: 20px;
    margin-bottom: 30px;
    border-radius: 40px;
    position: relative;
    
    } 
    .d-flex-content-center{
        text-align: center;
        background-color: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
    }
     .item-wrapper { text-align:right;}
    
    .slide 
    {
      object-fit: cover;
    }
    .container-add-to-cart{
        margin: 0px 20px 0px 20px;
        border-radius: 40px;
        border: solid 2px #adadad !important;
    }
    @if($restaurant->enable_component > 0)
    .btn-open_details 
    {
        display:none !important;
    }
    @endif
</style>
@endsection
@section('body-content')
<div id="app_main" >
<div id="app"  v-cloak>
<div class="my-2" >
</div> 
<div class="no-padding"  >
<div class="position-relative" >
            <i class="language" style> @include('layouts.lang') </i>
            @if($restaurant->is_logo_active == 1)
            <div class="logo">
                <img loading="lazy" src="{{$restaurant->logoUrl()}}" alt="" width="100" height="100" class="shadow" >
            </div>
            @endif
            <div class="d-flex" >
            @foreach(json_decode($restaurant->backgroundImageUrl()) as $index => $info)                
                            @if($index == 0)
                                <img loading="lazy"  style="display: block;" src="{{$info}}" class="cover slide" alt="{{$restaurant->name}}">
                            @else
                                <img loading="lazy" style="display: none;" src="{{$info}}" class="cover slide" alt="{{$restaurant->name}}"> 
                            @endif
            @endforeach
            </div>    
</div>
</div>    
<!-- category box started -->
<div class='category-box px-2 py-2 collapse'>
    <div class="category-items-box">
        @foreach($restaurant->categories->sortBy('priority') as $category)
        @foreach(explode('---', $category->name ) as $index => $info)
        @if($info == $lang)
        @foreach(explode('---', $category->name ) as $index => $info)
        @if($index == 0)
        <label id="{{$category->id}}"> <b>{{$info}} </b> </label>
        @endif
        @endforeach
        @endif
        @endforeach
        @endforeach
    </div>
</div>
<!-- category box ended -->
<div>
    
<div class="cover col-lg-6 col-md-12 col-sm-12 offset-lg-3" >
<div class="center restuarant-title" >
        @foreach(explode('/', $restaurant->name) as $info)
        <label class="shop_name" style="font-size:25px;" >{{$info}}</label>
        
        @endforeach
    </div>
</div>    

    <div>
        @include('layouts.menu-partials.working-hours')
    </div>
    <div class="text-center">
        @include('layouts.menu-partials.contacts')
        @include('layouts.menu-partials.notes')
    </div>
</div>



<div class="main-content" id="content">
    <div class="container-fluid d-flex justify-content-center  flex-column" id="items-container" v-cloak>
        @foreach($restaurant->categories->sortBy('priority') as $category)

        @foreach(explode('---', $category->name ) as $index => $info)
        @if($info == $lang)


        @foreach(explode('---', $category->name ) as $index => $info)
        @if($index == 0)
        <div class="text-center" style="overflow: auto;width: 100%;" >
            <h2 id="box{{$category->id}}" class="px-4 py-2 bg-white category-header bg-white text-center ">
                {{$info}}
            </h2>
        </div>
        @endif
        @endforeach
        <div class="justify-content-center ">
            <br>
            <div style="justify-content: space-between;padding:0px;margin:0px !important" class="" {!! $category->items->count()? 'style="height: 22rem;"' : '' !!}>
                @foreach($category->items->sortBy('priority') as $item)
                @if($item->is_visible)

                <div style="background-color:transparent;" class="d-flex-content-center {'{{(!$item->is_available) ? '': ''}}': true, 'added': typeof cart[{{$item->id}}] !== 'undefined'}">
                    <div class="item-wrapper" >
                        <div class="align-items-center position-relative" style="border-radius:40px;display:flex;justify-content:center">
                            <img loading="lazy" src="{{$item->image_path}}" alt="{{$item->name}}" style="object-fit: cover;;border-radius:10px 10px 0px 0px;background-color:#C0D1A0;" class="item-image" aria-view="true">
                            @if($item->new)  
                                    <img src="/public/images/new.png" class="icon-new" width="35" height="35" alt="">    
                            @endif
                        </div>
                        <div class="container allergens" >
                                     @include('layouts.menu-partials.allergens')
                        </div>     
                        <div class="text-center" >
                            <label style="display:normal;word-wrap: break-word;margin-bottom:0px;max-height: 60px;overflow:hidden;font-size: 20px;" class="product-title  {{strlen($item->name)>20? 'extensable cursor-pointer': ''}}" {{strlen($item->name)>20? 'onclick=expandTitle(event)': ''}}>{{$item->name}}</label>
                        </div>
                        
                        <div class="text-center collapse"  >
                            <label style="margin-bottom:0px;;word-break:break-all;display:normal;color:gray;max-width:200px;overflow: hidden;max-height: 25px;" class="product-title  {{strlen($item->description)>20? 'extensable cursor-pointer': ''}}" {{strlen($item->description)>20? 'onclick=expandTitle(event)': ''}}>{{$item->description}}</label>
                        </div>
                        <div class="text-center" >
                            @include('layouts.menu-partials.sub_details')
                        </div>    
                        @if($restaurant->enable_component > 0 && $item->is_available)
                     
                        <div class="place-order justify-content-center align-items-center" >
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price w-100">
                                <div class="d-flex justify-content-around" >
                                    @if($item->old_price > $item->current_price)
                                    <fonts class="text-danger d-block"  style="font-size:16px" >{{$item->old_price}} {{$restaurant->currency}}</fonts>
                                    @endif

                                    @if($item->calories)
                                    <span class="word-break collapse calories">{{$item->calories}} كالورى</span>
                                    @endif
                                    
                                </div>  
                            </div>
                          
                        </div>               
                        <div style="text-align:center;margin-top:5px;font-size:18px" >
                            <span class="price-tag" style="font-size:18px" >{{$item->current_price}} {{$restaurant->currency}}</span>  
                        </div>  
                             
                            @if($item->quantity_summary && $item->quantity_summary['total'] !=null && $item->quantity_summary['remaining'] == 0)
                                    <div class="item-out-of-stock-for-consumer text-center my-2" >
                                            <label for="">
                                            <b>
                                                نفذت الكمية
                                            </b>
                                            </label>
                                    </div> 
                            @else 

                            <div class="container-add-to-cart border border-radius-10" >
                                <button class=" btn-block item-action-button active cursor-pointer nb-no"  v-if="typeof cart[{{$item->id}}] === 'undefined'" @click="addToCart({{$item}})">
                                    {{$language["add_to_cart"]}}
                                </button>
                                <button class=" btn-block item-action-button cursor-pointer nb-no" v-if="typeof cart[{{$item->id}}] !== 'undefined'" @click="removeFromCart({{$item->id}})">
                                    {{$language["remove_from_cart"]}} 
                                </button>
                            </div>
                            <br>
                            @endif
                        
                        </div>
                      
                        @endif
                    </div>
                </div>

                @endif
                @endforeach

                @if(!count($category->items))
                <p>ﻻ توجد منتجات حالياً</p>
                @endif
            </div>
        </div>
        @endif
        @endforeach
        @endforeach
    </div>

    @include('layouts.menu-partials.made-with-love')

    @if($restaurant->enable_component > 0)
    <div class="d-flex justify-content-around align-items-center" id="order-section">
        <button style="background-color:white;position:relative" :class=" {'flatted-well cursor-pointer w-100-sm w-50': true, active: cartItemsCount, 'not-allowed' :cartItemsCount===0 }" id="place-order" data-toggle="modal" data-target="#place-order-modal" :disabled="cartItemsCount===0">
            <span class="items-count">@{{cartItemsCount}}</span>
            <i style="color:black" class="fs-12 fas fa-shopping-cart ml-2"></i>
        </button>
    </div>
    @include('layouts.menu-partials.place-order-modal')
    @endif
</div>
@include('layouts.menu-partials.floating-alert')
</div>
</div>
@endsection

@section('body-scripts')

<script src="{{asset('js/menu.js')}}"></script>
<script>
    function expandTitle(event) {
        $(event.target).removeClass('extensable').removeClass('cursor-pointer').closest('div.item-wrapper').first().addClass('expanded scrollable-hidden-bar');
    }
</script>
@include('layouts.image-viewer')

<script>

// loading on page load
    $(function () {
        setBackElementsThisTheme();
    });
    function setBackElementsThisTheme() {
        var data = "{{$restaurant->back_theme_color_code}}";
        data = JSON.parse(data.replace(/&quot;/g,'"'));
        if(data["type"] == 1)
        {
            $("#app_main").css({
                "background-image" : "url('"+data["value"]+"')" ,
                "background-size" : "cover"
            });
            $('.cover').css({'background-color' : 'rgba(255,255,255,0.3)'})
        }
        else 
        {
            $("#app_main").css({
                "background-color" : "#"+data["value"] ,
                "background-size" : "cover"
            });
        }
        $('.cover').css({'background-color' : hexToRgbA("#"+data["value"])})
        console.log(hexToRgbA("#"+data["value"]))
    }
function hexToRgbA(hex){
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
        c= hex.substring(1).split('');
        if(c.length== 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgba('+[(c>>16)&220, (c>>8)&220, c&220].join(',')+',0.1)';
    }
    throw new Error('Bad Hex');
}

    $(window).scroll(function() {
        var height = $(window).scrollTop();

        if (height > 5) {

            $('.category-box').addClass("category-box-fixed");

        }


        if (height == 0) {

            $('.category-box').removeClass("category-box-fixed");

        }
    });



</script>
@endsection
