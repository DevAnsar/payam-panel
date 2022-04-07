
@extends('admin.master')
@section('content')

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">داشبورد</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">به پنل مدیریت پیامکساز خوش آمدید</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
{{--                        <div class="float-right d-none d-md-block">--}}
{{--                            <div class="dropdown">--}}
{{--                                <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                    <i class="mdi mdi-settings-outline mr-1"></i> Settings--}}
{{--                                </button>--}}
{{--                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">--}}
{{--                                    <a class="dropdown-item" href="#">Action</a>--}}
{{--                                    <a class="dropdown-item" href="#">Another action</a>--}}
{{--                                    <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                                    <div class="dropdown-divider"></div>--}}
{{--                                    <a class="dropdown-item" href="#">Separated link</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-transparent p-3">
                                <h5 class="header-title mb-0">تابلو صورت وضعیت</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="media my-2">

                                        <div class="media-body">
                                            <p class="text-muted mb-2">
                                                مجموع کاربران
                                            </p>
                                            <h5 class="mb-0">کل : {{$allUsersCount}}</h5>
                                            <h6 class="mb-0">یک ماه گذشته : {{$lastNewUsersCount}}</h6>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-layer-group"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="media my-2">
                                        <div class="media-body">
                                            <p class="text-muted mb-2">
                                                پیام های ارسال شده
                                            </p>
                                            <h5 class="mb-0">کل : {{$allSendBoxCount}}</h5>
                                            <h6 class="mb-0">یک ماه گذشته : {{$lastSentDoxCount}}</h6>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-analytics"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="media my-2">
                                        <div class="media-body">
                                            <p class="text-muted mb-2">
                                                مجموع حساب
                                            </p>
                                            <h5 class="mb-0">اصلی : {{$amountInventory}}</h5>
                                            <h6 class="mb-0">مالیات : {{$commissionInventory}}</h6>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-ruler"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="media my-2">
                                        <div class="media-body">
                                            <p class="text-muted mb-2">
                                                شارژ سرویس پیامک
                                            </p>
                                            <h5 class="mb-0">
                                                {{$smsCredit}}
                                                عدد
                                            </h5>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-box"></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <payments-chart :chart_data="{{json_encode($paymentsChartData)}}"></payments-chart>
{{--                                <form class="form-inline float-right">--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <input type="text" class="form-control form-control-sm datepicker-here" data-range="true"  data-multiple-dates-separator=" - " data-language="en" placeholder="Select Date" />--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text"><i class="far fa-calendar font-size-12"></i></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                                <h5 class="header-title mb-4">Sales Report</h5>--}}
{{--                                <div id="yearly-sale-chart" class="apex-charts"></div>--}}
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->

                <div class="row">
{{--                    <div class="col-xl-4">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-6">--}}
{{--                                        <h5>Welcome Back !</h5>--}}
{{--                                        <p class="text-muted">Xoric Dashboard</p>--}}

{{--                                        <div class="mt-4">--}}
{{--                                            <a href="#" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-5 ml-auto">--}}
{{--                                        <div>--}}
{{--                                            <img src="{{asset('assets/images/widget-img.png')}}" alt="" class="img-fluid">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-body">--}}
{{--                                <h5 class="header-title mb-4">Monthy sale Report</h5>--}}
{{--                                <div class="media">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p class="text-muted mb-2">This month Sale</p>--}}
{{--                                        <h4>$ 13,425</h4>--}}
{{--                                    </div>--}}
{{--                                    <div dir="ltr" class="ml-2">--}}
{{--                                        <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false--}}
{{--                                               data-fgColor="#3051d3" value="56" data-skin="tron" data-angleOffset="56"--}}
{{--                                               data-readOnly=true data-thickness=".17" />--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <hr>--}}
{{--                                <div class="media">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p class="text-muted">Sale status</p>--}}
{{--                                        <h5 class="mb-0"> + 12 % <span class="font-size-14 text-muted ml-1">From previous period</span></h5>--}}
{{--                                    </div>--}}

{{--                                    <div class="align-self-end ml-2">--}}
{{--                                        <a href="#" class="btn btn-primary btn-sm">View more</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->

@endsection


@section('js-files')
    <script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>
@endsection
