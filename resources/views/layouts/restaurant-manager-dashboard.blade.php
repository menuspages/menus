@extends('layouts.app')

@section('body-content')
    @include('layouts.restaurant-manager-nav-bar')
    @yield('content')
@endsection
@yield('head-scripts')
<script src="{{asset('js/real_time_order_listner.js')}}"></script>
