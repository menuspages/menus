@extends('layouts.restaurant-manager-dashboard')

@section('content')
<div class="table-responsive">
                            <div class="container" >
                                @if(count($rating) > 0)
                                        @foreach($rating as $item)
                                        <div class="my-2 border-radius-2" >
                                        <div class="bg-white px-2 py-2 border" >
                                                <div class="d-flex justify-content-space-between" >
                                                        <div style="display:grid;width:70%" >
                                                                <label style="margin:0px;max-width: 60%;overflow: hidden;" >
                                                                        <b>{{$item->name}}</b>
                                                                </label>
                                                                <label style="word-break: break-all;line-height: 1;margin:0px;overflow: hidden;" >
                                                                        {{$item->rater_note}} 
                                                                </label>
                                                                
                                                        </div>
                                                        <label style="font-size:40px;" >&#{{$item->rate}};</label>    
                                                        
                                                </div>
                                                {{$item->created_at->addHours(3)}}
                                        </div>
                                        </div>
                                @endforeach
                                @endif
                            </div>
</div>

@endsection

@section('body-scripts')
   
@endsection
