@extends('layouts.app')
<?php

$language = array("eng"=> array(
	"add_to_cart"=>"Add to Cart" ,
	"item_added_to_cart"=>"items Added to Cart"
	)
	 ,
        "arb"=> array(
	"add_to_cart"=>"اضف الى السلة" ,
	"item_added_to_cart"=>"عنصر مضاف الى العربة"
        )

	);

?>


@section('head-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
    @include('layouts.main-color-style', ['color' => $restaurant->main_theme_color_code??'#8140a8'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>

// code for category animation started
$(document).ready(function()
{
  $(".category-items-box").children('label').click(function() {
    id = $(this).attr('id');
    $(".category-items-box").children('label').removeClass("selected");
    $(this).addClass("selected");
    // $("#items-container").hide();
    $("#items-container").animate({
        scrollTop: $("#box"+id).offset().top
    }, 100);
  });

});
// code for category animation is ended

</script>

  <style>

.category-box label
{
   padding:10px;
   margin:10px;
   border: solid 1px grey;
   white-space: nowrap;
    border-radius: 10px;

}

.category-items-box
{
  background-color:white;
  display: flex;
    overflow: auto;
}

.category-box-fixed
{
  width: 100%;
    position: fixed;
    z-index: 100;
    top: 2%;
}

.selected
{
  color:white;
  background-color:brown;
}

    @keyframes show {
      0% {
        transform: translateX(500px);
      }

      100% {
        transform: translateX(0px);
        opacity: 1;
      }
    }

    @keyframes hide {
      0% {
        transform: translateX(0px);
        opacity: 0;
      }

      100% {
        transform: translateX(500px);

      }
    }

    .animatation-show {

      animation-name: show;
      animation-duration: 1s;
      animation-fill-mode: forwards;
    }

    .animatation-hide {

      /* animation-name: hide;
            animation-duration: 1s;
            animation-fill-mode:forwards; */
    }

    .product-item {
      align-items: center;
      display: flex;
      opacity: 0;
      justify-content: space-evenly;
    }

    .product-item label {
      display: inline-block !important;
      font-size: 20px;
      font-weight: bold;
    }

    .price {
      color: green;
    }

    .title {
      color: #ec9901;
      text-overflow: ellipsis;
      display: inline-block;
      overflow: hidden;
      width: 100px;
      white-space: nowrap;
      direction: rtl;
      vertical-align: middle;
    }

    .logo {
      width: 100%;
    }

    .icon {
      width: 60px;
      height: 60PX;
    }

    .item-image {
      opacity: 0;
      width: 300px;
      height: 300px;
      object-fit: contain;
    }

    .icon-value {
      position: absolute;
      left: 10%;
      font-size: 20px;
      font-weight: bold;
      color: white;
      top: 20%;
      right: 10%;
    }
    </style>
@endsection
@section('body-content')

  <img class="logo" src="{{url('/images/newTheme/logo.png')}}" alt="">

              <!-- category box started -->
              <div class='category-box px-2 py-2 collapse' >
                      <div class="category-items-box" >


                      @foreach($restaurant->categories as $category)

                          @foreach(explode('---', $category->name ) as $index => $info)
                          @if($info == $lang)


                          @foreach(explode('---', $category->name ) as $index => $info)
                           @if($index == 0)

                           <label id="{{$category->id}}" > <b>{{$info}} </b>  </label>

                           @endif

                          @endforeach
                        @endif
                       @endforeach
                       @endforeach
                      </div>
                </div>
            <!-- category box ended -->

  <div class="container text-center">

  @foreach($restaurant->categories as $category)

  @foreach(explode('---', $category->name ) as $index => $info)
                      @if($info == $lang)


                      @foreach(explode('---', $category->name ) as $index => $info)
                                      @if($index == 0)
                                          <h2 id="box{{$category->id}}" style="max-width:inherit;overflow:hidden" class="category-header bg-white text-center ">
                                              {{$info}}
                                          </h2>
                                      @endif
                    @endforeach
                    @foreach($category->items as $item)
                    @if($item->is_visible)
                    <div>
                        <div class="product-item col-lg-6 col-sm-12 offset-lg-3 ">
                          <div style="position: relative;">
                            <img class="icon" src="{{url('/images/newTheme/icon.png')}}" alt="">
                            <b class="icon-value">100</b>
                          </div>
                          <label class="price">
                            Price
                          </label>
                          <label class="title">
                            Title Title Title Title
                          </label>
                        </div>

                        <img id="1" class="item-image" src="{{url('/images/newTheme/f1.png')}}" alt="">

                        <br>
                        <br>
                        <br>

                      </div>
                    </div>
                    @endif

    @endforeach

    @if(!count($category->items))
        <p>ﻻ توجد منتجات حالياً</p>
    @endif

    @endif
    @endforeach
    @endforeach
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
@section('body-scripts')

<script src="{{asset('js/menu.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

<script>
        function expandTitle(event) {
            $(event.target).removeClass('extensable').removeClass('cursor-pointer').closest('div.item-wrapper').first().addClass('expanded scrollable-hidden-bar');
        }
    </script>
    @include('layouts.image-viewer')


<script>
  $.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop + 200 && elementTop + 200 < viewportBottom;
  };

  $(window).on('resize scroll', function() {
    $('.item-image').each(function() {

      if ($(this).isInViewport()) {

        var id = $(this).find('.item-image').attr('id');
        $(this).addClass('animatation-show');
        $(this).siblings('.product-item').addClass('animatation-show');

      } else {
        $(this).addClass('animatation-hide');
      }
    });
  });
</script>
@endsection
