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
                            <li class="breadcrumb-item active">لیست پرداخت ها</li>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right ml-2">
{{--                                    <a href="#">View all</a>--}}
                                </div>
                                <h5 class="header-title mb-4">لیست از آخرین پرداخت ها</h5>

                                <form action="{{route('admin.payments.index')}}" method="get" >
                                    <div class="form-group row">
                                        <label for="type" class="col-form-label">
                                            نوع تراکنش:
                                        </label>

                                        <select class="form-control w-25" id="type" name="type" >
                                            <option value="all"  {{ $type == null ? 'selected' : null }}>همه</option>
                                            <option value="Paid"  {{ $type == 'Paid' ? 'selected' : null }}  >پرداخت موفق</option>
                                            <option value="Waiting"  {{ $type == 'Waiting' ? 'selected': null }} >در انتظار پرداخت</option>
                                            <option value="Canceled"  {{ $type == 'Canceled' ? 'selected': null }} >ناموفق</option>
                                        </select>

                                        <button class="btn btn-primary waves-effect waves-light mx-2" type="submit">
                                            <i class="mdi mdi-filter"></i>
                                            فیلتر

                                        </button>
                                    </div>



                                </form>

                                <div class="table-responsive">
                                    @if(sizeof($payments) > 0)
                                    <table class="table table-centered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">آیدی</th>
                                            <th scope="col">کاربر</th>
                                            <th scope="col">مبلغ</th>
                                            <th scope="col">وضعیت پرداخت</th>
                                            <th scope="col">بابت</th>
                                            <th scope="col">تنظیمات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $payment)
                                        <tr>
                                            <th scope="row">
                                               {{$loop->index + 1 }}
                                            </th>
                                            <th scope="row">
                                                {{$payment->id}}
                                            </th>
                                            <th scope="row">
                                                <a href="{{route('admin.users.show',['user'=>$payment->user])}}">
                                                {{$payment->user->name}}
                                                </a>
                                            </th>


                                            <th scope="row">
                                                {{number_format($payment->price)}}
                                            </th>

                                            <td>
                                                @if($payment->status == 'Paid')
                                                    <div class="badge badge-soft-success">پرداخت موفق</div>
                                                @elseif($payment->status == 'Canceled')
                                                    <div class="badge badge-soft-danger">پرداخت ناموفق</div>
                                                @elseif($payment->status == 'Waiting')
                                                    <div class="badge badge-soft-info">در انتظار پرداخت</div>
                                                @endif

                                            </td>

                                            <th scope="row">
                                                <a href="{{route('admin.packages.show',['package'=>$payment->package])}}">
                                                    {{$payment->package->title}}
                                                </a>
                                            </th>

                                            <td>
                                                <div class="btn-group" role="group">
                                                        <a href="{{route('admin.payments.show',['payment'=>$payment])}}">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View">
                                                                <i class="mdi mdi-eye"></i>
                                                            </button>
                                                        </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        @else
                                            <div class="alert alert-warning">
                                                تراکنشی تاکنون ثبت نشده است
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
