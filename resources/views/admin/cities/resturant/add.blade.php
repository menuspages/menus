@extends('layouts.admin-dashboard')
@section('content')
<div class="container" >


<div class="col-lg-6 col-sm-12 col-md-12 jumbotron" >


            <form method="post" action ="/city-restaurants/add-city-restaurants-post" enctype="multipart/form-data"  >

            {{csrf_field()}}

                      <input type="hidden" name="id" value = "{{$restaurant->id}}"  >  

                      <input type="text" name="name" value = "{{$restaurant->name}}" class="form-control my-4" placeholder = "أدخل الاسم" >
                      @if($errors->has('name'))
                            <div class="alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                    
                        <input type="text" name="description" value = "{{$restaurant->description}}" class="form-control my-4" placeholder = "أدخل الوصف" >
                      @if($errors->has('description'))
                            <div class="alert-danger">{{ $errors->first('description') }}</div>
                        @endif
                        <input type="text" name="menu_link" value = "{{$restaurant->menu_link}}" class="form-control my-4" placeholder = "أدخل رابط القائمة" >
                      @if($errors->has('menu_link'))
                            <div class="alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                        <input type="text" name="map_link" value = "{{$restaurant->map_link}}" class="form-control my-4" placeholder = "أدخل رابط الخريطة" >
                      @if($errors->has('map_link'))
                            <div class="alert-danger">{{ $errors->first('map_link') }}</div>
                        @endif
                        <input type="text" name="phone" value = "{{$restaurant->phone}}" class="form-control my-4" placeholder = "أدخل الهاتف" >
                      @if($errors->has('phone'))
                            <div class="alert-danger">{{ $errors->first('phone') }}</div>
                        @endif

                        <label class="form-control my-4"  for="image">
                             Select image ..   
                            <input type="file" id="image" name="image"  style="display:none" class="form-control my-4" >
                        </label>    
                      @if($errors->has('image'))
                            <div class="alert-danger">{{ $errors->first('image') }}</div>
                        @endif

                        @if($restaurant->id > 0)         
                            <img id="image_preview" src="data:image/png;base64,{{$restaurant->image}}" width="300" height="300" />       
                        @else
                             <img id="image_preview" src="data:image/png;base64,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" width="300" height="300" />      
                        @endif
                     <div>
                     <input type="submit" value="Save" class="btn-primary btn my-4" >
                     </div>
            </form>

</div>



</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>

    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#image_preview").attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#image").change(function(){
    readURL(this);
});

</script>

@endsection
