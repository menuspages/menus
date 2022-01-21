<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>قائمة الطلبات</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ isset($favIcon)? $favIcon : asset('images/daleelh-logo-1.jpg') }}">
    <!--CSS RTL Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.rtl.min.css" integrity="sha384-mUkCBeyHPdg0tqB6JDd+65Gpw5h/l8DKcCTV2D2UpaMMFd7Jo8A+mDAosaWgFBPl" crossorigin="anonymous">
    <!-- El Messiri Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
{{--    <link href="https://fonts.googleapis.com/css2?family=El+Messiri&display=swap" rel="stylesheet">--}}
    <!-- font awesome Icons -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="{{asset('css/landing.css'). '?_=' . config('app.version_date')}}" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;700&display=swap');

        html, body {
            direction: rtl;
            font-family: 'El Messiri', sans-serif;
        }
    </style>
</head>

<body>

<header id="nav-header">
    <!-- Navbar Section -->
    <section id="navbar">
        <nav id="mainNavbar" class="navbar navbar-expand-md navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img id="logo-img" src="{{asset('public/images/logo.jpg')}}" alt="logo"></a>
                <b>قائمة الطلبات</b>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars text-black"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class=" nav-item ">
                            <a class="nav-link js-scroll-trigger" href="#banner">الرئيسية</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link js-scroll-trigger" href="#menu">المنيو</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link js-scroll-trigger" href="#products">المنتجات</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link js-scroll-trigger" href="#contact">تواصل معنا</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>
    <!--End of Navbar Section -->

    <section id="banner">
        <div class="banner-content text-center">
        <h2>
            <b>
            أول شي يطلبه العميل !!!
            </b>
        </h2>
        <h2 class="text-center text-red main-subject">
                <b>
                وين المنيو ؟؟؟
                </b>
            </h2>
            <h3><b>
            عشان كذا نوفرلكم
            </b></h3>
            <h3 class="text-red " >خدمة المنيو الإلكتروني
            </h3>
            <h6 class="text-black " >
                <b>
                تجربه مميزه للعميل والتاجر
                </b>    
            </h6>
            <div class="btn-banner collapse">
                <button class="btn btn-warning" onclick="goToMenuSection()" >مينيو صفحات المنيو</button>
            </div>
        </div>
    </section>
