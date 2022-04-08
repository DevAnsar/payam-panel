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
                            <li class="breadcrumb-item active">لیست کاربران ثبت نام شده</li>
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
                                <h5 class="header-title mb-4">لیست کاربران</h5>

                                <div class="table-responsive">
                                    @if(sizeof($users) > 0)
                                    <table class="table table-centered table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">آیدی کاربر</th>
                                            <th scope="col">شماره موبایل</th>
                                            <th scope="col">نام</th>
                                            <th scope="col">ایمیل</th>
                                            <th scope="col">نوع</th>
                                            <th scope="col">تعداد استفاده</th>
                                            <th scope="col">تنظیمات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
{{--                                            {{dd($loop)}}--}}
                                        <tr>
                                            <th scope="row">
                                                <a href="#">{{$loop->index}}</a>
                                            </th>
                                            <th scope="row">
                                                <a href="{{route('admin.users.show',['user'=>$user])}}">{{$user->id}}</a>
                                            </th>
                                            <td>{{$user->mobile}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                <div class="badge badge-soft-primary">
                                                    @if($user->user_type == "Admin")
                                                        ادمین
                                                    @else
                                                    کاربر
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{$user->usedCount }}</td>
                                            <td>
                                                <div class=" d-flex " role="group">
                                                    <a href="{{route('admin.users.show',['user'=>$user])}}" class="m-2">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View">

                                                        <i class="mdi mdi-eye"></i>
                                                    </button>
                                                        </a>
                                                    <a href="{{route('admin.users.edit',['user'=>$user])}}" class="m-2">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">

                                                           <i class="mdi mdi-pencil"></i>

                                                    </button>
                                                    </a>
                                                    <delete-item class="m-2" url="{{"/admin/users/$user->id"}}"></delete-item>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        @else
                                            <div class="alert alert-warning">
                                                کاربری ثبت نشده است
                                            </div>
                                            @endif
                                    </table>
                                </div>

