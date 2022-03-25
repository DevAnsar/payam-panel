@extends('admin.master')


@section('content')
    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">مشخصات لینک های کاربر</h4>
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


                    <div class="col-lg-9">

                        <div class="card">
                            <div class="card-body">

                                <h4 class="header-title">
                                    ویرایش لینک های کاربر
                                </h4>
                                <p class="card-title-desc">
{{--                                    //--}}
                                </p>

                                <div class="table-responsive mt-4">
                                    @if(sizeof($medias) > 0)

                                        <form method="POST" action="{{ route('admin.users.medias.update',['user'=>$user]) }}">
                                            @csrf
                                            <table class="table table-centered table-hover mb-0">
                                                <thead>
                                                <tr>
                                                    <th scope="col">ردیف</th>
                                                    <th scope="col">عنوان</th>
                                                    <th scope="col" style="text-align: center">مقدار</th>
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
                                                                <span style="direction: ltr">{{$media->base_url}}</span>
                                                                <input name="values[{{$media->id}}]"
                                                                           style="direction: ltr"
                                                                           value="{{$media->link != null ? $media->link->value : null}}">
                                                            </div>

                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>

                                            <button type="submit" class="btn btn-info waves-effect waves-light">
                                                ویرایش
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">
                                            لینکی در سیستم تعریف نشده است
                                        </div>

                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            {{--                            <div class="card-body">--}}
                            {{--                                <h5 class="header-title mb-4">خلاصه وضعیت کاربر</h5>--}}

                            {{--                                <div class="card">--}}
                            {{--                                    <div class="card-body">--}}

                            {{--                                        <h6 class="card-subtitle font-14 text-muted">--}}
                            {{--                                            موجودی اکانت :--}}
                            {{--                                            <span>{{$user->basketCount}}</span>--}}
                            {{--                                            عدد--}}
                            {{--                                        </h6>--}}
                            {{--                                    </div>--}}

                            {{--                                    <div class="card-body">--}}
                            {{--                                        <h6 class="card-subtitle font-14 text-muted">--}}
                            {{--                                            مصرف کل :--}}
                            {{--                                            <span>{{$user->usedCount}}</span>--}}
                            {{--                                            عدد--}}
                            {{--                                        </h6>--}}
                            {{--                                    </div>--}}

                            {{--                                </div>--}}

                            {{--                            </div>--}}
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- end page-content-wrapper -->
    </div>
@endsection
