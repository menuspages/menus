@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-4">
            <h2>تفاصيل المستخدم</h2>
            <div class="d-flex">
                <button class="btn btn-sm btn-outline-secondary mr-3" onclick="window.location = '{{route('edit-user', $user->id)}}'">
                    تعديل
                    <i class="fas fa-pencil-alt"></i>
                </button>
{{--                <button onclick="confirmDeletion(event)" class="btn btn-sm btn-outline-danger">--}}
{{--                    حذف--}}
{{--                    <i class="fas fa-trash"></i>--}}
{{--                </button>--}}
{{--                <form action="{{route('delete-user',$user->id)}}" method="POST" id="delete-form">--}}
{{--                    @method('delete')--}}
{{--                    @csrf()--}}
{{--                </form>--}}
            </div>
        </div>
        <hr>
        <div class="col-lg-6 col-md-12">
            <dl class="row">
                <dt class="col-sm-5 mt-2">اسم المستخدم</dt>
                <dd class="col-sm-7 mt-2">{{$user->name}}</dd>

                <dt class="col-sm-5 mt-2">ايميل المستخدم</dt>
                <dd class="col-sm-7 mt-2">{{$user->email}}</dd>

                <dt class="col-sm-5 mt-2">المتجر التابع له</dt>
                <dd class="col-sm-7 mt-2">
                    @if($user->restaurant)
                        <a href="{{route('show-restaurant', $user->restaurant->subdomain)}}">{{$user->restaurant->name}}</a>
                    @else
                        ﻻ يوجد
                    @endif
                </dd>

                <dt class="col-sm-5 mt-2 text-truncate">تاريخ الانشاء</dt>
                <dd class="col-sm-7 mt-2">{{$user->created_at}}</dd>
            </dl>
        </div>
    </div>
@endsection
{{--@section('body-scripts')--}}
{{--    <script>--}}
{{--        function confirmDeletion(event) {--}}
{{--            if(confirm('هل تريد حذف المستخدم؟')){--}}
{{--                $(event.target).closest('form').submit();--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
