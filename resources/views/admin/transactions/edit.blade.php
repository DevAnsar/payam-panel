@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">تراکنشات موجودی</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">ویرایش تراکنش</li>
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
                                <h5 class="header-title mb-4">ویرایش مشخصات تراکنش</h5>

                                <form action="{{route('admin.transactions.update',['transaction'=>$transaction])}}" method="post" >
                                    @method('patch')
                                    @csrf

                                    <div class="form-group row">
                                        <label for="type" class="col-md-3 col-form-label">
                                            نوع تراکنش:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="type" name="type" disabled >
                                                <option   disabled selected>انتخاب کنید...</option>
                                                <option value="deposit"  {{ $transaction->type == 'deposit' ? 'selected' : null }}  >واریز</option>
                                                <option value="harvest"  {{ $transaction->type == 'harvest' ? 'selected': null }} >برداشت</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="price" class="col-md-3 col-form-label">
                                            مبلغ تراکنش :
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input class="form-control" style="direction: ltr" disabled type="number" id="price" name="price"
                                                   value="{{$transaction->price}}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="count" class="col-md-3 col-form-label">
                                            پیامک معادل با مبلغ (به عدد):
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input class="form-control" disabled style="direction: ltr" type="text" id="count" name="count"
                                                   value="{{$transaction->count}}" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="body" class="col-md-3 col-form-label">
                                            توضیحات تراکنش:
                                        </label>
                                        <div class="col-md-9">
                                            <textarea rows="2" class="form-control" type="text" name="body" id="body"
                                            >{!! $transaction->body !!}</textarea>
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
