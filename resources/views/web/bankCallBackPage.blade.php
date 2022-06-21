@extends('web.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-8 my-5 py-5 " style="text-align: center">
                <app-redirect message="{{$message}}" type="{{$type}}" link="app://nafir_sms"></app-redirect>
            </div>
        </div>
    </div>
@endsection
