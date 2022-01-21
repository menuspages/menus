
    @if(!is_null(json_decode($item->allergens)))
        <label  class="label-allergens" for="">
           مسببات الحساسية 
        </label>
        @foreach(json_decode($item->allergens) as $icon)
        <div class="collapse d-inline-block item-allergens border-radius-100" >
        <div class="d-flex justify-content-center allergens  border-radius-100" >
                <img src="/public/allergens/{{$icon}}" class="icon-allergens border-radius-100 {{explode('.', $icon)[0]}}" width="25" height="25" alt="">
               </div>
               <div>
                  <label for="" class="font-size-15" >
                     {{explode('.', $icon)[0]}}
                  </label> 
               </div>
        </div>
       @endforeach
    @endif
