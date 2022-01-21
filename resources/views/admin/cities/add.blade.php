@extends('layouts.admin-dashboard')
@section('content')
<div class="container" >

<div class="col-lg-6 col-sm-12 col-md-12 jumbotron" >


            <form method="post" action ="/cities/add-cities-post" enctype="multipart/form-data"  >

            {{csrf_field()}}

                      <input type="hidden" name="id" value = "{{$city->id}}"  >  
                      <input type="text" name="name" value = "{{$city->name}}" class="form-control my-4" placeholder = "اكتب اسم المدينة" >
                      @if($errors->has('name'))
                            <div class="alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                      <label for="image" class="form-control my-4" > اختر صورة <input style="display:none" id="image" type="file" name="image"  > </label>      
                      @if($errors->has('image'))
                            <div class="alert-danger">{{ $errors->first('image') }}</div>
                        @endif 
                      <input type="submit" value="Save" class="btn-primary btn my-4" >
            </form>

</div>



</div>
@endsection
