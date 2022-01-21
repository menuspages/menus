@extends('layouts.admin-dashboard')

@section('head-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex mt-4 mb-4">
            <h2>تفاصيل الطلب</h2>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <dl class="row">
                    <dt class="col-sm-5 mt-2">اسم العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$menuRequest->full_name}}</dd>

                    <dt class="col-sm-5 mt-2">رقم هاتف العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$menuRequest->phone}}</dd>

                    <dt class="col-sm-5 mt-2">ايميل العميل</dt>
                    <dd class="col-sm-7 mt-2">{{$menuRequest->email}}</dd>

                    <dt class="col-sm-5 mt-2">اسم المتجر المراد</dt>
                    <dd class="col-sm-7 mt-2">{{$menuRequest->restaurant_name}}</dd>

                    <dt class="col-sm-5 mt-2">اسم النطاق المراد</dt>
                    <dd class="col-sm-7 mt-2">{{$menuRequest->subdomain}}</dd>

                    <dt class="col-sm-5 mt-2">كود الخصم</dt>
                    <dd class="col-sm-7 mt-2">{{$menuRequest->discount_code}}</dd>

                    <dt class="col-sm-5 mt-2">تم الانشاء</dt>
                    <dd class="col-sm-7 mt-2">{{$menuRequest->created_at->format('Y-m-d h:i A')}}</dd>

                    @if($menuRequest->updated_at > $menuRequest->created_at)
                        <dt class="col-sm-5 mt-2">تم الاطلاع علي الطلب</dt>
                        <dd class="col-sm-7 mt-2">{{$menuRequest->updated_at->format('Y-m-d h:i A')}}</dd>
                    @endif

                    @if($menuRequest->admin_notes)
                        <dt class="col-sm-5 mt-2">ملاحظات الادمن</dt>
                        <dd class="col-sm-7 mt-2">{{$menuRequest->admin_notes}}</dd>
                    @endif
                </dl>
            </div>
            <div class="col-lg-6 col-md-12">
                <form
                    action="{{route('menu-requests-add-note', $menuRequest->id)}}"
                    method="POST">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="admin_notes">ملاحظات الادمن</label>
                        <textarea name="admin_notes" class="form-control" id="admin_notes" cols="20"
                                  rows="5"></textarea>
                    </div>
                    <input type="submit" class="btn btn-outline-success" value="انهاء الطلب">
                </form>
            </div>
        </div>
        @include('layouts.image-viewer')
    </div>
@endsection
@if($menuRequest->status === \App\Constants\MenuRequestStatus::NEW)
@section('body-scripts')
    <script>
        axios.patch('{{route('menu-requests-see', $menuRequest->id)}}');
    </script>
@endsection
@endif
