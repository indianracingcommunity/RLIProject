@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    Login Using Discord
                    <br>
                    <a href="/login/discord" class="btn btn-dark"><img src={{url('/storage/img/discord2.png')}} alt="" style="width:30%;"></a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
