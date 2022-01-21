@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>
                <div class="alert-danger">{{$error}}</div>
            </li>
        @endforeach
    </ul>
@endif
