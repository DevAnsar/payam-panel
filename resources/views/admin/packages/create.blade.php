@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">پکیج های پیامکی</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">ایجاد پک جدید</li>
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
                                <h5 class="header-title mb-4">مشخصات پک</h5>

                                <form action="{{route('admin.packages.store')}}" method="post" enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-md-2 col-form-label">

                                        عنوان  :
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="title"
                                               value="{{old('title')}}" />
                                    </div>
                                </div>
                                    <package-sms-count
                                            default_price="{{old('price')}}"
                                            default_count="{{old('count')}}"
                                            this_package_tariff="{{$smsTariff}}"
                                            sms_tariff="{{$smsTariff}}"
                                    ></package-sms-count>

                                    <div class="form-group row">
                                        <label for="days-input" class="col-md-2 col-form-label">

                                            مدت اعتبار (روز) :
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="number" id="days-input" name="days"
                                                   value="{{old('days')}}" />
                                        </div>
                                    </div>

                                <div class="form-group row">
                                    <label for="example-search-input" class="col-md-2 col-form-label">
                                        آیکون:
                                    </label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="file" name="icon" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-search-input" class="col-md-2 col-form-label">
                                        وضعیت:
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="status" >
                                            <option value="1"  {{(old('status') != 1 || old('status') == null) ? 'selected' : null }}  >فعال</option>
                                            <option value="0"  {{old('status') == '0' ? 'selected': null }} >غیر فعال</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        ایجاد
                                    </button>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">

                    </div>
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
@endsection
