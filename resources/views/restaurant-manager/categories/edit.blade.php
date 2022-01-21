@extends('layouts.restaurant-manager-dashboard')

@section('content')
    <div class="container">
        <div class="mt-4">
            <h2>تعديل الصنف</h2>
        </div>
        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')
            <form action="{{route('update-category', ['subdomain'=> request()->route('subdomain'),'id' => $category->id])}}" method="POST"
                  enctype="multipart/form-data">
                {{csrf_field()}}
                @method('patch')

<div class="form-group">

                    <div>  <input type="radio" name="language" id="eng" value="eng" > <label> English </label>  </div>
                    <div>  <input type="radio" name="language" id="arb" value="arb" checked> <label> Arabic </label>  </div>


</div>

                <div class="form-group">
                    <label for="name">اسم الصنف</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم الصنف"
                           value="{{explode('---',$category->name)[0]}}"
                           required>
                </div>

                <div class="form-group">
                    <label for="image">ادخل صورة للصنف (او اترك القديمة)</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
                <div class="form-group mt-4 mb-4">
                    <button class="btn btn-outline-primary btn-block">
                        تعديل صنف
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
