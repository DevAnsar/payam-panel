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
                            <li class="breadcrumb-item active">لیست تراکنشات سیستم</li>
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
                                    <a class="dropdown-item" href="{{route('admin.transactions.create')}}">
                                            ایجاد تراکنش جدید
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
                    <div class="col-12">
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
                                            <th scope="col">نوع</th>
                                            <th scope="col">تاریخ</th>
                                            <th scope="col">مقدار</th>
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
                                                @if($transaction->type == 'deposit')
                                                    <div class="badge badge-soft-primary">واریز</div>
                                                @elseif($transaction->type == 'harvest')
                                                    <div class="badge badge-soft-warning">برداشت</div>
                                                @else
                                                    <div class="badge badge-soft-danger">نا معلوم</div>
                                                @endif

                                                    <p>
                                                        @if($transaction->safe)
                                                            <a href="{{route('admin.safes.index')}}">
                                                            <span class="badge badge-soft-info">
                                                                {{$transaction->safe->key}}
                                                                (
                                                                {{$transaction->safe->description}}
                                                                )
                                                            </span>
                                                            </a>
                                                        @endif
                                                    </p>

                                            </td>

                                            <th scope="row">
                                                <span class="badge badge-soft-primary" >
                                                {{Verta($transaction->created_at)}}
                                                </span>
                                            </th>

                                            <td>
                                                <h4>
                                                    <span class="badge badge-soft-primary" style="direction: ltr">
                                                        {{number_format($transaction->value)}}
                                                    </span>
                                                </h4>

                                            </td>

                                            <td>{{$transaction->body}}</td>
                                            <td>
                                                <h4>
                                                    <span class="badge badge-soft-dark" style="direction: ltr">
                                                          {{number_format($transaction->account_balance)}}
                                                    </span>
                                                </h4>
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
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
@endsection