@extends('layouts.frontTemplate')
@section('content')
    <div class="container">
        <br/><br/><br/><br/>
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <div class="text-center">
                    <img src="{{ asset('img/Logo.png') }}" alt="Surfway" class="logo" style="width: 250px;">
                    <h1> {{ __('error.lblUnauthorizedAccess') }}</h1>
                    <br/>
                    <p>
                        {{ __('error.txtUnauthorizedText') }}
                    </p>
                    <a href="#" onclick="history.go(-1); return false;" class="btn btn-rose btn-round btn-lg">
                        {{ __('error.lblBackToPreviousPage') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection()