@if($restaurant->notes1 && $restaurant->notes2)
<div style="font-size: 15px;font-weight: bold;">

    @foreach(explode('/', $restaurant->notes1) as $info)
    <label class="note_1">{{$info}}</label>
    <br>
    @endforeach


</div>
<br>

<div style="font-size: 15px;font-weight: bold;">

    @foreach(explode('/', $restaurant->notes2) as $info)
    <label class="note_2">{{$info}}</label>
    <br>
    @endforeach
</div>

@endif