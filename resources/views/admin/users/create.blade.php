@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">کاربران</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">ایجاد کاربر جدید</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        @include('admin.layouts.page-settings')
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">مشخصات فردی</h5>

                                <form action="{{route('admin.users.store')}}" method="post" >
                                    @method('post')
                                    @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label">
                                        نام کاربر :
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="name" name="name"
                                               value="{{old('name')}}" />
                                    </div>

                                    @if($errors->has('firstname'))
                                        <div class="error">{{ $errors->first('firstname') }}</div>
                                    @endif

                                </div>
                                <div class="form-group row">
                                    <label for="mobile" class="col-md-2 col-form-label">
                                        شماره موبایل :
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="mobile" name="mobile"
                                               value="{{old('mobile')}}" />
                                        @if($errors->has('mobile'))
                                            <div class="col-12 col-md-10 offset-md-2">
                                                <div class="error small">{{ $errors->first('mobile') }}</div>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-2 col-form-label">
                                        آدرس ایمیل:
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="email" id="email" name="email"
                                               value="{{old('email')}}" />
                                        @if($errors->has('email'))
                                            <div class="col-12 col-md-10 offset-md-2">
                                                <div class="error small">{{ $errors->first('email') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <label for="pWorld" class="col-md-2 col-form-label">
                                            رمز عبور:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="password" id="pWorld" name="password"
                                                   value="" />
                                            @if($errors->has('password'))
                                                <div class="col-12 col-md-10 offset-md-2">
                                                    <div class="error small">{{ $errors->first('password') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="user_type" class="col-md-2 col-form-label">
                                            سمت:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <select name="user_type" id="user_type" class="custom-select">
                                                <option value="User">کابر عادی</option>
                                                <option value="Admin">مدیر</option>
                                            </select>

                                            @if($errors->has('user_type'))
                                                <div class="col-12 col-md-10 offset-md-2">
                                                    <div class="error small">{{ $errors->first('user_type') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mt-4">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">
                                            ایجاد
                                        </button>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
{{--                        <div class="card">--}}
{{--                            <div class="card-body">--}}
{{--                                <h5 class="header-title mb-4">تنظیمات</h5>--}}


{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
@endsection
