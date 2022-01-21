@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable" role="alert">
        <a href="" class="close closebutton" data-dismiss="alert" aria-label="close">&times;</a>
        {{Session::get('success')}}
    </div>

@endif
@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissable" role="alert">
        <a href="" class="close closebutton" data-dismiss="alert" aria-label="close">&times;</a>
        {{Session::get('error')}}
    </div>

@endif
@if(count($errors)>0)
    <div class="alert alert-danger alert-dismissable" role="alert">
        <a href="" class="close closebutton" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>

@endif
