@extends('layouts.admin-dashboard')

@section('head-scripts')
    <style>
        body{
            background: url('{{$backgroundImageUrl}}');
            background-size: 100%;
        }
    </style>
@endsection
@section('body-content')
<div class="container ">
    <div class="mt-4  border-radius-small">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div>
                        <h3 class="text-center py-4" >
                            <b>
                            تسجيل الدخول
                            </b>
                        </h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="/login">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">الايميل</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">كلمة المرور</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label mr-3" for="remember">
                                            تذكرني؟
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        تسجيل الدخول
                                    </button>
                                </div>
                            </div>
                                    <br>
                          
                        </form>

                        <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                  <a href="/reset-password">
                                  <button  class="btn btn-primary">
                                    نسيت كلمة المرور
                                    </button>
                                  </a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
