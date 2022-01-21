<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body  >
  <img src="{{url('/images/logo.jpg')}}" class="logo" alt="">
  <!-- style="background-image:url(' {{url('/images/cities_background.jpg')}}')" -->
                <div class="col-lg-12  text-center col-md-12 offset-sm-1 col-sm-10" style="position: relative;" >
               
                <label class="title" for="">اختر المدينة وتصفح العديد من المطاعم والمقاهي المميزة في كل مدينة</label>
                </div>
                <div class="container" style="margin-top: 100px;" >

                            <div class="row" >

                            @foreach($cities as $city)

                                    
                                    <div class="col-lg-4 px-2 py-2 col-md-12 col-sm-6" style="padding:0px;display:flex;justify-content:center" >
                                    <div class="item  col-lg-12 col-md-12 col-sm-12" style="justify-content: center;text-align: center;display:normal"  >
                                        <img src="data:image/png;base64,{{$city->image}}"  class="card-img-top" style="height: 100%;width: 100%;" >
                                        <br>
                                        <div>
                                        <label class="card-title" style="overflow-wrap: anywhere;font-size: 30px;" >{{$city->name}}</label>
                                        </div>

                                     </div>
                                                                            
                                    </div>
                                    <br>
                            @endforeach  

                            </div>

                </div>
  </body>
</html>

<style>

.logo 
{
  float: right;
    width: 80px;
    height: 80px;
    margin: 10px;
}
.title 
{
    
    font-size: 40px;
    color: black;
    font-family : 'El Messiri', sans-serif;
    padding: 20px;
    border: 3px solid #b5b5b5!important;
    border-radius: 30px;
   
}
.item label 
{
    position: absolute;
    overflow-wrap: anywhere;
    font-size: 30px;
    z-index: 5;
    width: 100%;
    left: 0%;
    color: white;
    font-weight: 900;
    font-size: 45px;
    bottom: 0%;
    padding: 15px;
    text-align: right;
}
.item 
{
    background-color:white;
    position: relative;
}

</style>