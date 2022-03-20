@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">مشخصات کاربر</h4>
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
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">خلاصه وضعیت کاربر</h5>

                                <div class="card">
                                    <div class="card-body">

                                        <h6 class="card-subtitle font-14 text-muted">
                                            موجودی اکانت :
                                            <span>{{$user->basketCount}}</span>
                                            عدد
                                        </h6>
                                    </div>

                                    <div class="card-body">
                                        <h6 class="card-subtitle font-14 text-muted">
                                            مصرف کل :
                                            <span>{{$user->usedCount}}</span>
                                            عدد
                                        </h6>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right ml-2">
{{--                                    <a href="#">View all</a>--}}
                                </div>
                                <h5 class="header-title mb-4">مشخصات کاربری</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">نام کاربر :</h4>
                                        <p class="card-text d-inline">{{$user->name}}</p>
                                    </div>


                                    <div class="col-6">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">ایمیل کاربر :</h4>
                                        <p class="card-text d-inline">{{$user->email}}</p>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="card">
                            <div class="card-body">
                                <div class="float-right ml-2">
{{--                                                                        <a href="#">View all</a>--}}
                                </div>
                                <h5 class="header-title mb-4">اشتراکات خریداری شده</h5>

                                <div class="table-responsive">
                                    @if(sizeof($purchased_packages) > 0)
                                    <table class="table table-centered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">عنوان</th>
                                            <th scope="col">تعداد</th>
                                            <th scope="col">مبلغ</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($purchased_packages as $purchased_package)
                                            <tr>
                                                <th scope="row">
                                                    <a href="#">{{$loop->index}}</a>
                                                </th>
                                                <td>{{$purchased_package->description}}</td>
                                                <td>{{$purchased_package->count}}</td>
                                                <td>{{$purchased_package->price}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    @else
                                        <div class="alert alert-warning">
                                            اشتراکی برای کاربر وجود ندارد
                                        </div>

                                    @endif
                                </div>

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
