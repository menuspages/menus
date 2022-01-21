@extends('layouts.app')
@section('head-scripts')
<link rel="stylesheet" href="{{asset('css/theme-5.css'). '?_=' . config('app.version_date')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
@include('layouts.main-color-style', ['color' => $restaurant->main_theme_color_code??'#8140a8'])
<script>
    function phone_code() {
        return '<?php echo $restaurant->phone_code ?>';
    }
</script>
<style>
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
    <div class="d-flex-center" >
        <div class="col-lg-6  border col-sm-12 col-md-12 item-container" >
            <div class="pos-relative" >
                <i class="language" > @include('layouts.lang') </i>
                <div class="rating" >
                    @include('layouts.rating')
                </div>
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
            <br>
            <div class="titles text-center mx-2">

                <div class="product-title" >

                    @foreach(explode('/', $restaurant->name) as $info)
                    <label class="shop_name" >{{$info}}</label>
                    <br>
                    @endforeach
                </div>



                <div class="d-flex justify-content-center">

                </div>
                @include('layouts.menu-partials.working-hours')
                <div class="text-center">
                    @include('layouts.menu-partials.notes')
                </div>
                <div class="text-center">
                    @include('layouts.menu-partials.contacts')
                </div>


            </div>

            <!-- shwowing categories -->

            <div class="box-categories">

                @foreach($restaurant->categories->sortBy('priority') as $category)
                @foreach(explode('---', $category->name ) as $index => $info)
                @if($info == $lang)


                @foreach(explode('---', $category->name ) as $index => $info)
                @if($index == 0)
                <a class="border flatted-well category" @click="chooseActiveCategory({{$category->id}})" id="{{$category->id}}">
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




    <div class="main-content">
        <div class="container-fluid  justify-content-center  flex-column" id="items-container"  v-cloak>
            @foreach($restaurant->categories as $category)

            @foreach(explode('---', $category->name ) as $index => $info)
            @if($info == $lang)
            <div class="mt-4 justify-content-center item collapse"  id="item_{{$category->id}}">
                <div class="item-carousal" {!! $category->items->count()? 'style=";"' : '' !!}>
                    @foreach($category->items->sortBy('priority') as $item)

                    @if($item->is_visible)

                    <div  class="item-wrapper-parent {'{{(!$item->is_available) ? '': ''}}': true, 'added': typeof cart[{{$item->id}}] !== 'undefined'}">
                            <div class="" >
                            <div class="item-wrapper" >
                            <div class="align-items-center" >
                                <img  src="{{$item->image_path}}" alt="{{$item->name}}"  class="item-image" aria-view="true">
                            </div>
                            <div class="container" >
                                        @include('layouts.menu-partials.allergens')
                                    </div>    
                            <div class="text-center" >
                                @foreach(explode('/', $item->name) as $info)

                                <label  class="max-width-100 limited-heigth-50 product-title  {{strlen($item->name)>20? 'extensable cursor-pointer': ''}}" {{strlen($item->name)>20? 'onclick=expandTitle(event)': ''}}>
                                    {{$info}}
                                </label>
                                <br>
                                @endforeach
                            </div>
                            <br>
                            <div class="price">
                                    <div class="text-left px-4" >
                                        @if($item->old_price > $item->current_price && $item->old_price > 0 )
                                        <span class="strike text-danger my-2 d-block">{{$item->old_price}} {{$restaurant->currency}}</span>
                                        @endif
                                        @if($item->current_price > 0)
                                        <span class="fs-12 d-block price-tag">{{$item->current_price}} {{$restaurant->currency}}</span>
                                        @endif
                                    </div>    
                                    <div class="text-left px-4" >
                                        @if($item->calories)
                                            <span class="word-break calories">{{$item->calories}} كالورى</span>
                                        @endif
                                    </div>    
                                </div>
                                  @include('layouts.menu-partials.sub_details')
                                 <div  id="add_to_cart_avl{{$item->id}}" class="keep-bottom px-4 py-2"  >
                                @if($restaurant->enable_component > 0 && $item->is_available)

                                @if($item->quantity_summary && $item->quantity_summary['total'] !=null && $item->quantity_summary['remaining'] == 0)
                                    <div class="item-out-of-stock-for-consumer" >
                                            <label class="border border-radius-10 px-2">
                                            <b>
                                                نفذت الكمية
                                            </b>
                                            </label>
                                    </div> 
                                @else 
                                <div class="place-order d-flex justify-content-center align-items-center" style="padding:0px !important" >
                                    <button class="border item-action-button active cursor-pointer nb-no"  v-if="typeof cart[{{$item->id}}] === 'undefined'" @click="addToCart({{$item}} , getSubDetailsData({{$item->id}})) "> {{$language["add_to_cart"]}}
                                    </button>
                                    <button class="border item-action-button cursor-pointer nb-no" v-if="typeof cart[{{$item->id}}] !== 'undefined'" @click="removeFromCart({{$item->id}})">احذف
                                    </button>
                                </div>
                                @endif
                                @endif


                            </div>
                            <br>
                        </div>
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
        <div class="d-flex justify-content-around align-items-center" id="order_section">
            <button  :class="{'flatted-well cursor-pointer w-100-sm w-50': true, active: cartItemsCount, 'not-allowed' :cartItemsCount===0 }" id="place-order" data-toggle="modal" data-target="#place-order-modal" :disabled="cartItemsCount===0">
                <span  class="items-count">@{{cartItemsCount}}</span>

                </span>

                <i class="fs-12 fas fa-shopping-cart ml-2 btn-shopping-cart"></i>
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
    var childcounter = 0;
    var MAIN_THEME_COLOR = "{{$restaurant->main_theme_color_code??'#8140a8'}}";

    $(function() {
        // setting back theme elements
        setBackElementsThisTheme();
        // code about cateogries box
        var tag = $(".box-categories").children().eq(childcounter);
        var attr_id = tag.attr('id');
        tag.addClass("category-selected");
        tag.css({"background-color" : MAIN_THEME_COLOR});
        $("#item_" + attr_id).removeClass('collapse');
    });

    $(".box-categories").children('a').on('click', function() {
        $('.box-categories').children('a').addClass("category-unselected");
        $(this).removeClass("category-unselected");
        $(this).addClass("category-selected");
        $(this).css({"background-color" : MAIN_THEME_COLOR});
        $('.item').addClass("collapse");
        $("#item_" + $(this).attr("id")).removeClass('collapse');
    });

    // showing category items ended

</script>
@endsection