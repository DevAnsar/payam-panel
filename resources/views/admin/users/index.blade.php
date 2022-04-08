@extends('admin.master')

@section('css-files')
    <!-- Sweet Alert-->
    <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">کاربران</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">لیست کاربران ثبت نام شده</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-settings-outline mr-1"></i>
                                    تنظیمات
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="{{route('admin.users.create')}}">
                                        ایجاد کاربر جدید
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right ml-2">
{{--                                    <a href="#">View all</a>--}}
                                </div>
                                <h5 class="header-title mb-4">لیست کاربران</h5>

                                <div class="table-responsive">
                                    @if(sizeof($users) > 0)
                                    <table class="table table-centered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">آیدی کاربر</th>
                                            <th scope="col">شماره موبایل</th>
                                            <th scope="col">نام</th>
                                            <th scope="col">ایمیل</th>
                                            <th scope="col">نوع</th>
                                            <th scope="col">تعداد استفاده از سرویس</th>
                                            <th scope="col">تنظیمات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <th scope="row">
                                                {{$loop->index+1}}
                                            </th>
                                            <th scope="row">
                                                <a href="{{route('admin.users.show',['user'=>$user])}}">{{$user->id}}</a>
                                            </th>
                                            <td>{{$user->mobile}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                <div class="badge badge-soft-primary">
                                                    @if($user->user_type == "Admin")
                                                        ادمین
                                                    @else
                                                    کاربر
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{$user->usedCount }}</td>
                                            <td>
                                                <div class=" d-flex " role="group">
                                                    <a href="{{route('admin.users.show',['user'=>$user])}}" class="m-2">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View">

                                                        <i class="mdi mdi-eye"></i>
                                                    </button>
                                                        </a>
                                                    <a href="{{route('admin.users.edit',['user'=>$user])}}" class="m-2">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">

                                                           <i class="mdi mdi-pencil"></i>

                                                    </button>
                                                    </a>
                                                    <delete-item class="m-2" url="{{"/admin/users/$user->id"}}"></delete-item>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        @else
                                            <div class="alert alert-warning">
                                                کاربری ثبت نشده است
                                            </div>
                                            @endif
                                    </table>
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

@section('js-files')
    <!-- Sweet Alerts js -->
    <script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection
