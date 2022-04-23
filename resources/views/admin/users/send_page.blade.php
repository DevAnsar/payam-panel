@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">ازسال پیامک از مدیریت</h4>
                        <ol class="breadcrumb m-0">
{{--                            <li class="breadcrumb-item active">لیست کاربران ثبت نام شده</li>--}}
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

                                <h4 class="header-title">
                                    ارسال از اکانت :
                                    @if($user->name)
                                    {{$user->name}}
                                        -
                                    @endif
                                    {{$user->mobile}}
                                </h4>
                                <p class="card-title-desc">
{{--                                    //--}}
                                </p>
                                    @if($user)

                                        <form method="POST" action="{{ route('admin.users.sends.send',['user'=>$user]) }}">
                                            @csrf


                                            <div class="form-group row">
                                                <label for="mobile" class="col-md-2 col-form-label">
                                                    شماره موبایل :
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="text" id="mobile" name="mobile"
                                                           value="{{$user->mobile}}" />
                                                    @if($errors->has('mobile'))
                                                        <div class="col-12 col-md-10 offset-md-2">
                                                            <div class="error small">{{ $errors->first('mobile') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-info waves-effect waves-light">
                                                ارسال
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">
                                            کاربر یافت نشد
                                        </div>
                                    @endif
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
@endsection
