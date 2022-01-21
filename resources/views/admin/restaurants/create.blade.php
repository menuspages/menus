@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <div class="mt-4">
            <h2>انشاء متجر</h2>
        </div>
        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')
            <form action="{{route('store-restaurant')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">اسم المتجر</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم المتجر" required>
                </div>

                <div class="form-group">
                    <label for="description">وصف المتجر</label>
                    <textarea
                        name="description"
                        class="form-control"
                        id="description"
                        cols="30"
                        rows="3"
                        placeholder="ادخل وصف المتجر"></textarea>
                </div>

                <div class="form-group">
                    <label for="subdomain">نطاق المتجر</label>
                    <input type="text" name="subdomain" id="subdomain" class="form-control" placeholder="ادخل الاسم الذي يسبق العنوان في الرابط" required>
                </div>

                <div class="form-group">
                    <label for="logo">لوجو المتجر</label>
                    <input type="file" name="logo" id="logo" class="form-control-file" required>
                </div>

                <fieldset>
                    <legend>بيانات مدير المتجر (المستخدم الاساسي)</legend>
                    <div class="form-group">
                        <label for="username">اسم المستخدم</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="ادخل اسم المستخدم" required>
                    </div>

                   <div class="form-group">
                        <label for="email">الايميل</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="ادخل ايميل المستخدم" required>
                    </div>

                    <div class="form-group">
                        <label for="password">كلمة المرور</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="ادخل كلمة السر" required>
                    </div>
                </fieldset>

                <div class="form-group">
                    <label for="is_order">نوع المتجر</label>
                    <select name="enable_component" id="is_order" class="form-control">
                        <option value="0">منيو فقط</option>
                        <option value="1">انشاء طلبات</option>
                        <option value="2">القائمة مع إضافة إلى عربة التسوق</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="is_order">تصنيف المتجر</label>
                    <select name="evaluation_enabled" id="evaluation_enabled" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                
                <fieldset>
                    <legend>الاشكال المتاحة</legend>
                    @foreach(\App\Constants\Themes::AVAILABLE_THEMES_LABELS as $value => $label)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="available_themes[]" value="{{$value}}">
                            <label class="form-check-label" for="available_themes[]">{{$label}}</label>
                        </div>
                    @endforeach
                </fieldset>

                <div class="form-group mt-4 mb-4">
                    <button class="btn btn-outline-primary btn-block">
                        اضافة متجر
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
