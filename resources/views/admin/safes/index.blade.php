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
                        <h4 class="page-title mb-1">گاوصندوق</h4>
                        <ol class="breadcrumb m-0">
{{--                            <li class="breadcrumb-item active">لیست تراکنشات سیستم</li>--}}
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
                                <div class="float-right ml-2">
{{--                                    <a href="#">View all</a>--}}
                                </div>
                                <h5 class="header-title mb-4">لیست مقادیر هر پارامتر</h5>

                                <div class="table-responsive">
                                    @if(sizeof($safes) > 0)
                                    <table class="table table-centered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">آیدی</th>
                                            <th scope="col">کلید</th>
                                            <th scope="col">مشخصات</th>
                                            <th scope="col">مقدار</th>
                                            <th scope="col">تنظیمات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($safes as $safe)
                                        <tr>
                                            <th scope="row">
                                               {{$loop->index + 1 }}
                                            </th>
                                            <th scope="row">
                                                {{$safe->id}}
                                            </th>
                                            <td>
                                                {{$safe->key}}
                                            </td>
                                            <td>
                                                {{$safe->description}}
                                            </td>
                                            <td>
                                                <h4>
                                                    <span class="badge badge-soft-primary" style="direction: ltr">
                                                        {{number_format($safe->value)}}
                                                    </span>
                                                </h4>
                                            </td>

                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <a href="{{route('admin.safes.edit',['safe'=>$safe])}}">
                                                           <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                    </button>
{{--                                                    <delete-item url="{{"/admin/transactions/$safe->id"}}"></delete-item>--}}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        @else
                                            <div class="alert alert-warning">
                                                فیلدی در گاصندوق ثبت نشده است
                                            </div>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">تنظیمات</h5>

                                <div class="form-group">
                                    <a class="text-white" href="{{route('admin.safes.create')}}">
                                    <button class="btn btn-info w-100 waves-effect waves-light">
                                            ایجاد فیلد جدید برای گاوصندوق
                                    </button>
                                    </a>

                                </div>
                                <div class="form-group mt-4">
                                    <a class="text-white mt-4" href="{{route('admin.config.linkToStorage')}}">
                                        <button class="btn btn-info w-100 waves-effect waves-light">
                                            storage:link
                                        </button>
                                    </a>

                                </div>


                                <div class="form-group mt-4">
                                    <a class="text-white mt-4" href="{{route('admin.config.hardResetShow')}}">
                                        <button class="btn btn-warning w-100 waves-effect waves-light">
                                            !Hard Reset!
                                        </button>
                                    </a>

                                </div>

                                <div class="form-group mt-5">
                                    شارژ پنل پیامکی :
                                    {{number_format($smsCredit)}}
                                    عدد
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
