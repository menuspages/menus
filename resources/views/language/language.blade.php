@extends('layouts.app')

@section('head-scripts')
    <link rel="stylesheet" href="{{asset('css/theme-1.css'). '?_=' . config('app.version_date')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
    @include('layouts.main-color-style', ['color' => $restaurant->main_theme_color_code??'#3e3e3e'])
    <style>
        #restaurant-header:before {
            content: "";
            background: url("{{$restaurant->background_image_path? $restaurant->backgroundImageUrl(): asset('images/default-background-image.png')}}") no-repeat;
            background-size: cover;
            opacity: 0.5;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
        }
    </style>
@endsection








<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>{{$restaurant->name}}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>


<style>
    a , a label
    {
        text-decoration: none !important;
        cursor: pointer !important;
        margin: 5px;
    }


</style>



    </head>
    <body class="bg-white" >


<br>
<br>
<br>


        <div class="container bg-white" style="padding:0px" >


	    <h4 class="text-center py-4" >

		      <b>   	{{$restaurant->name}}   </b>

	    </h4>


            <div class="col-lg-4 offset-lg-4 text-center col-md-12 col-sm-12 bg-white" >



            <div class=" text-center col-lg-12  col-md-12 col-sm-12" >


	           <img loading="lazy" data-src="{{$restaurant->logoUrl()}}" alt="{{$restaurant->name}}" aria-view="true" class="my-4" width="100" height="100" style="border:solid 1px black;border-radius: 120px" >

            </div>



		<div class=" text-center col-lg-12 col-md-12 col-sm-12 my-4" >
                {{$restaurant->description}}
            </div>


            <div class=" text-center col-lg-12 col-md-12 col-sm-12" >

                <a class="my-4" href="{{$url}}?lang=arb" style="font-weight: 600;border:solid 2px #c1b1a2;padding: 5px 20px 5px 20px;border-radius:10px">
                     عربي
                </a>


                <a class="my-4" href="{{$url}}?lang=eng" style="font-weight: 600;border:solid 2px #c1b1a2;padding: 5px 20px 5px 20px;border-radius:10px">
                    English
                </a>

            </div>


<br>
<br>


               </div>




<div class="card" style="margin-left:0px !important;width:100%;text-align:center !important;margin-top:20px" >

<div style="display:inline-block" >
		<div class=" d-flex justify-content-center m-2" id="social-part">
                    @include('layouts.menu-partials.social')
                </div>


			</div>


</div>

        </div>











    </body>
</html>





