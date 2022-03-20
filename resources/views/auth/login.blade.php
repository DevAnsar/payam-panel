@extends('layouts.app')

@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
{{--                    <a href="{{ url('/') }}" class="logo"><img src="{{asset('assets/images/logo-light.png')}}" height="24" alt="logo"></a>--}}
                    <h5 class="font-size-16 text-white-50 mb-4">
                        {{ config('app.name', 'Laravel') }}
                    </h5>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-xl-5 col-sm-8">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="p-2">
                            <h5 class="mb-5 text-center">ورود به مدیریت</h5>
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-custom mb-4">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            <label for="email">ایمیل</label>
                                            @error('email')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                        </div>

                                        <div class="form-group form-group-custom mb-4">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="userpassword">
                                            <label for="userpassword">رمز عبور</label>
                                            @error('password')
                                             <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                             </span>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline"  name="remember"  {{ old('remember') ? 'checked' : '' }} >
                                                    <label class="custom-control-label" for="customControlInline">به خاطر بسپار</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-md-right mt-3 mt-md-0">
{{--                                                    @if (Route::has('password.request'))--}}
{{--                                                     <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i>فراموشی رمز?</a>--}}
{{--                                                    @endif--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success btn-block waves-effect waves-light" type="submit">
                                                ورود
                                            </button>
                                        </div>
                                        <div class="mt-4 text-center">
{{--                                            <a href="#" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Create an account</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
@endsection
