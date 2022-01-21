@extends('layouts.admin-dashboard')
@section('content')
<div class="container" >

<div class="col-lg-6 col-sm-12 col-md-12 jumbotron" >


            <form method="post" action ="/category/add-category-post" enctype="multipart/form-data"  >

            {{csrf_field()}}

                      <input type="hidden" name="id" value = "{{$category->id}}"  >  
                      <input type="text" name="name" value = "{{$category->name}}" class="form-control my-4" placeholder = "فئة النوع" >
                      @if($errors->has('name'))
                            <div class="alert-danger">{{ $errors->first('name') }}</div>
                        @endif
                    
                      <input type="submit" value="Save" class="btn-primary btn my-4" >
            </form>

</div>



</div>
@endsection
