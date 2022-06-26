@extends('web.master')

@section('content')

    <div class="container" id="about-us">
        <div class="row pt-5">
            <div class="col-12  px-4 px-md-3 px-lg-4 pt-lg-3 px-xl-5  pt-xl-4">
                <h1 class="h4 text-dark fs-4">
                    ارتباط با ما
                </h1>
                <p style="text-align: justify" class="lh-lg fs-5">
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                </p>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-5 mx-auto my-4">
            <form class="needs-validation" novalidate="" method="post" action="{{route('web.contact-us.send')}}" >
                @csrf
                <div class="row g-3">

                    <div class="col-12">
                        <label for="firstName" class="form-label fs-5">
                            نام و نام خانوادگی
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="name" id="firstName" placeholder="" value="{{old("name")}}" required="">
                        @if($errors->has('name'))
                            <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label fs-5">
                            ایمیل
                            <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" name="email" value="{{old("email")}}" id="email" placeholder="you@example.com">
                        @if($errors->has('email'))
                            <div class="error text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label for="subject" class="form-label fs-5">
                            موضوع
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="" value="{{old("subject")}}" required="">
                        @if($errors->has('subject'))
                            <div class="error text-danger">{{ $errors->first('subject') }}</div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label for="content" class="form-label fs-5">
                            متن پیام
                            <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="content" rows="10" required="" name="content">{{old("content")}}</textarea>
                        @if($errors->has('content'))
                            <div class="error text-danger">{{ $errors->first('content') }}</div>
                        @endif
                    </div>

                </div>
                <button class="w-100 btn btn-primary btn-lg mt-4" type="submit">
                    ارسال پیام
                </button>
            </form>
            </div>
        </div>
    </div>
@endsection
