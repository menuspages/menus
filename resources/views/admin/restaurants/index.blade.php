@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-4 mb-4">
            <h2>قائمة المتاجر</h2>
            <button class="btn btn-outline-primary" onclick="window.location = '{{route('create-restaurant')}}'">
                اضافة متجر
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <div>
            <table class="table table-bordered table-responsive table-striped full-table">
                <tr>
                    <th>#</th>
                    <th>اسم المتجر</th>
                    <th>وصف المتجر</th>
                    <th>صورة الخلفية</th>
                    <th>النطاق</th>
                    <th>مدير المتجر</th>
                    <th>متاح له الطلب</th>
                    <th>يعمل</th>
                    <th>تاريخ الانشاء</th>
                    <th></th>
                </tr>
                @if(count($restaurants))
                    @foreach($restaurants as $index => $restaurant)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$restaurant->name}}</td>
                            <td>{{$restaurant->description}}</td>
                            <td><img loading="lazy" src="{{$restaurant->logoUrl()}}" alt="{{$restaurant->name}}" width="50px"
                                     height="50px"
                                     aria-view="true">
                            </td>
                            <td><a href="{{App\Helpers\UrlHelper::constructRestaurantUrl($restaurant->subdomain)}}" target="_blank">{{$restaurant->subdomain}}</a></td>
                            @if(isset($restaurant->manager))
                                <td><a href="/users/{{$restaurant->manager->id}}">{{ $restaurant->manager->name}}</a>
                                </td>
                            @else
                                <td>ﻻ يوجد</td>
                            @endif
                            <td class="{{$restaurant->is_order? 'bg-success': 'bg-danger'}} align-middle text-center">
                                @if($restaurant->is_order)
                                    <i class="fas fa-check"></i>
                                @endif
                                @if(!$restaurant->is_order)
                                    منيو فقط
                                @endif
                            </td>
                            <td class="{{$restaurant->is_active? 'bg-success': 'bg-danger'}} align-middle text-center">
                                @if($restaurant->is_active)
                                    <i class="fas fa-check"></i>
                                @endif
                                @if(!$restaurant->is_active)
                                    <i class="fas fa-times"></i>
                                @endif
                            </td>
                            <td>{{$restaurant->created_at}}</td>
                            <td>
                                <a href="{{route('show-restaurant', $restaurant->subdomain)}}"><i
                                        class="fas fa-eye"></i></a>
                                <a href="{{route('edit-restaurant', $restaurant->subdomain)}}"><i
                                        class="fas fa-pencil-alt text-secondary"></i></a>
                                <form action="{{route('delete-restaurant',$restaurant->subdomain)}}" method="POST">
                                    @method('delete')
                                    @csrf()
                                    <a href="#" onclick="confirmDeletion(event)"><i
                                            class="fas fa-trash text-danger"></i></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">ﻻ يوجد متاجر</td>
                    </tr>
                @endif
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{$restaurants->render()}}
        </div>
    </div>
@endsection

@section('body-scripts')
    @include('layouts.image-viewer')
    <script>
        function confirmDeletion(event) {
            if (confirm('هل تريد حذف المتجر؟')) {
                $(event.target).closest('form').submit();
            }
        }
    </script>
@endsection
