@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">مشخصات کاربر</h4>
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
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">خلاصه وضعیت کاربر</h5>

                                <div class="card">
                                    <div class="card-body">

                                        <h6 class="card-subtitle font-14 text-muted">
                                            موجودی اکانت :
                                            <span>{{$user_sms_inventory}}</span>
                                            عدد
                                        </h6>
                                    </div>

                                    <div class="card-body">
                                        <h6 class="card-subtitle font-14 text-muted">
                                            مصرف کل :
                                            <span>{{$user->usedCount}}</span>
                                            عدد
                                        </h6>
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
                                <h5 class="header-title mb-4">مشخصات کاربری</h5>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">نام کاربر :</h4>
                                        <p class="card-text d-inline">
                                            @if($user->name)
                                                {{$user->name}}
                                            @else
                                            <span class="badge badge-soft-warning">
                                                تعریف نشده
                                            </span>
                                            @endif
                                        </p>
                                    </div>


                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">ایمیل کاربر :</h4>
                                        <p class="card-text d-inline">
                                            @if($user->email)
                                                {{$user->email}}
                                            @else
                                                <span class="badge badge-soft-warning">
                                                تعریف نشده
                                            </span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">شماره موبایل :</h4>
                                        <p class="card-text d-inline">
                                            @if($user->mobile)
                                                {{$user->mobile}}
                                            @else
                                                <span class="badge badge-soft-warning">
                                                تعریف نشده
                                            </span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-4">
                                        <h4 class="card-title font-size-16 mt-0 d-inline">تاریخ عضویت :</h4>
                                        <p class="card-text d-inline">
                                            @if($user->created_at)
                                                {{Verta($user->created_at)->format("%d %B %Y - H:i")}}
                                            @else
                                                <span class="badge badge-soft-warning">
                                                تعریف نشده
                                            </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title">
                                    گزارشات
                                </h4>
                                <p class="card-title-desc">
{{--                                    //--}}
                                </p>

                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           data-toggle="tab"
                                           href="#send_box" role="tab" aria-controls="send_box-tab" aria-selected="true">
                                            <i class="mdi mdi-home-variant-outline font-size-18 mr-1 align-middle"></i>
                                            <span class="d-none d-md-inline-block">آخرین ارسال ها</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "
                                           data-toggle="tab"
                                           href="#links" role="tab" aria-controls="links-tab" aria-selected="true">
                                            <i class="mdi mdi-home-variant-outline font-size-18 mr-1 align-middle"></i>
                                            <span class="d-none d-md-inline-block">لینک ها</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab"
                                           href="#packages" role="tab" aria-controls="packages-tab" aria-selected="true">
                                            <i class="mdi mdi-account-outline font-size-18 mr-1 align-middle"></i>
                                            <span class="d-none d-md-inline-block">اشتراکات خریداری شده</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab"
                                           href="#customers" role="tab" aria-controls="customers-tab" aria-selected="true">
                                            <i class="mdi mdi-email-outline font-size-18 mr-1 align-middle"></i>
                                            <span class="d-none d-md-inline-block">مشتری ها</span>
                                        </a>
                                    </li>

                                </ul>

                                <div class="tab-content" id="myTabContent">

                                    <div class="tab-pane fade show active" id="send_box" role="tabpanel" aria-labelledby="send_box-tab">
                                        <div class="table-responsive mt-4">
                                            @if(sizeof($user_sends) > 0)
                                                <table class="table table-centered table-hover mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ردیف</th>
                                                        <th scope="col">شماره موبایل</th>
                                                        <th scope="col">متن</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($user_sends as $user_send)
                                                        <tr>
                                                            <th scope="row">
                                                                <a href="#">{{$loop->index}}</a>
                                                            </th>
                                                            <td>{{$user_send->mobile}}</td>
                                                            <td>{{$user_send->text}}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="alert alert-warning">
                                                    ارسالی ثبت نشده است
                                                </div>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="links-tab">
                                        <div class="table-responsive mt-4">
                                            @if(sizeof($medias) > 0)
                                                <a class="text-white " href="{{route('admin.users.medias.edit',['user'=>$user])}}">
                                                   <button class="btn btn-info waves-effect waves-light ">ویرایش لینک ها</button>
                                                </a>


                                                <a class="text-white " href="{{route('admin.users.sends.show',['user'=>$user])}}">
                                                    <button class="btn btn-dark waves-effect waves-light ">ارسال از اکانت</button>
                                                </a>

                                                <table class="table table-centered table-hover mb-0 mt-4">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ردیف</th>
                                                        <th scope="col">عنوان</th>
                                                        <th scope="col" style="text-align: center">مقدار</th>
                                                        <th scope="col">تعداد کاراکتر</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($medias as $media)
                                                        <tr>
                                                            <th scope="row">
                                                               {{$loop->index + 1}}
                                                            </th>
                                                            <td>{{$media->title}}</td>
                                                            <td>

                                                                <div class="d-flex flex-row-reverse align-items-center justify-content-center">
                                                                @if($media->link != null )

                                                                    <a href="{{$media->base_url . $media->link->value}}" target="_blank" class="d-flex flex-row-reverse align-items-center">
                                                                        <span style="direction: ltr">{{$media->base_url}}</span>
                                                                        <span style="direction: ltr" class="badge badge-soft-info">{{$media->link->value}}</span>
                                                                    </a>

                                                                @else
                                                                    <span class="badge badge-soft-warning">بدون مقدار</span>
                                                                @endif
                                                                </div>

                                                            </td>
                                                            <td>
                                                                @if($media->link != null )
                                                                    {{strlen($media->link->value)}}
                                                                @else
                                                                    0
                                                                @endif</td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td ></td>
                                                        <td >
                                                            در مجموع
                                                            <span class="badge badge-info">
                                                                {{$valueSum}}
                                                             </span>
                                                              کاراکتر

                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="alert alert-warning">
                                                    لینکی در سیستم تعریف نشده است
                                                </div>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="packages" role="tabpanel" aria-labelledby="packages-tab">
                                        <div class="table-responsive mt-4">
                                            @if(sizeof($purchased_packages) > 0)
                                                <table class="table table-centered table-hover mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ردیف</th>
                                                        <th scope="col">عنوان</th>
                                                        <th scope="col">تعداد</th>
                                                        <th scope="col">مبلغ</th>
                                                        <th scope="col">موجودی</th>
                                                        <th scope="col">مدت بسته (روز)</th>
                                                        <th scope="col">فعال از تاریخ</th>
                                                        <th scope="col">اتمام در تاریخ</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($purchased_packages as $purchased_package)
                                                        <tr>
                                                            <th scope="row">
                                                                <a href="#">{{$loop->index +1 }}</a>
                                                            </th>
                                                            <td>{{$purchased_package->description}}</td>
                                                            <td>{{number_format($purchased_package->count)}}</td>
                                                            <td>
                                                                {{number_format($purchased_package->price)}}
                                                                ریال
                                                            </td>
                                                            <td>
                                                                {{number_format($purchased_package->inventory)}}
                                                            </td>
                                                            <td>
                                                                {{$purchased_package->package->days}}
                                                            </td>
                                                            <td>
                                                                {{Verta($purchased_package->started_at)->format("%d %B %Y - H:i")}}
                                                            </td>
                                                            <td>
                                                                {{Verta($purchased_package->expired_at)->format("%d %B %Y - H:i")}}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="alert alert-warning">
                                                    اشتراکی برای کاربر وجود ندارد
                                                </div>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                                        <div class="table-responsive mt-4">
                                            @if(sizeof($user_customers) > 0)
                                                <table class="table table-centered table-hover mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ردیف</th>
                                                        <th scope="col">شماره موبایل</th>
                                                        <th scope="col">نام</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($user_customers as $user_customer)
                                                        <tr>
                                                            <th scope="row">
                                                                <a href="#">{{$loop->index}}</a>
                                                            </th>
                                                            <td>{{$user_customer->mobile}}</td>
                                                            <td>{{$user_customer->name}}</td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            @else
                                                <div class="alert alert-warning">
                                                    مشتری برای کاربر وجود ندارد
                                                </div>

                                            @endif
                                        </div>
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
