@extends('layouts.app')
@section('head-scripts')
<link rel="stylesheet" href="{{asset('css/theme-4.css'). '?_=' . config('app.version_date')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
@include('layouts.main-color-style', ['color' => $restaurant->main_theme_color_code??'#8140a8'])
@include('layouts.menu-partials.phone_code')

<link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
</link>
<style>
@font-face {
    font-family: <?php echo $restaurant->font_style == 'none' ? '' : $restaurant->font_style; ?>;
    src: url("{{asset('fonts/02f502e5eefeb353e5f83fc5045348dc.eot')}}");
    src: url("{{asset('fonts/02f502e5eefeb353e5f83fc5045348dc.eot?#iefix')}}") format("embedded-opentype"),
    url("{{asset('fonts/02f502e5eefeb353e5f83fc5045348dc.woff2')}}") format("woff2"),
    url("//db.onlinewebfonts.com/t/02f502e5eefeb353e5f83fc5045348dc.woff") format("woff"),
    url("//db.onlinewebfonts.com/t/02f502e5eefeb353e5f83fc5045348dc.ttf") format("truetype"),
    url("//db.onlinewebfonts.com/t/02f502e5eefeb353e5f83fc5045348dc.svg#GE SS Two Light") format("svg");
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
<div id="app" v-cloak>
    <div style="display:flex;justify-content:center;">
        <div class="col-lg-6  border col-sm-12 col-md-12" style="position:relative;padding:0px;overflow: hidden;;border-radius: 20px !important;">
        <div style="position:relative" class="back-images" >
                <i class="language" style="font-size:10px;"> @include('layouts.lang') </i>
                <div class="rating" >
                    @include('layouts.rating')
                </div>
                @if($restaurant->is_logo_active == 1)
                <div class="logo">
                    <img loading="lazy" src="{{$restaurant->logoUrl()}}" alt="" width="100" height="100" class="shadow" >
                </div>
                @endif
                <div class="d-flex bg-images" >
                    @foreach(json_decode($restaurant->backgroundImageUrl()) as $index => $info)                
                                    @if($index == 0)
                                        <img loading="lazy"  style="display: block;" src="{{$info}}" class="cover slide" alt="{{$restaurant->name}}">
                                    @else
                                        <img loading="lazy" style="display: none;" src="{{$info}}" class="cover slide" alt="{{$restaurant->name}}"> 
                                    @endif
                    @endforeach
                </div>    
            </div>
            <br>
            <div class="titles text-center mx-2">

                <div style="font-size: 25px;font-weight: bold;">
                    @foreach(explode('/', $restaurant->name) as $name)
                    <label class="shop_name">{{$name}}</label>
                    <br>
                    @endforeach
                </div>



                <div class="d-flex justify-content-center">
                </div>
                @include('layouts.menu-partials.working-hours')
                <div class="text-center">
                    @include('layouts.menu-partials.contacts')
                </div>
                <div class="text-center">
                    @include('layouts.menu-partials.notes')
                </div>
            </div>
            <!-- shwowing categories -->
            <div class="collapse" style="background-color:transparent">

                @foreach($restaurant->categories as $category)
                @foreach(explode('---', $category->name ) as $index => $info)
                @if($info == $lang)
                @foreach(explode('---', $category->name ) as $index => $info)
                @if($index == 0)
                <a class="border flatted-well category" id="{{$category->id}}">
                    {{$info}}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach
                @endforeach

            </div>
            <!-- showing categories ended  -->
        </div>
    </div>
    <div class="main-content mx-4">
        <div class="col-lg-4 offset-lg-4 offset-md-3 col-md-3" id="items-container" style="border: none;" v-cloak>
            @foreach($restaurant->categories->sortBy('priority') as $category)

            @foreach(explode('---', $category->name ) as $index => $info)
            @if($info == $lang)
            <div class="col-lg-12 col-md-12 col-sm-12 py-2" >
                <button class="width-100 d-flex justify-content-space-between align-items-center box-categories" onclick="toggleItems(document.getElementById('item_{{$category->id}}'))" >
                    {{explode('---', $category->name )[0]}}
                    <i class="fa fa-plus" ></i>
                </button>
            </div>
            <div class="justify-content-center item" style="text-align:center" id="item_{{$category->id}}">
                <div >
                    @foreach($category->items->sortBy('priority') as $item)

                    @if($item->is_visible)

                    <div style="background-color:transparent" class=" {'{{(!$item->is_available) ? '': ''}}': true, 'added': typeof cart[{{$item->id}}] !== 'undefined'}">
                        <div class="item-wrapper" style="position: relative;background-color:transparent;font-size:18px;margin-bottom:20px;margin-bottom:30px;border-radius:40px;">
                            <div class="text-center mt-3" style="margin:10px">
                                @foreach(explode('/', $item->name) as $info)

                                <label style="word-break: keep-all;
                                                            font-size: 20px ;
                                                            color: black;" class="product-title  {{strlen($item->name)>20? 'extensable cursor-pointer': ''}}" {{strlen($item->name)>20? 'onclick=expandTitle(event)': ''}}>
                                    {{$info}}
                                </label>
                                <br>
                                @endforeach
                            </div>

                                <div class="border-radius-10 " >
                                    <div class="align-items-center position-relative" style="border-radius:40px;display:flex;justify-content:center">
                                    <img loading="lazy" src="{{$item->image_path}}" alt="{{$item->name}}" class="item-image" aria-view="true">
                                    @if($item->new)  
                                    <img src="/public/images/new.png" class="icon-new" width="35" height="35" alt="">    
                                    @endif
                                    
                                    </div>
                                    <div class="container" >
                                        @include('layouts.menu-partials.allergens')
                                    </div>    
                                </div> 
                            <div class=" collapse text-center mt-3 px-4" style="margin:10px;display:none">
                                @foreach(explode('/', $item->description) as $info)
                                <label style="word-break:keep-all;display:normal;font-size:15px;color:gray;max-width:200px" class="product-title  {{strlen($item->description)>20? 'extensable cursor-pointer': ''}}" {{strlen($item->description)>20? 'onclick=expandTitle(event)': ''}}>
                                    {{$info}}
                                </label>
                                <br>
                                @endforeach
                            </div>

                            <div class="d-flex px-4 position-relative justify-content-between align-items-center mb-2 min-height"  >
                                <div class="">
                                    <div class="description" >
                                    @foreach(explode('/', $item->description) as $info)
                                        <label>
                                            {{$info}}
                                        </label>                           
                                    @endforeach 
                                    </div>
                                    
                                    @if($item->calories)
                                        <span class="word-break calories">{{$item->calories}} كالورى</span>
                                    @endif

                                </div>
                                <div class="place-order  align-items-center position-absolute-10-5"   >
                                        @if($restaurant->enable_component > 0 && $item->is_available)

                                        @if($item->quantity_summary && $item->quantity_summary['total'] !=null && $item->quantity_summary['remaining'] == 0)
                                                <div class="item-out-of-stock-for-consumer" >
                                                        <label for="">
                                                        <b>
                                                            نفذت الكمية
                                                        </b>
                                                        </label>
                                                </div> 
                                            @else 

                                            <div>
                                                <button class="item-action-button  cursor-pointer nb-no" style="border-radius:40px;"  v-if="typeof cart[{{$item->id}}] === 'undefined'" @click="addToCart({{$item}} , getSubDetailsData({{$item->id}})) ">
                                                                <i class="fa fa-plus" ></i>
                                                                </button>
                                                                <button class=" item-action-button cursor-pointer nb-no" v-if="typeof cart[{{$item->id}}] !== 'undefined'" @click="removeFromCart({{$item->id}})"
                                                                > 
                                                                <i class="fa fa-minus" ></i>
                                                            </button>
                                            </div>
                                            @endif
                                        @endif

                                    <div class="price" >
                                        @if($item->current_price > 0)
                                        <span class="fs-12 d-block price-tag">{{$item->current_price}} {{$restaurant->currency}}</span>
                                        @endif

                                        @if($item->old_price > $item->current_price && $item->old_price > 0 )
                                        <span class="strike text-danger d-block">{{$item->old_price}} {{$restaurant->currency}}</span>
                                        @endif
                                   </div>
                                </div>
                                @if($item->calories)
                                @endif
                            </div>

                            <div>
                                @include('layouts.menu-partials.sub_details')

                            </div>
                            <br>
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
            @include('layouts.menu-partials.made-with-love')
        </div>

        @if($restaurant->enable_component > 0)
        <div class="d-flex justify-content-around align-items-center" id="order-section">
            <button style="justify-content: center;display: flex;    background-color: transparent;    color: black;margin:0px;padding:0px" :class="{'flatted-well cursor-pointer w-100-sm w-50': true, active: cartItemsCount, 'not-allowed' :cartItemsCount===0 }" id="place-order" data-toggle="modal" data-target="#place-order-modal" :disabled="cartItemsCount===0">
                <span style="position: absolute;padding: 2px;color: black;background-color: white;right: 7%;top: 1%;" class="items-count">@{{cartItemsCount}}</span>

                </span>

                <i class="fs-12 fas fa-shopping-cart ml-2" style="border-radius: 5px;padding: 10px;background-color: white;"></i>
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
    // showing category items started
    var MAIN_THEME_COLOR = "{{$restaurant->main_theme_color_code??'#8140a8'}}";
    var childcounter = 0;
    $(function() {
        setBackElementsThisTheme();
    });

    function toggleItems(item)
    {
        $(item).slideToggle();
    }
    var slideIndex = 0;
    setInterval(function() {
        var i;
        var slides = document.getElementsByClassName("slide");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        slides[slideIndex - 1].style.display = "block";
    }, 3000);
</script>
@endsection
