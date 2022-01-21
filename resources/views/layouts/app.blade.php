<!doctype html>
<html lang="{{app()->getLocale()}}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ isset($favIcon)? $favIcon : asset('images/daleelh-logo-1.jpg') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!--libraries for firebase started-->
  <script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
  <script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
  <!--libraries for firebase ended-->
  <title>{{isset($title)? $title: config('app.name')}}</title>
  <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="{{asset('css/app.css') . '?_=' . config('app.version_date')}}">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    @yield('head-scripts')

  <script>
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
      apiKey: "AIzaSyBBtM8Ka6r5C2qtBMXS9Ezck0dAKYd-tsE",
      authDomain: "menus-75bde.firebaseapp.com",
      projectId: "menus-75bde",
      storageBucket: "menus-75bde.appspot.com",
      databaseURL: "https://menus-75bde-default-rtdb.firebaseio.com",
      messagingSenderId: "350124085483",
      appId: "1:350124085483:web:73605ac8149bc26536eeae",
      measurementId: "G-T6SNSCMGFD"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    //   get orders count listner
    var restaurant_id = "{{auth()->user()->restaurant_id ??''}}";
    var dbRef = firebase.database();
    var ordersCountRef = dbRef.ref('new_orders/' + restaurant_id);
    ordersCountRef.on('child_added', function(snapshot) {

      if (snapshot.Xn.repo.dataUpdateCount > 0) {

        var d = ordersCountRef.child(snapshot.key);
        if(snapshot.exists()){
        Object.keys(snapshot.val()).map(k => {
            var order_id = snapshot.val()[k];
            try 
            {
              saveNotification(order_id);
            }
            catch
            {

            }
        });
        }

        try 
            {
              ordersCountRef.remove();
              playSound();
            }
            catch
            {
              
            }
       
      }
    });

    function saveOrder(order_id) {
      var restaurant_id = "{{$restaurant->id ?? ''}}";
      var dbRef = firebase.database();
      var contactsRef = dbRef.ref('new_orders/' + restaurant_id);

      contactsRef.push({
        order_id: order_id
      });

    }
    // get current domain
    function getDomain()
    {
                var pathname = window.location.pathname;
                var domain = pathname.split("/")[1];
                return domain;
    }
    
    function setColoring()
    {
      var colors = "{{($restaurant->colors)??''}}";
        if (colors != '') {
            colors = colors.replace(/&quot;/g, '"');
            colors = JSON.parse(colors.replace(/&quot;/g, '"'));

            $.map(colors, function(value, key) {
                $("." + key).css({
                    'color': value
                });
            });
        }
    }
    $(function() {
      setColoring();
    });

    // slider for restaurant background images at the top
    
    var slideIndex = 0;
    setInterval(function() {
      try {
        var i;
        var slides = document.getElementsByClassName("slide");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        slides[slideIndex - 1].style.display = "block";
      }
      catch(err) {
        
    }
    }, 3000);

      // get unseen notifcations count
  $(function()
  {
          $.ajax({
              url: "/dashboard/orders/get-unseen-nofitications-count?restaurant_id="+restaurant_id,
              type: "get",
              success: function (response) {

        try 
        {
          setLiveOrdersCount(response.notifications_count);
        }        
        catch(err) 
        {  //We can also throw from try block and catch it here
            
        }
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  console.log(textStatus, errorThrown);
              }
          });
  
  });

  </script>

  <style>
.input-checkbox {
    --primary: #cac4c4;
    --secondary: #FAFBFF;
    --duration: .50s;
    -webkit-appearance: none;
    -moz-appearance: none;
    -webkit-tap-highlight-color: transparent;
    -webkit-mask-image: -webkit-radial-gradient(white, black);
    outline: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transform-style: preserve-3d;
    perspective: 240px;
    border-radius: 25%;
    width: 15px;
    height: 15px;
    background-size: 300% 300%;
    transition: transform .3s;
    transform: scale(var(--scale, 1)) translateZ(0);
    animation: var(--name, unchecked) var(--duration) ease forwards;
}

    @media only screen and (max-width: 600px) {
      .back-images 
      {
          height:300px;   
      }
    }
    @media only screen and (min-width: 600px) {

        .back-images 
        {
            height:680px;   
        }
    }
  </style>

</head>

<body>
  @yield('body-content')

  @yield('body-scripts')
  <script>
    function setBackElementsThisTheme() {
        try
        {
            var data = "{{$restaurant->back_theme_color_code ?? ''}}";
            data = JSON.parse(data.replace(/&quot;/g,'"'));
            if(data["type"] == 1)
            {
                $("#app_main").css({
                    "background-image" : "url('"+data["value"]+"')" ,
                    "background-size" : "cover"
                });
            }
            else 
            {
                $("#app_main").css({
                    "background-color" : "#"+data["value"] ,
                    "background-size" : "cover"
                });
            }
        } 
        catch(err) 
        {  //We can also throw from try block and catch it here
            
        }
    }
  </script>
</body>

</html>
