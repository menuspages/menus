@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <div class="mt-4">
            <h2>تعديل متجر</h2>
        </div>
        <div class="col-lg-6 col-md-12">
            @include('layouts.messages')
            <form action="{{route('update-restaurant',$restaurant->subdomain)}}" method="POST"
                  enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">اسم المتجر</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم المتجر" required
                           value="{{$restaurant->name}}">
                </div>

                <div class="form-group">
                    <label for="description">وصف المتجر</label>
                    <textarea
                        name="description"
                        class="form-control"
                        id="description"
                        cols="30"
                        rows="3"
                        placeholder="ادخل وصف المتجر">{{$restaurant->description}}</textarea>
                </div>

                <div class="form-group">
                    <label for="subdomain">نطاق المتجر</label>
                    <input type="text" name="subdomain" id="subdomain" class="form-control"
                           placeholder="ادخل الاسم الذي يسبق العنوان في الرابط" required
                           value="{{$restaurant->subdomain}}">
                </div>

                <div class="form-group">
                    <label for="logo">لوجو المتجر (ارفع صورة جديدة او اترك القديمة)</label>
                    <input type="file" name="logo" id="logo" class="form-control-file">
                </div>

                <div class="form-group">
                    <label for="is_order">نوع المتجر</label>
                    <select name="enable_component" id="enable_component" class="form-control">
                        <option value="0" {{$restaurant->enable_component == 0? 'selected="selected"': ''}}>منيو فقط</option>
                        <option value="1" {{$restaurant->enable_component == 1? 'selected="selected"': ''}}>انشاء طلبات</option>
                        <option value="2" {{$restaurant->enable_component == 2? 'selected="selected"': ''}} >القائمة مع إضافة إلى عربة التسوق</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="is_order">تصنيف المتجر</label>
                    <select name="evaluation_enabled" id="evaluation_enabled" class="form-control">
                        <option value="1" {{$restaurant->evaluation_enabled == 1? 'selected="selected"': ''}} >Yes</option>
                        <option value="0" {{$restaurant->evaluation_enabled == 0? 'selected="selected"': ''}}>No</option>
                    </select>
                </div>

                <fieldset>
                    <legend>الاشكال المتاحة</legend>
                    @php
                        $availableThemes = json_decode($restaurant->available_themes, true);
                    @endphp
                    @foreach(\App\Constants\Themes::AVAILABLE_THEMES_LABELS as $value => $label)
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="available_themes[]"
                                {{in_array($value, $availableThemes)? 'checked': ''}}
                                value="{{$value}}">
                            <label class="form-check-label" for="available_themes[]">{{$label}}</label>
                        </div>
                    @endforeach
                </fieldset>

                <div class="form-group">
                    <label for="is_active">يعمل</label>
                    <select name="is_active" id="is_active" class="custom-select">
                        <option value="1" {{$restaurant->is_active? 'selected="selected"': ''}}>يعمل</option>
                        <option value="0" {{$restaurant->is_active? '': 'selected="selected"'}}>لا يعمل</option>
                    </select>
                </div>
                <div class="form-group mt-4 mb-4">
                    <button class="btn btn-outline-primary btn-block">
                        تعديل متجر
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
