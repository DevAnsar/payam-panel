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
                            <li class="breadcrumb-item active">ویرایش کاربر</li>
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

                                <form action="{{route('admin.users.update',['user'=>$user])}}" method="post" >
                                    @method('patch')
                                    @csrf
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-md-2 col-form-label">
                                        نام کاربر :
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="name"
                                               value="{{$user->name}}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-search-input" class="col-md-2 col-form-label">
                                        آدرس ایمیل:
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="email" name="email"
                                               value="{{$user->email}}" />
                                    </div>
                                </div>

                                    <div class="form-group row mt-4">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">
                                            ویرایش
                                        </button>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">تنظیمات</h5>


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
