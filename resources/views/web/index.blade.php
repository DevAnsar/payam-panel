@extends('web.master')

@section('content')

    <div id="download">
        <div id="first-sequence" class="container-fluid px-0"
             style="background-image: url({{asset("images/bgVector.svg")}})">
            <div class="container pt-4">
                <div class="row d-flex justify-content-center justify-content-md-start">
                    <div class="col-md-8">
                        <h1 class="text-white h2 text-center text-md-end">
                            ارسال لینک اینستاگرام به شماره مشتری
                        </h1>
                        <p class="text-white h4 mt-4 mb-2 text-center text-md-end">
                            با استفاده از اپ پیامکسازی به راحتی میتوانید
                            <br>
                            لینک های شبکه های اجتماعی خود را
                            <br>
                            به شماره مشتری خود ارسال کنید
                        </p>
                        <div class="row d-flex flex-column justify-content-between align-items-center flex-md-row justify-content-md-start mt-5">
                            <div class="col-6  col-md-4 col-lg-3 mb-3 ">
                                <a href="#">
                                    <img alt="download-bazar" class="w-100 app-download-link-img" src="{{asset("images/download-bazar.png")}}">
                                </a>
                            </div>
                            <div class="col-6  col-md-4 col-lg-3  mb-3">
                                <a href="#">
                                    <img alt="download-google-play"  class="w-100 app-download-link-img"   src="{{asset("images/download-google-play.png")}}">
                                </a>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3  mb-3">
                                <a href="#">
                                    <img alt="download-from-link"  class="w-100 app-download-link-img"   src="{{asset("images/download-from-link.png")}}">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-3 d-none d-md-block">
                        <img class="w-100 p-3 p-md-5" alt="" src="{{asset("images/mobile-vector.png")}}" >
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="attribute">
        <div class="row pt-5">
            <div class="col-12  d-flex justify-content-center d-md-none">
                <img class="w-75 p-3" alt="" src="{{asset("images/mobile-vector.png")}}" >
            </div>
            <div class="col-12  px-4 px-md-3 px-lg-4 pt-lg-3 px-xl-5  pt-xl-4">
                <h1 class="h4 text-dark">
                    ویژگی ها
                </h1>
            </div>
            <div class="col-6 col-md-3 mb-md-3 p-4 p-md-3  pt-md-1 p-lg-4 pt-lg-2 p-xl-5 pt-xl-2">
                <div class="attr-box d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon h-25" alt="">
                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content font-size-13">
                        ارسال سریع لینک های فضاهای مجازی شما به شماره تلفن مشتری
                    </p>
                </div>
            </div>
            <div class="col-6  col-md-3 mb-md-3  p-4 p-md-3 pt-md-1 p-lg-4 pt-lg-2  p-xl-5 pt-xl-2">
                <div class="attr-box d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon  h-25" alt="">
                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content text-justify">
                        ارسال سریع لینک های فضاهای مجازی شما به شماره تلفن مشتری
                    </p>
                </div>
            </div>
            <div class="col-6  col-md-3 mb-3  p-4 p-md-3 pt-md-1 p-lg-4 pt-lg-2 p-xl-5 pt-xl-2">
                <div class="attr-box d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon  h-25" alt="">
                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content text-justify">
                        ارسال سریع لینک های فضاهای مجازی شما به شماره تلفن مشتری
                    </p>
                </div>
            </div>
            <div class="col-6  col-md-3 mb-3  p-4 p-md-3 pt-md-1 p-lg-4 pt-lg-2 p-xl-5 pt-xl-2">
                <div class="attr-box d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon  h-25" alt="">
                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content text-justify">
                        ارسال سریع لینک های فضاهای مجازی شما به شماره تلفن مشتری
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="about-us">
        <div class="row pt-5">
            <div class="col-12  px-4 px-md-3 px-lg-4 pt-lg-3 px-xl-5  pt-xl-4">
                <h1 class="h4 text-dark">
                    درباره ما
                </h1>
                <p style="text-align: justify" class="">
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                </p>
            </div>
            <div class="col-6 col-md-3 mb-md-3 p-4 p-md-3  pt-md-1 p-lg-4 pt-lg-2 p-xl-5 pt-xl-2">
                <div class="user-box  d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon h-25" alt="">

                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content font-size-13">
                        انصار میرزایی
                        <br>
                        <span class="">
                        برنامه نویس وب
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-6  col-md-3 mb-md-3  p-4 p-md-3 pt-md-1 p-lg-4 pt-lg-2  p-xl-5 pt-xl-2">
                <div class="user-box d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon  h-25" alt="">
                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content font-size-13">
                        انصار میرزایی
                        <br>
                        <span class="">
                        برنامه نویس وب
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-6  col-md-3 mb-3  p-4 p-md-3 pt-md-1 p-lg-4 pt-lg-2 p-xl-5 pt-xl-2">
                <div class="user-box d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon  h-25" alt="">
                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content ">
                        انصار میرزایی
                        <br>
                        <span class="">
                        برنامه نویس وب
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-6  col-md-3 mb-3  p-4 p-md-3 pt-md-1 p-lg-4 pt-lg-2 p-xl-5 pt-xl-2">
                <div class="user-box d-flex flex-column justify-content-between align-items-center">
                    <img src="{{asset("images/socials/whatsapp.png")}}" class="attr-icon  h-25" alt="">
                    <p class="small text-dark p-2 pt-3 pb-0 p-md-3 pb-md-0 content ">
                        انصار میرزایی
                        <br>
                        <span class="">
                        برنامه نویس وب
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection