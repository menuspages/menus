@extends('layouts.app')

@section('head-scripts')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset('css/theme-9.css'). '?_=' . config('app.version_date')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
@include('layouts.image-viewer')
@include('layouts.main-color-style', ['color' => $restaurant->main_theme_color_code??'#8140a8'])
<style>

  @if($restaurant->enable_component > 0)
  .btn-open_details 
  {
      display:none !important;
  }
  @endif
</style>

<!-- code for background photos started-->
<script>
  counter = 0;

  $(document).ready(
    function() {

      $('.sub-details').on('click' , function()
      {
          var id = $(this).attr("id");
          $("#a"+id).removeClass("collapse");
      });

      var divClone = $('.back-images').clone();

      var intervalId = window.setInterval(function() {
        $('.back-images').children().eq(counter).animate({
          width: '-10px',
          height: '-10px'
        }, 0);
        // $(".images").append($(".images").children().eq(counter).animate({width: '100px'}));
        counter++;
        if (counter == $(".back-images").children().length) {
          $('.back-images').replaceWith(divClone.clone());
          counter = 0;
        }

      }, 5000);
    }
  );
</script>
<!-- code for background photos ended-->
@endsection
@section('body-content')

<!-- main div started -->
<div class="main-div-upper">
<div id="app" class="container main-div border" v-cloak >
@if($restaurant->enable_component > 0)
        <div class="d-flex justify-content-around align-items-center" id="order-section">
          <button :class="{'no-margin flatted-well cursor-pointer w-100-sm w-50': true, active: cartItemsCount, 'not-allowed' :cartItemsCount===0 }" id="place-order" data-toggle="modal" data-target="#place-order-modal" :disabled="cartItemsCount===0">
                <div class="add-to-cart" >
                    <span class="items-count">@{{cartItemsCount}}</span>
                    <span class="position-relative mr-4">
                    </span>
                    {{$language["item_added_to_cart"]}}
                    <i class="fs-12 fas fa-shopping-cart ml-2"></i>
                </div>

          </button>
        </div>
        @include('layouts.menu-partials.place-order-modal')
        @endif

    <div class=" row col-lg-12 col-md-12 col-sm-12  ">



      <div class="col-lg-6 col-md-12 col-sm-12" style="position: relative;">



        <div class="row" style="padding: 0px !important;margin: 0px !important;">
          <div class="back-images col-lg-12 col-md-12 col-sm-12" style="padding: 0px !important;margin: 0px ;">

            @foreach(json_decode($restaurant->backgroundImageUrl()) as $index => $info)
            <div style="background-image: url('{{$info}}'), linear-gradient(rgb(0 0 0 / 100%) , rgb(246 246 246 / 20%) , rgb(246 246 246 / 100%));background-blend-mode: overlay;"></div>
            @endforeach
          </div>
          
        </div>
        <div class="images-overlays col-lg-12 col-md-12 col-sm-12">

          <i class="language" style="font-size:10px;"> @include('layouts.lang') </i>
          <img loading="lazy" src="{{$restaurant->logoUrl()}}" aria-view="true" class="logo" alt="" style="border-radius: 100px;">

          <i class="fa fa-share" style="color:transparent;" > </i>

        </div>


      </div>

      <div class="col-lg-6 col-md-12 col-sm-12 bg-white" style="direction: ltr;">

        <div class="product-box" style="justify-content: center;overflow-x: hidden;">

        <div>
                <div style="font-size: 20px;font-weight: bold;text-align: center;margin:5px" >
                @foreach(explode('/', $restaurant->name) as $info)
                    <label class="shop_name" >{{$info}}</label>
                    <br>
                @endforeach
                </div>

                <div class="mx-2 py-2" >
                @include('layouts.menu-partials.working-hours')
                </div>

                <div class="text-center" >
                        @include('layouts.menu-partials.contacts')
                </div>


                <div class="text-center" >
                  @include('layouts.menu-partials.notes')
                </div>
            </div>


          @foreach($restaurant->categories->sortBy('priority') as $category)

          @foreach(explode('---', $category->name ) as $index => $info)
          @if($info == $lang)

          @foreach(explode('---', $category->name ) as $index => $info)

          <div class="text-center">

            @if($index == 0)
            <label class="categhories border my-4" class="category-header bg-white text-center">
              {{$info}}
            </label>
            @endif
            @endforeach


          </div>
          <div  class=" product-main col-lg-12 col-md-12 col-sm-12  my-2">
            @foreach($category->items->sortBy('priority') as $item)
            @if($item->is_visible)

            <!-- product items started -->


            <div class="product border" style="position:relative" >
              <div class="product-box-part-1">

                <div style="display:flex;justify-content:center">
                  <img loading="lazy" src="{{$item->image_path}}" alt="{{$item->name}}" class="item-image" aria-view="true" />
                </div>
                <div class="border-radius-10  allergens border-radius-10" >
                                     @include('layouts.menu-partials.allergens')
                </div>
                <br>   
                <label class="title d-block" for="">{{$item->name}}</label>
                @foreach(explode('/', $restaurant->description) as $info)
                  <label class="description" for="">{{$info}}</label>
                  <br>
                @endforeach
                @if($item->calories)
                <div>
                  <span class="word-break calories">{{$item->calories}} كالورى</span>
                </div>
                @endif


              </div>
              <div class="text-center btn-sub-details" >
                            @include('layouts.menu-partials.sub_details')
               </div> 
              @if($restaurant->enable_component > 0 && $item->is_available)
              <div class="product-box-part-2">
              <div style="direction: rtl;" >
               <label class="price" for="">{{$item->current_price}} {{$restaurant->currency}}</label>
                @if($item->old_price > $item->current_price)
                <label  class="price" style="text-decoration: line-through;" >{{$item->old_price}} {{$restaurant->currency}}</label>
                @endif
               </div>

               @if($item->quantity_summary && $item->quantity_summary['total'] !=null && $item->quantity_summary['remaining'] == 0)
                                    <div class="item-out-of-stock-for-consumer" >
                                            <label for="">
                                              <b>
                                                  نفذت الكمية
                                              </b>
                                             </label>
                                   </div> 
                @else 
                <div class="btn-cart" id="add_to_cart_avl{{$item->id}}" style="margin-top:20px" >
                  <label class="border px-2"  v-if="typeof cart[{{$item->id}}] === 'undefined'" @click="addToCart({{$item}} , getSubDetailsData({{$item->id}}))" style="margin-right:2px;border-color:black !important;border-radius:100px" > {{$language["add_to_cart"]}} </label>
                  <label class="border px-2" v-if="typeof cart[{{$item->id}}] !== 'undefined'" @click="removeFromCart({{$item->id}})" style="margin-right:2px;background-color:#e29302;border-color:black !important;border-radius:100px" > {{$language["item_added_to_cart"]}} </label>
                </div>
                @endif
                </div>

              @endif
            </div>
            <!-- product items ended -->
            @endif
            @endforeach

            @if(count($category->items) == 0)

            <div class="text-center width-100"  >
            <p class="text-center " >ﻻ توجد منتجات حالياً</p>
            </div> 

            @endif
          </div>

          @endif
          @endforeach
          @endforeach

        </div>



      </div>
    </div>
  </div>


  <div>
    @include('layouts.menu-partials.made-with-love')

    @include('layouts.menu-partials.floating-alert')
  </div>



</div>
<!-- main div ended -->
@endsection

@section('body-scripts')

<script src="{{asset('js/menu.js')}}"></script>
<script>
  function expandTitle(event) {
    $(event.target).removeClass('extensable').removeClass('cursor-pointer').closest('div.item-wrapper').first().addClass('expanded scrollable-hidden-bar');
  }
</script>

@endsection
