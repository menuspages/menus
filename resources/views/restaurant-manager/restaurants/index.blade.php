@extends('layouts.restaurant-manager-dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-4 mb-4">
            <h2>تفاصيل المتجر</h2>
            <button class="btn btn-sm btn-outline-secondary mr-3"
                    onclick="window.location = '{{route('manager-edit-restaurant', $restaurant->subdomain)}}'">
                تعديل
                <i class="fas fa-pencil-alt"></i>
            </button>
        </div>
        <div class="col-lg-6 col-md-12">
            <dl class="row">
                <dt class="col-sm-5 mt-2">اسم المتجر</dt>
                <dd class="col-sm-7 mt-2">{{$restaurant->name}}</dd>

                <dt class="col-sm-5 mt-2">وصف المتجر</dt>
                <dd class="col-sm-7 mt-2">{{$restaurant->description}}</dd>

                <dt class="col-sm-5 mt-2">لوجو المتجر</dt>
                <dd class="col-sm-7 mt-2">
                    <img loading="lazy" src="{{$restaurant->logoUrl()}}" alt="{{$restaurant->name}}" class="details-image"
                         aria-view="true">
                </dd>

                @if($restaurant->background_image_path)
                    <dt class="col-sm-5 mt-2 collapse">صورة خلفية المتجر</dt>
                    <dd class="col-sm-7 mt-2 collapse">
                        <img loading="lazy" src="{{$restaurant->backgroundImageUrl()}}" alt="{{$restaurant->name}}"
                             class="details-image"
                             aria-view="true">
                    </dd>
                @endif

                <dt class="col-sm-5 mt-2">النطاق</dt>
                <dd class="col-sm-7 mt-2">{{$restaurant->subdomain}}</dd>

                <dt class="col-sm-5 mt-2">متاح له الطلب</dt>
                <dd class="col-sm-7 mt-2">
                    @if($restaurant->is_order)
                        <i class="fas fa-check"></i>
                    @endif
                    @if(!$restaurant->is_order)
                        منيو فقط
                    @endif
                </dd>

                <dt class="col-sm-5 mt-2">يعمل</dt>
                <dd class="col-sm-7 mt-2">
                    @if($restaurant->is_active)
                        <i class="fas fa-check"></i>
                    @endif
                    @if(!$restaurant->is_active)
                        <i class="fas fa-times"></i>
                    @endif
                </dd>

                <dt class="col-sm-5 mt-2 text-truncate">الشكل الحالي</dt>
                <dd class="col-sm-7 mt-2">{{$restaurant->current_theme}}</dd>

                @if($restaurant->open_from)
                    <dt class="col-sm-5 mt-2 text-truncate">يفتح من الساعة</dt>
                    <dd class="col-sm-7 mt-2">{{$restaurant->open_from}}</dd>
                @endif
                @if($restaurant->open_to)
                    <dt class="col-sm-5 mt-2 text-truncate">يغلق الساعة</dt>
                    <dd class="col-sm-7 mt-2">{{$restaurant->open_to}}</dd>
                @endif
                @if($restaurant->phone)
                    <dt class="col-sm-5 mt-2 text-truncate">رقم الهاتف</dt>
                    <dd class="col-sm-7 mt-2">{{$restaurant->phone}}</dd>
                @endif
                @if($restaurant->whatsapp_number)
                    <dt class="col-sm-5 mt-2 text-truncate">رقم الواتساب</dt>
                    <dd class="col-sm-7 mt-2">{{$restaurant->whatsapp_number}}</dd>
                @endif
                @if($restaurant->google_map_location_link)
                    <dt class="col-sm-5 mt-2 text-truncate" style="line-height: 3">العنوان</dt>
                    <dd class="col-sm-7 mt-2"><a href="{{$restaurant->google_map_location_link}}"><i
                                class="fas fa-2x fa-map-marked-alt"></i></a></dd>
                @endif
                @if($restaurant->facebook_link)
                    <dt class="col-sm-5 mt-2 text-truncate" style="line-height: 3">فيسبوك</dt>
                    <dd class="col-sm-7 mt-2"><a href="{{$restaurant->facebook_link}}"><i
                                class="fab fa-2x fa-facebook"></i></a></dd>
                @endif
                @if($restaurant->twitter_link)
                    <dt class="col-sm-5 mt-2 text-truncate" style="line-height: 3">تويتر</dt>
                    <dd class="col-sm-7 mt-2"><a href="{{$restaurant->twitter_link}}"><i
                                class="fab fa-2x fa-twitter"></i></a></dd>
                @endif

                @if($restaurant->instagram_link)
                    <dt class="col-sm-5 mt-2 text-truncate" style="line-height: 3">انستجرام</dt>
                    <dd class="col-sm-7 mt-2"><a href="{{$restaurant->instagram_link}}"><i
                                class="fab fa-2x fa-instagram"></i></a></dd>
                @endif
                @if($restaurant->snapchat_link)
                    <dt class="col-sm-5 mt-2 text-truncate" style="line-height: 3">سنابشات</dt>
                    <dd class="col-sm-7 mt-2"><a href="{{$restaurant->snapchat_link}}"><i
                                class="fab fa-2x fa-snapchat"></i></a></dd>
                @endif

            </dl>
        </div>

    </div>
@endsection
@section('body-scripts')
    @include('layouts.image-viewer')
@endsection
