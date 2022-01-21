  
<div class=" col-lg-6 col-md-12 col-sm-12 offset-lg-3" >
<div class="my-2 contact-us-label" style="background-color:white;font-size: 1.3rem;text-align:center;box-shadow: rgb(0 0 0 / 18%) 0px 6px 15px;border-radius: 10px;display:inline-block">
    <label class="px-2" style="margin:0px;color: black;" for=""> <b>تواصل معنا</b> </label>
</div>
<div class="my-2 contact-us">

    @if($restaurant->phone)
    <a href="tel:{{$restaurant->phone}}" class="mr-1"><i class="fas fa-2x fa-phone-alt phone"></i></a>
    @endif
    @if($restaurant->google_map_location_link)
    <a href="{{$restaurant->google_map_location_link}}" class="mr-1">
        <i class="fas fa-2x fa-map-marker-alt google-maps"></i>
    </a>

    @endif
    @if($restaurant->whatsapp_number)
    @php
    $whatsappLink = is_mobile()? "whatsapp://send?phone=$restaurant->whatsapp_number" : "https://web.whatsapp.com/send?phone=$restaurant->whatsapp_number";
    @endphp
    <a href="{{$whatsappLink}}" class="mr-1">
        <i class="fab fa-2x fa-whatsapp whatsapp"></i>
    </a>
    @endif
    @if($restaurant->facebook_link)
    <a href="{{$restaurant->facebook_link}}" class="mr-1"><i class="fab fa-2x fa-facebook facebook"></i></a>
    @endif
    @if($restaurant->twitter_link)
    <a href="{{$restaurant->twitter_link}}" class="mr-1"><i class="fab fa-2x fa-twitter twitter"></i></a>
    @endif
    @if($restaurant->instagram_link)
    <a href="{{$restaurant->instagram_link}}" class="mr-1"><i class="fab fa-2x fa-instagram instagram"></i></a>
    @endif
    @if($restaurant->snapchat_link)
    <a href="{{$restaurant->snapchat_link}}" class="mr-1"><i class="fab fa-2x fa-snapchat snapchat"></i></a>
    @endif

</div>
</div>
  
<script>
$(function() {
    var cn = $(".contact-us").children().length;
    if(cn == 0)
    {
        $('.contact-us-label').hide();
    }
});
</script>    