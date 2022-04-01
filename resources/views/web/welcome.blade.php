<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>پیامکسازی | payamaksazi</title>
        <link href="{{asset('css/web.css')}}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="app">

            <div class="vh-100 bg-white">
                <div id="first-sequence" class="container-fluid px-0 bg-white"
                     style="background-image: url({{asset("images/BackgroundVector.svg")}})">
                    <header id="header" class="container-fluid d-flex align-items-center">
                        <div class="container container-md ">
                            <div class="row d-flex align-items-center">
                                <div class="col-3 d-flex align-items-center">
                                    <img style="width: 36px"  alt="logo" src="{{asset("images/logo.png")}}">
                                    <span class="mx-2 h5">
                                    پیامکسازی
                                    </span>
                                </div>

                                <div class="col-9">
                                    <nav class="d-flex justify-content-end">
                                        <a class="mx-3 text-dark" href="#">
                                            <span>درباره ما</span>
                                        </a>
                                        <a class="mx-3 text-dark" href="#">
                                            <span>قوانین ما</span>
                                        </a>
                                        <a class="mx-3 text-dark" href="#">
                                            <span>ارتباط با ما</span>
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="container mt-4">
                        <div class="row d-flex justify-content-center justify-content-md-start">
                            <div class="col-md-8">
                                <h1 class="text-black h2">
                                   ارسال لینک اینستاگرام به شماره مشتری
                                </h1>
                                <p class="text-black h4 mt-4 mb-2">
                                    با استفاده از اپ پیامکسازی به راحتی میتوانید
                                    <br>
                                    لینک های شبکه های اجتماعی خود را
                                    <br>
                                    به شماره مشتری خود ارسال کنید
                                </p>
                                <div class="row d-flex justify-content-center justify-content-md-start mt-5">
                                    <div class="col-7 col-md-4 col-lg-3 mb-3">
                                        <a href="#">
                                            <img alt="download-bazar" class="w-100 app-download-link-img" src="{{asset("images/download-bazar.png")}}">
                                        </a>
                                    </div>
                                    <div class="col-7 col-md-4 col-lg-3  mb-3">
                                        <a href="#">
                                            <img alt="download-google-play"  class="w-100 app-download-link-img"   src="{{asset("images/download-google-play.png")}}">
                                        </a>
                                    </div>
                                    <div class="col-7 col-md-4 col-lg-3  mb-3">
                                        <a href="#">
                                            <img alt="download-from-link"  class="w-100 app-download-link-img"   src="{{asset("images/download-from-link.png")}}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 col-md-4 col-lg-3">
                                <img class="w-100 p-3" alt="" src="{{asset("images/mobile-vector.png")}}" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-9">dd</div>
                    <div class="col-md-3">ff</div>
                </div>
            </div>

        </div>

        <!-- JAVASCRIPT -->
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
