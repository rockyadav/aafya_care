@extends('layouts.adminTemplate')
@section('page-title', 'Profile Detail')
@section('content')
<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}

input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div class="content">
  @if ($message = Session::get('success') || $message = Session::get('error'))
  @include('layouts.error-sucess-messages')
  @endif
  <div class="container-fluid"> 
    <div class="row">
      <div class="col-md-12">
        <div class="card"> 
          <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">perm_identity</i> 
          </div>
          <div class="card-content">
            <h4 class="card-title">Profile Detail
            </h4>
            <br>
          
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="profile">
                <div class="row"> 
                  <div class="col-md-12 text-center">
                    @if($data['user']->image!='')
                    <img class="img" src="{{asset('assets/photos/'.$data['user']->image)}}" alt="profile-photo">
                    @endif
                  </div>
                </div>
                <div class="row"> 
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><b>Name</b></label>
                        <p>{{$data['user']->name}}</p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><b>Mobile</b></label>
                        <p>{{$data['user']->mobile}}</p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><b>Email</b></label>
                        <p>{{$data['user']->email}}</p>
                    </div>
                  </div>
                </div>
                <div class="row"> 
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><b>Address</b></label>
                        <p>{{$data['user']->address}}</p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><b>Area</b></label>
                        <p>{{$data['user']->area}}</p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label"><b>Pincode</b></label>
                        <p>{{$data['user']->pin_code}}</p>
                    </div>
                  </div>
                </div>
                <div class="row"> 
                  <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label"><b>About Me</b></label>
                        <p>{{$data['user']->about_me}}</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
</div>
</div>
@endsection