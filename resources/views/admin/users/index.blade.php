@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <div class="d-flex mt-4 mb-4">
            <h2>قائمة المستخدمين</h2>
        </div>
            <div class="d-flex my-2 justify-content-space-between" >
            <input id="searchInput" type="text" placeholder="Search..">
            <button class="btn btn-outline-primary" onclick="window.location = '{{route('create-user')}}'">
                اضافة متجر
                <i class="fas fa-plus"></i>
            </button>    
        </div>
        <div>
            @include('layouts.messages')
            <table class="table table-bordered table-responsive table-striped full-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المستخدم</th>
                    <th>الايميل</th>
                    <th>هو الادارية</th>
                    <th>الصلاحيات</th>
                    <th>المتجر الملحق به</th>
                    <th>تاريخ الانشاء</th>
                    <th></th>
                </tr>
                </thead>
                @if(count($users))
                    <tbody id="users" >
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    @if($role->id == 1)
                                        <i class="fa fa-check text-success"  ></i>
                                    @else 
                                        <i class="fa fa-times text-danger" ></i>    
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$user->roles->first()?$user->roles->first()->display_name: 'ﻻ يوجد'}}</td>
                            <td>
                                @if($user->restaurant && !$user->restaurant->is_deleted)
                                    <a href="/restaurants/{{$user->restaurant->subdomain}}">{{$user->restaurant->name}}</a> {{$user->restaurant->is_deleted? '(محذوف)' : ''}}
                                @elseif($user->restaurant && $user->restaurant->is_deleted)
                                    {{$user->restaurant->name}} (محذوف)
                                @else
                                    ﻻ يوجد
                                @endif
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <a href="{{route('show-user', $user->id)}}"><i class="fas fa-eye"></i></a>
                                <a href="{{route('edit-user', $user->id)}}"><i class="fas fa-pencil-alt text-secondary"></i></a>
{{--                                <form action="{{route('delete-user',$user->id)}}" method="POST">--}}
{{--                                    @method('delete')--}}
{{--                                    @csrf()--}}
{{--                                    <a href="#" onclick="confirmDeletion(event)"><i class="fas fa-trash text-danger"></i></a>--}}
{{--                                </form>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tr>
                        <td colspan="8">ﻻ يوجد مستخدمين</td>
                    </tr>
                @endif

            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{$users->render()}}
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#users tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
{{--@section('body-scripts')--}}
{{--    <script>--}}
{{--        function confirmDeletion(event) {--}}
{{--            if(confirm('هل تريد حذف المستخدم؟')){--}}
{{--                $(event.target).closest('form').submit();--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