</header>
<main>
    <section id="menu">
        <div class="container-fluid">
        <img src="/public/images/home.jpg" class="width-100" alt="">
        <div class="container" >
                <div class="px-4 py-4" >
                <h3 class="bg-royalblue main-subject" >مزايا المنيو الالكتروني</h3>
                </div>
                <div class="bg-royalblue app-content-2 text-white border-circular-5 py-2" >
                        <ul>
                         <li>
                         <i class="fa fa-check mx-2" ></i>   تحسين تجربة العميل                            
                        </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>    سهولة الوصول للمنيو من خلال الرابط او الباركود
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>      الرابط تقدر تستخدمة في وسائل التواصل وفي الاعلانات 
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>       الرابط عملائك يقدرون يشاركونه مع اصدقائهم ومع من يحبون وهذا راح يزيد من عدد عملائك
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>       اذا عندك زحمه العميل يقدر يحط طلبه في السلة بحيث يكون قادر يعطيه للكاشير مباشره وهذا يقلل وقت الانتظار ويرفع الانتاجيه والمبيعات 

                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>       الطلب بشكل اسرع وتقليل وقت الانتظار
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>       سهل التعديل والاضافة على المنيو وبشكل فوري
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>      تقدر تحط عروضك وتعدل عليها مباشره 
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>              تقدر تخفي المنتجات اللي غير متوفره
تقدر تحط روابط التواصل وجميع مواقع الفروع           
                            
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>           توفير تكاليف التصميم 
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>             وما ننسى نذكرك بوجود صور احترافيه في المنيو يفتح الشهيه وتخلي العميل وده يطلب كل شي ..!!
                            </li>
                            <li>
                            <i class="fa fa-check mx-2" ></i>            تصاميم مختلفه وعصرية للمنيو
                            </li>
                           
                        </ul>
                </div>
                <div class="px-4 py-4" >
                    <h3 class="text-center bg-royalblue main-subject">الباقات</h3>
                </div>

                <div class="row col-lg-12" >

                <div class="col-lg-4" >
                        <div class="my-4 bg-royalblue text-center app-content-2 text-white border-circular-5 py-2" >
                            <h3 class="my-2" ><b>
                            الذهبية 

                            </b></h3>
                            <h4 class="my-2" ><b>
                            اشتراك سنوي 

                            </b></h4>
                            <h4 class="my-2" ><b>299  ريال</b></h4>     
                            <a href="https://wa.me/message/KCCISGOBK3MSB1">
                            <label class="bg-white text-black px-2 py-2 border-circular-5" >
                            لطلب الاشتراك                            </label>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4" >
                        <div class="my-4 bg-royalblue text-center app-content-2 text-white border-circular-5 py-2" >
                            <h3 class="my-2" ><b>
                            البلاتينية
                            </b></h3>
                            <h4 class="my-2" ><b>
                            اشتراك سنوي
                            </b></h4>
                            <h4 class="my-2" ><b>389 ريال</b></h4>     
                            <a href="https://wa.me/message/KCCISGOBK3MSB1">
                            <label class="bg-white text-black px-2 py-2 border-circular-5" >
                            لطلب الاشتراك                            </label>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4" >
                    <div class=" my-4 bg-royalblue text-center app-content-2 text-white border-circular-5 py-2" >
                        <h3 class="my-2" ><b>
                        باقة الطلبات

                        </b></h3>
                        <h4 class="my-2" ><b>
                            اشتراك سنوي
                        </b></h4>
                        <h4 class="my-2" ><b>
                            549 ريال
                        </b></h4>     
                        <a href="https://wa.me/message/KCCISGOBK3MSB1">
                            <label class="bg-white text-black px-2 py-2 border-circular-5" >
                            لطلب الاشتراك                            </label>
                            </a>
                    </div>
                    </div>    
                    
                </div>
                <div class="col-lg-2 col-sm-12 text-center mx-2 px-4 py-4 my-2 container-whatsapp col-md-12 " >
                    <a href="https://wa.me/message/KCCISGOBK3MSB1" class="d-inline" >
                        <img src="/public/images/whatsapp.png" class="icon-whatsapp" alt="">
                    </a>
                    <h4>
                    <b>
                        تواصل معنا الان وخلنا نضبطلك المنيو 
                    </b>
                    </h4>
                </div>
        </div>

            <div class="row mt-5 collapse">
                <div class="col-sm-7 d-flex justify-content-center align-items-center flex-column">
                    <p id="prod-text">مع تجربة المينيو الالكترونى<br>كل الامور اصبحت اكثر سهولة</p>
                    <img class="menu-chart" src="{{asset('images/landing/10.png')}}" alt="map">
                </div>
                <div class="col-sm-5 d-flex justify-content-center align-items-center flex-column">
                    <img class="menu-mobile" src="{{asset('images/landing/13-1.png')}}" alt="mobile">
                    <div>
                        <a href="#contact" id="btn-menu" class="btn btn-warning">لطلب خدمة المنيو</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="products" class="mt-3 collapse">
        <div class="container">
            <div class="row flex-column-reverse flex-sm-row">
                <div id="first-feature" class="col-12 col-sm-7 feature-container">
                    <h3>ابرز منتجاتك وضاعف الانتاجية</h3>
                    <P>من خلال منيو صفحات المنيو الالكترونى سوف تتمكن من اضافة</P>
                    <p> منتجاتك وابرازها لعملائك ليسهل وصول وطلب العميل</p>
                </div>
                <div class="col-8 offset-4 offset-sm-0 col-sm-5">
                    <img class="products-img" src="{{asset('images/landing/6.png')}}" alt="click">
                </div>
            </div>
            <div class="row mt-5 collapse">
                <div id="second-feature" class="col-12 feature-container mt-3">
                    <h3>كل التفاصيل فى مكان واحد</h3>
                    <p>حرصنا فى منيو صفحات المنيو ان نجمع كل اهتمامات العملاء وأن تكون فى مكان واحد </p>
                    <p>من تفاصيل المنتجات الى وسائل التواصل الاجتماعى والموقع</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-5 offset-sm-7 d-flex justify-content-center d-sm-block">
                    <img class="products-img" style="max-width: 15rem; max-height: 15rem" src="{{asset('images/landing/5.png')}}" alt="mobile_messages">
                </div>
            </div>
        </div>
        <div class="row mt-lg-6 flex-column-reverse flex-sm-row">
            <div class="col-12 col-sm-5">
                <img id="click-img" class="products-img" style="max-width: 15rem;" src="{{asset('images/landing/4.png')}}" alt="click">
            </div>
            <div class="col-12 col-sm-7 feature-container">
                <h3>العروض</h3>
                <p>الآن بكل سهولة سيبقى عملائك على اطلاع دائم بجديد متجركم وجديد العروض حيث من خلال ايقونة العروض سيكون العملاء على دراية بجميع العروض</p>
            </div>
        </div>
    </section>

    <section id="contact collapse">
        <div class="container contact-container mt-5 collapse">
            <h3 id="contact-header">مرحبا بك فى صفحات المنيو</h3>
            <h4 class="text-center" >تقدم بطلب تجربة الخدمة</h4>
            <div class="row">
                <div class="col-sm-4 d-flex justify-content-center align-items-center flex-column" id="form-logo-container">
                    <img class="w-100 collapse" src="{{asset('images/landing/1.png')}}" alt="contact-logo">
                </div>
                <div class="col-sm-8">
                    <form method="post" id="menu-request-form" action="{{route('store-menu-request')}}" class="row g-3 mt-5" onsubmit="submitForm(event)">
                        @csrf
                        <div class="col-12 form-floating">
                            <input name="restaurant_name" type="text" class="form-control form-inputs" id="restaurant_name" placeholder="اسم المتجر" required>
                            <label for="restaurant_name">اسم المتجر*</label>
                        </div>

                        <div style="align-items: center;display: flex;justify-content: center;" >

                        <div style="width:40%" >
                            <p style="margin:0px">menuspages.com.</p>
                        </div>
                        <div style="width:60%" >
                            <input name="subdomain" type="text" class="form-control border" style="border-color:black !important;padding: 0.2rem !important;" id="subdomain" placeholder="رابط المتجر" required style="padding-top: 1rem; margin-right: 5px;">
                        </div>

                        </div>
                        <p id="url-comment">سيكون هو رابط المتجر الذى يمكن للعملاء الدخول عليه للطلب. يجب ادخال الاحرف الانجليزية والارقام</p>

                     


                        <div class="col-8 form-floating">
                            <input name="full_name" type="text" class="form-control form-inputs" id=" full_name" placeholder="الاسم" required>
                            <label for=" full_name">الاسم*</label>
                        </div>
                        <div class="col-7 form-floating phone">
                            <input name="phone" type="tel" class="form-control form-inputs" id=" phone-input" placeholder="رقم الجوال" aria-describedby="basic-addon2" required>
                            <span id="phone-code" class="input-group-text">966+</span>
                            <label for="phone" id="basic-addon2">رقم الجوال*</label>
                        </div>
                        <div class="col-12 form-floating">
                            <input name="email" type="email" class="form-control form-inputs" id=" email-input" placeholder="البريد الالكترونى" required>
                            <label for="email-input">البريد الالكترونى*</label>
                            <div class="invalid-feedback">
                                Invalid Email
                            </div>
                        </div>
                        <div class="col-12 form-floating">
                            <input name="discount_code" type="text" class="form-control form-inputs" id="discount_code" placeholder="كود الخصم">
                            <label for="discount_code">كود الخصم</label>
                        </div>
                        <div class="col-12">
                            @include('layouts.menu-partials.floating-alert')
                            <button class="btn btn-form w-100" type="submit">
                                إشتــــرك الآن
                                <img src="{{asset('images/loading_waves.gif')}}" alt="loading" id="loading-submit" class="loading" style="display: none;">
                            </button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center align-items-center" id="contact-methods">
                        @php
                            $supportPhone = config('app.whatsapp_support_phone');
                            $supportEmail = config('app.support_email');
                            $whatsappLink = is_mobile()? "whatsapp://send?phone=$supportPhone" : "https://web.whatsapp.com/send?phone=$supportPhone";
                        @endphp
                        @if($supportPhone)
                            <a href="{{$whatsappLink}}" style="margin-left: 3rem;">
                                <i class="fab fa-2x fa-whatsapp whatsapp"></i>
                            </a>
                        @endif
                        @if($supportEmail)
                            <a href="mailto:{{$supportEmail}}" >
                                <i class="fas fa-2x fa-envelope"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js " integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin=" anonymous "></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js " integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW " crossorigin="anonymous "></script>
<script src="{{asset('js/landing.js'). '?_=' . config('app.version_date')}}"></script>
</body>

</html>
