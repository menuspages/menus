<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <img src="{{asset('images/website_fixed_logo.jpg')}}" alt="logo" width="50px" height="50px">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
        
        <li style="display:none" class="nav-item {{(strpos(url()->current(), 'city-restaurants') === false)? '': 'active'}}">
                <a class="nav-link" href="/city-restaurants">مطاعم</a>
        </li>

        
        <li style="display:none" class="nav-item {{(strpos(url()->current(), 'category') === false)? '': 'active'}}">
                <a class="nav-link" href="/category">الفئة</a>
        </li>

        <li style="display:none" class="nav-item {{(strpos(url()->current(), 'cities') === false)? '': 'active'}}">
                <a class="nav-link" href="/cities">مدن</a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'restaurants') === false)? '': 'active'}}">
                <a class="nav-link" href="/restaurants">المتاجر</a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'menu-requests') === false)? '': 'active'}}">
                <a class="nav-link" href="/menu-requests">
                    طلبات المنيو
                    @if(isset($newMenuRequests) && $newMenuRequests)
                        <span class="badge badge-danger ">{{$newMenuRequests}}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'users') === false)? '': 'active'}}">
                <a class="nav-link" href="/users">المستخدمين</a>
            </li>
        </ul>
        <li class="navbar-nav nav-item dropdown nav-link" style="list-style: none">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                {{auth()->user()?auth()->user()->name: ''}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item cursor-pointer" onclick="$('#logout-form').submit()">تسجيل خروج</a>
            </div>
        </li>
    </div>
</nav>
<form action="/logout" method="POST" id="logout-form">
    {{csrf_field()}}
</form>
