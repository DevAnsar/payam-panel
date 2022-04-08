
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

                                        <chart title="{{$usersCountChartData['title']}}"
                                               type="line"
                                               :x_axis="{{json_encode($usersCountChartData['labels'])}}"
                                               :y_axis="{{json_encode($usersCountChartData['data'])}}"></chart>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <chart title="{{$paymentsPriceChartData['title']}}"
                                               type="line"
                                               :x_axis="{{json_encode($paymentsPriceChartData['labels'])}}"
                                               :y_axis="{{json_encode($paymentsPriceChartData['data'])}}"></chart>
                                    </div>
                                    <div class="col-md-6">
                                        <chart title="{{$paymentsCountChartData['title']}}"
                                               type="line"
                                               :x_axis="{{json_encode($paymentsCountChartData['labels'])}}"
                                               :y_axis="{{json_encode($paymentsCountChartData['data'])}}"></chart>
                                    </div>
                                </div>

{{--                                <payments-chart :chart_data="{{json_encode($paymentsChartData)}}"></payments-chart>--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <chart title="{{$moneyTransactionsChartData['title']}}"
                                               type="bar"
                                               :x_axis="{{json_encode($moneyTransactionsChartData['labels'])}}"
                                               :y_axis="{{json_encode($moneyTransactionsChartData['data'])}}"></chart>
                                    </div>
                                    <div class="col-md-6">
                                        <chart title="{{$moneyTransactionsCountChartData['title']}}"
                                               type="bar"
                                               :x_axis="{{json_encode($moneyTransactionsCountChartData['labels'])}}"
                                               :y_axis="{{json_encode($moneyTransactionsCountChartData['data'])}}"></chart>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <chart title="{{$commissionTransactionsChartData['title']}}"
                                               type="bar"
                                               :x_axis="{{json_encode($commissionTransactionsChartData['labels'])}}"
                                               :y_axis="{{json_encode($commissionTransactionsChartData['data'])}}"></chart>
                                    </div>
                                    <div class="col-md-6">
                                        <chart title="{{$commissionTransactionsCountChartData['title']}}"
                                               type="bar"
                                               :x_axis="{{json_encode($commissionTransactionsCountChartData['labels'])}}"
                                               :y_axis="{{json_encode($commissionTransactionsCountChartData['data'])}}"></chart>
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