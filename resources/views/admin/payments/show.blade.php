@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">مشخصات پرداخت</h4>
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

                    <div class="col-lg-9 mb-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right ml-2">
{{--                                    <a href="#">View all</a>--}}
                                </div>
                                <h5 class="header-title mb-4">مشخصات پرداخت و پرداخت کننده</h5>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">تاریخ ایجاد پرداخت :</h4>
                                        <p class="card-text d-inline">
                                            <span class="badge">
                                            {{Verta($payment->created_at)}}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">تاریخ آخرین بروزرسانی :</h4>
                                        <p class="card-text d-inline">
                                            <span class="badge">
                                            {{Verta($payment->updated_at)}}
                                            </span>
                                        </p>
                                    </div>


                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">مشخصات کاربر :</h4>
                                        <p class="card-text d-inline">
                                            @if($payment->user)
                                                <a href="{{route('admin.users.show',['user'=>$payment->user])}}">
                                                    {{$payment->user->name}}
                                                    ,
                                                    {{$payment->user->email}}
                                                </a>
                                            @else
                                                <span class="alert alert-danger">
                                                    کاربر موجود نمیباشد
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">پرداخت برای :</h4>
                                        <p class="card-text d-inline">
                                            @if($payment->package_id !=0 && $payment->package)
                                                <a href="{{route('admin.packages.show',['package'=>$payment->package])}}">
                                                    {{$payment->package->title}}
                                                </a>
                                            @else
                                                <span class="badge badge-soft-warning">
                                                تعریف نشده
                                            </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">مبلغ پرداخت :</h4>
                                        <p class="card-text d-inline">
                                            {{number_format($payment->price)}}
                                            @if($payment->price_type == "T")
                                                تومان
                                            @elseif($payment->price_type == "R")
                                                ریال
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">شماره تلفن پرداخت کننده :</h4>
                                        <p class="card-text d-inline">
                                            {{$payment->mobile}}
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">ایمیل پرداخت کننده :</h4>
                                        <p class="card-text d-inline">
                                            {{$payment->email}}
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">توضیحات تراکنش :</h4>
                                        <p class="card-text d-inline">
                                            {{$payment->body}}
                                        </p>
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
                                <h5 class="header-title mb-4">وضعیت پرداخت</h5>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">شماره ارجاع :</h4>
                                        <p class="card-text d-inline">
                                            @if($payment->authority)
                                                {{$payment->authority}}
                                            @else
                                                <span class="alert alert-warning">
                                                    بدون مقدار
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">شماره پیگیری :</h4>
                                        <p class="card-text d-inline">
                                            @if($payment->ref_id)
                                                {{$payment->ref_id}}
                                            @else
                                                <span class="badge badge-soft-warning">
                                                -
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">وضعیت پرداخت :</h4>
                                        <p class="card-text d-inline">

                                            @if($payment->status == "Paid")
                                                <span class="badge badge-success">
                                                    پرداخت شده
                                                </span>
                                            @elseif($payment->price_type == "Canceled")
                                                <span class="badge badge-danger">
                                                    پرداخت نشده
                                                </span>
                                            @elseif($payment->price_type == "Waiting")
                                                <span class="badge badge-warning">
                                                    در انتظار پرداخت
                                                </span>
                                            @endif
                                        </p>
                                    </div>
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
