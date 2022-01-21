@if($restaurant->open_from && $restaurant->open_to)
    <div
        class="working-hours text-center {{$restaurant->isOpened()? 'bg-success': 'bg-danger'}}">
        مفتوح من
        الساعة {{\Carbon\Carbon::createFromTimeString($restaurant->open_from)->isoFormat('h:mm a')}} الي
        الساعة {{\Carbon\Carbon::createFromTimeString($restaurant->open_to)->isoFormat('h:mm a')}}
    </div>
@endif
