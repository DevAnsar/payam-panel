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
                            <li class="breadcrumb-item active">لیست تراکنشات سیستم</li>
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
                                <h5 class="header-title mb-4">لیست از آخرین تراکنشات</h5>



                                <form action="{{route('admin.transactions.index')}}" method="get" >
                                    <div class="form-group row">
                                        <label for="type" class="col-form-label">
                                            نوع تراکنش:
                                        </label>

                                        <select class="form-control w-25" id="type" name="type" >
                                            <option value="all"  {{ $type == null ? 'selected' : null }}>همه</option>
                                            <option value="deposit"  {{ $type == 'deposit' ? 'selected' : null }}  >واریز</option>
                                            <option value="harvest"  {{ $type == 'harvest' ? 'selected': null }} >برداشت</option>
                                        </select>

                                        <button class="btn btn-primary waves-effect waves-light mx-2" type="submit">
                                            ویرایش
                                        </button>
                                    </div>



                                </form>

                                <div class="table-responsive">
                                    @if(sizeof($transactions) > 0)
                                    <table class="table table-centered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">آیدی</th>
                                            <th scope="col">مبلغ</th>
                                            <th scope="col">نوع</th>
                                            <th scope="col">جهت</th>
                                            <th scope="col">موجودی بعد از این تراکنش</th>
                                            <th scope="col">تنظیمات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <th scope="row">
                                               {{$loop->index + 1 }}
                                            </th>
                                            <th scope="row">
                                                {{$transaction->id}}
                                            </th>
                                            <td>
                                                {{number_format($transaction->price)}}
                                                تومان
                                            </td>
                                            <td>
                                                @if($transaction->type == 'deposit')
                                                    <div class="badge badge-soft-primary">واریز</div>
                                                @elseif($transaction->type == 'harvest')
                                                    <div class="badge badge-soft-warning">برداشت</div>
                                                @else
                                                    <div class="badge badge-soft-danger">نا معلوم</div>
                                                @endif
                                            </td>
                                            <td>{{$transaction->body}}</td>
                                            <td>
                                                {{number_format($transaction->account_balance)}}
                                                تومان
                                            </td>

                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <a href="{{route('admin.transactions.edit',['transaction'=>$transaction])}}">
                                                           <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                    </button>
{{--                                                    <delete-item url="{{"/admin/transactions/$transaction->id"}}"></delete-item>--}}
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

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">تنظیمات</h5>

                                <div class="form-group">
                                    <a class="text-white" href="{{route('admin.transactions.create')}}">
                                    <button class="btn btn-info w-100 waves-effect waves-light">
                                            ایجاد تراکنش جدید
                                    </button>
                                    </a>
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
