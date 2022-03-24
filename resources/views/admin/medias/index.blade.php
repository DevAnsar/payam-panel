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
                            <li class="breadcrumb-item active">لیست شبکه های سیستم</li>
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
                                <h5 class="header-title mb-4">لیست شبکه ها</h5>

                                <div class="table-responsive">
                                    @if(sizeof($medias) > 0)
                                    <table class="table table-centered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">آیدی</th>
                                            <th scope="col">آیکون</th>
                                            <th scope="col">عنوان</th>
                                            <th scope="col">لینک پایه</th>
                                            <th scope="col">وضعیت</th>
                                            <th scope="col">تنظیمات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($medias as $media)
                                        <tr>
                                            <th scope="row">
                                                <a href="#">{{$loop->index}}</a>
                                            </th>
                                            <th scope="row">
                                                <a href="{{route('admin.medias.show',['media'=>$media])}}">{{$media->id}}</a>
                                            </th>
                                            <td>
                                                <img alt="{{$media->title}}" src="{{asset($media->icon)}}">
                                            </td>
                                            <td>{{$media->title}}</td>
                                            <td>{{$media->base_url}}</td>
                                            <td>
                                                @if($media->status)
                                                    <div class="badge badge-soft-primary">فعال</div>
                                                @else
                                                    <div class="badge badge-soft-primary">غیر فعال</div>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <a href="{{route('admin.medias.edit',['media'=>$media])}}">
                                                           <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                    </button>
                                                    <delete-item url="{{"/admin/medias/$media->id"}}"></delete-item>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        @else
                                            <div class="alert alert-warning">
                                                شبکه ای ثبت نشده است
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
                                    <a class="text-white" href="{{route('admin.medias.create')}}">
                                    <button class="btn btn-info w-100 waves-effect waves-light">
                                            ایجاد شبکه جدید
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
