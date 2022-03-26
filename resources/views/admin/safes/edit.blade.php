@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">گاوصندوق</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">ویرایش فیلد</li>
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
                                <h5 class="header-title mb-4">ویرایش فیلد از گاوصندوق</h5>

                                <form action="{{route('admin.safes.update',['safe'=>$safe])}}" method="post" >
                                    @method('patch')
                                    @csrf

                                    <div class="form-group row">
                                        <label for="key" class="col-md-3 col-form-label">
                                            کلید فیلد (camelCase):
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            {{$safe->key}}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-md-3 col-form-label">
                                            توضیحات فیلد:
                                        </label>
                                        <div class="col-md-9">
                                            <textarea rows="2" class="form-control" type="text" name="description" id="description"
                                            >{!! $safe->description !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="value" class="col-md-3 col-form-label">
                                            مقدار :
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input class="form-control" style="direction: ltr" type="text" id="value" name="value"
                                                   value="{{$safe->value}}" />
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