{{--                                <div class="mt-4">--}}
{{--                                    <ul class="pagination pagination-rounded justify-content-center mb-0">--}}
{{--                                        <li class="page-item disabled">--}}
{{--                                            <a class="page-link" href="#" aria-label="Previous">--}}
{{--                                                <i class="mdi mdi-chevron-left"></i>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                                        <li class="page-item active"><a class="page-link" href="#">2</a></li>--}}
{{--                                        <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                        <li class="page-item"><a class="page-link" href="#">4</a></li>--}}
{{--                                        <li class="page-item">--}}
{{--                                            <a class="page-link" href="#" aria-label="Next">--}}
{{--                                                <i class="mdi mdi-chevron-right"></i>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">تنظیمات</h5>

                                <div class="form-group">
                                    <a class="text-white" href="{{route('admin.users.create')}}">
                                    <button class="btn btn-info w-100 waves-effect waves-light">

                                            ایجاد کاربر جدید

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

    <!-- Sweet alert init js-->
{{--    <script src="{{asset('assets/js/pages/sweet-alerts.init.js')}}"></script>--}}
    <script>

        // function deleteItem(userId){
        //     console.log(userId)
        //     Swal.fire({title:"هشدار",
        //         text:"آیا از خذف این آیتم مطمعن هستید؟",
        //         icon:"warning",
        //         showCancelButton:!0,
        //         confirmButtonText:"بله، حذف کن!",
        //         cancelButtonText:"نه، بیخیال.",
        //         confirmButtonClass:"btn btn-success mt-2",
        //         cancelButtonClass:"btn btn-danger ml-2 mt-2",
        //         buttonsStyling:!1}
        //     ).then(function(t){
        //         console.log(t)
        //         if(t.value){
        //             Swal.fire({title:"Deleted!",text:"Your file has been deleted.",icon:"success"})
        //         }
        //     })
        // }

        // !function(t){
        //     "use strict";
        //     function e(){}
        //     e.prototype.init=function(){
        //         t("#sa-basic").on("click",function(){
        //             Swal.fire({title:"Any fool can use a computer",confirmButtonColor:"#3051d3"})}),
        //
        //         t("#sa-title").click(function(){
        //             Swal.fire({title:"The Internet?",text:"That thing is still around?",icon:"question",confirmButtonColor:"#3051d3"})}),t("#sa-success").click(function(){Swal.fire({title:"Good job!",text:"You clicked the button!",icon:"success",showCancelButton:!0,confirmButtonColor:"#3051d3",cancelButtonColor:"#f46a6a"})}),
        //             t("#sa-warning").click(function(){Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3ddc97",cancelButtonColor:"#f46a6a",confirmButtonText:"Yes, delete it!"}).then(function(t){t.value&&Swal.fire("Deleted!","Your file has been deleted.","success")})}),
        //             t("#sa-params").click(function(){
        //                 Swal.fire({title:"Are you sure?",
        //                 text:"You won't be able to revert this!",
        //                 icon:"warning",
        //                     showCancelButton:!0,
        //                     confirmButtonText:"Yes, delete it!",
        //                     cancelButtonText:"No, cancel!",
        //                     confirmButtonClass:"btn btn-success mt-2",
        //                     cancelButtonClass:"btn btn-danger ml-2 mt-2",
        //                     buttonsStyling:!1}
        //                     ).then(function(t){
        //                         t.value?
        //                             Swal.fire({title:"Deleted!",text:"Your file has been deleted.",icon:"success"})
        //                             :
        //                             t.dismiss===Swal.DismissReason.cancel&&Swal.fire(
        //                                 {title:"Cancelled",text:"Your imaginary file is safe :)",icon:"error"}
        //                                 )}
        //                                 )
        //             }),
        //             t("#sa-image").click(function(){Swal.fire({title:"Sweet!",text:"Modal with a custom image.",imageUrl:"assets/images/logo-dark.png",imageHeight:24,confirmButtonColor:"#3051d3",animation:!1})}),t("#sa-close").click(function(){var t;Swal.fire({title:"Auto close alert!",html:"I will close in <strong></strong> seconds.",timer:2e3,onBeforeOpen:function(){Swal.showLoading(),t=setInterval(function(){Swal.getContent().querySelector("strong").textContent=Swal.getTimerLeft()},100)},onClose:function(){clearInterval(t)}}).then(function(t){t.dismiss===Swal.DismissReason.timer&&console.log("I was closed by the timer")})}),
        //             t("#custom-html-alert").click(function(){Swal.fire({title:"<i>HTML</i> <u>example</u>",icon:"info",html:'You can use <b>bold text</b>, <a href="//themesdesign.in/">links</a> and other HTML tags',showCloseButton:!0,showCancelButton:!0,confirmButtonClass:"btn btn-success",cancelButtonClass:"btn btn-danger ml-1",confirmButtonColor:"#3ddc97",cancelButtonColor:"#f46a6a",confirmButtonText:'<i class="fas fa-thumbs-up mr-1"></i> Great!',cancelButtonText:'<i class="fas fa-thumbs-down"></i>'})}),
        //             t("#sa-position").click(function(){Swal.fire({position:"top-end",icon:"success",title:"Your work has been saved",showConfirmButton:!1,timer:1500})}),t("#custom-padding-width-alert").click(function(){Swal.fire({title:"Custom width, padding, background.",width:600,padding:100,confirmButtonColor:"#3051d3",background:"#fff url(//subtlepatterns2015.subtlepatterns.netdna-cdn.com/patterns/geometry.png)"})}),
        //             t("#ajax-alert").click(function(){Swal.fire({title:"Submit email to run ajax request",input:"email",showCancelButton:!0,confirmButtonText:"Submit",showLoaderOnConfirm:!0,confirmButtonColor:"#3051d3",cancelButtonColor:"#f46a6a",preConfirm:function(n){return new Promise(function(t,e){setTimeout(function(){"taken@example.com"===n?e("This email is already taken."):t()},2e3)})},allowOutsideClick:!1}).then(function(t){Swal.fire({icon:"success",title:"Ajax request finished!",html:"Submitted email: "+t})})}),
        //             t("#chaining-alert").click(function(){Swal.mixin({input:"text",confirmButtonText:"Next &rarr;",showCancelButton:!0,confirmButtonColor:"#3051d3",cancelButtonColor:"#74788d",progressSteps:["1","2","3"]}).queue([{title:"Question 1",text:"Chaining swal2 modals is easy"},"Question 2","Question 3"]).then(function(t){t.value&&Swal.fire({title:"All done!",html:"Your answers: <pre><code>"+JSON.stringify(t.value)+"</code></pre>",confirmButtonText:"Lovely!"})})}),
        //             t("#dynamic-alert").click(function(){swal.queue([{title:"Your public IP",confirmButtonColor:"#3051d3",confirmButtonText:"Show my public IP",text:"Your public IP will be received via AJAX request",showLoaderOnConfirm:!0,preConfirm:function(){return new Promise(function(e){t.get("https://api.ipify.org?format=json").done(function(t){swal.insertQueueStep(t.ip),e()})})}}]).catch(swal.noop)})},t.SweetAlert=new e,t.SweetAlert.Constructor=e}(window.jQuery),function(){"use strict";window.jQuery.SweetAlert.init()}();
        //
    </script>
@endsection
