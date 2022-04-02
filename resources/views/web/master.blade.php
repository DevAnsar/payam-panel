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
    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
</div>
<!-- JAVASCRIPT -->
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
