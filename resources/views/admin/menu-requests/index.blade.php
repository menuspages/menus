@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-4 mb-4">
            <h2>طلبات المنيو</h2>
        </div>

        <div>
            @include('layouts.messages')
            <table class="table table-responsive w-100 d-block d-md-table table-bordered table-striped"
                   id="users-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>رقم هاتف العميل</th>
                    <th>الايميل</th>
                    <th>اسم المتجر</th>
                    <th>اسم النطاق</th>
                    <th>كود الخصم</th>
                    <th>وقت الطلب</th>
                    <th>التفاصيل</th>
                </tr>
                </thead>
                @if(count($menuRequests))
                    <tbody>
                    @foreach($menuRequests as $menuRequest)
                        <tr>
                            <td>
                                {{$menuRequest->id}}
                                @if($menuRequest->status === \App\Constants\MenuRequestStatus::NEW)
                                    <img src="{{asset('images/new.ico')}}" alt="new" class="order-flag">
                                @elseif($menuRequest->status === \App\Constants\MenuRequestStatus::SEEN)
                                    <img src="{{asset('images/seen.ico')}}" alt="seen" class="order-flag">
                                @endif
                            </td>
                            <td>{{$menuRequest->full_name}}</td>
                            <td>
                                {{$menuRequest->phone}}
                                @php
                                    $whatsappLink = is_mobile()? "whatsapp://send?phone=$menuRequest->phone" : "https://web.whatsapp.com/send?phone=$menuRequest->phone";
                                @endphp
                                <a target="_blank" href="{{$whatsappLink}}"
                                   class="mr-1"><i
                                        class="fab fs-12 fa-whatsapp whatsapp"></i>
                                </a>
                            </td>
                            <td>{{$menuRequest->email}}</td>
                            <td>{{$menuRequest->restaurant_name}}</td>
                            <td>{{$menuRequest->subdomain}}</td>
                            <td>{{$menuRequest->discount_code}}</td>
                            <td>{{$menuRequest->created_at->format('Y-m-d h:i A')}}</td>
                            <td>
                                <a href="{{route('menu-requests-details', $menuRequest->id)}}"
                                   class="btn btn-outline-info">التفاصيل</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tr>
                        <td colspan="9">ﻻ يوجد طلبات</td>
                    </tr>
                @endif

            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{$menuRequests->render()}}
        </div>
    </div>

@endsection
@section('body-scripts')
    <script>
        setTimeout(function () {
            window.location.reload();
        }, 10000)
    </script>
@endsection
