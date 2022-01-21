@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <div class="mt-4">
            <h2>تعديل المستخدم</h2>
        </div>
        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')
            <form action="{{route('update-user', $user->id)}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">اسم المستخدم</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم المستخدم" required value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="email">ايميل المستخدم</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="ادخل ايميل المستخدم" required value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="ادخل كلمة المرور" required>
                </div>
                <div class="form-group">
                        <select class="form-control" name="role" id="">
                            <option value="1" {{$user->roles[0]->pivot->role_id == 1? 'selected="selected"': ''}}>admin</option>
                            <option value="2" {{$user->roles[0]->pivot->role_id == 2? 'selected="selected"': ''}}>rastaurant manager</option>
                            
                        </select>
                </div>
                <div class="form-group mt-4 mb-4">
                    <button class="btn btn-outline-primary btn-block">
                        تعديل المستخدم
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
