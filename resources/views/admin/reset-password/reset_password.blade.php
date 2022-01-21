@extends('layouts.admin-dashboard')

@section('head-scripts')
@endsection
@section('body-content')
<div class="container">
    <div class="mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header goldish">نسيت كلمة المرور</div>
                    @if(!empty($message))
                                  <div class="alert alert-success" >
                                      {{$message}} 
                                  </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="/reset-password">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">الايميل</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"   autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                      
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                    ارسل بريد
                                    </button>
                                </div>
                            </div>
                      
                        </form>
                    <br>
                        <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                  <a href="/login">
                                  <button  class="btn btn-primary">
                                  تسجيل الدخول
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
