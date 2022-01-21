<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <img src="{{asset('images/website_fixed_logo.jpg')}}" alt="logo" width="120px" height="50px">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{(strpos(url()->current(), 'dashboard') === false || strpos(url()->current(), '/dashboard/') !== false)? '': 'active'}}">
                <a class="nav-link" href="/dashboard">المتجر</a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'categories') === false)? '': 'active'}}">
                <a class="nav-link" href="/dashboard/categories">الأصناف</a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'items') === false)? '': 'active'}}">
                <a class="nav-link" href="/dashboard/items">المنتجات</a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'qrcode') === false)? '': 'active'}}">
                <a class="nav-link" href="/dashboard/qrcode">QR-Code</a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'rating') === false)? '': 'active'}}">
                <a class="nav-link" href="/dashboard/rating">تقييم المتجر</a>
            </li>
            <li class="nav-item {{(strpos(url()->current(), 'links') === false)? '': 'active'}}">
                <a class="nav-link" href="/dashboard/links">{{\App\Constants\Translation::getTranslationByWord('arb' , 'links')}}</a>
            </li>
            
            @if(auth()->user() && auth()->user()->restaurant->enable_component == 1 )
            <li class="nav-item {{(strpos(url()->current(), 'orders') === false)? '': 'active'}}">
                <a class="nav-link" href="/dashboard/orders">
                    الطلبات
                    @if(auth()->user()->restaurant->newOrdersCount())
                    <span class="badge badge-danger ">{{auth()->user()->restaurant->newOrdersCount()}}</span>
                    @endif
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="/">المنيو</a>
            </li>
          
        </ul>
        <li class="navbar-nav nav-item dropdown nav-link" style="list-style: none">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
