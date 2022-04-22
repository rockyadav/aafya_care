@extends('layouts.adminTemplate')
@section('page-title', 'Add User')
@section('content')

<div class="content">
<style type="text/css">
   .fileinput img{
      width: 100px; height: 100px;
   }
</style>

 <div class="container-fluid">
     <div class="row"> 
         <div class="col-md-12">
             <div class="card">
                    <div class="back-btn text-right">
                        <a class="btn btn-rose btn-fill" href="{{ url('admin/users') }}">Back<div class="ripple-container"></div></a>
                    </div>
                    {{ Form::open(array('url'=>url('admin/add_user_action'), 'files'=>true)) }}
                     {{ csrf_field() }}
                     <div class="card-content">
                         <div class="row">
							<div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Name</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text" class="form-control" name="name" placeholder="Enter full name" required="" value="{{old('name')}}">
                                          @if ($errors->has('name'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                            <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Mobile</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="number" class="form-control" name="mobile" placeholder="Enter mobile no." required="" value="{{old('mobile')}}">
                                         @if ($errors->has('mobile'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>
							
                            <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Email</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="email"  class="form-control" name="email" placeholder="Enter email" required="" value="{{old('email')}}">
                                         @if ($errors->has('email'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>
							
                          <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Password</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="password"  class="form-control" name="password" placeholder="Enter password (min 6 digit)" value="{{old('password')}}" required="">
                                        @if ($errors->has('password'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>

                              <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">City</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="city" placeholder="Enter city" required="" value="{{old('city')}}">
                                         @if ($errors->has('city'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>
                         </div>
                         <div class="row text-center">
                             <button class="btn btn-rose btn-fill" type="submit">Save</button>
                         </div>
                         
                     </div>
                  {{Form::close()}}
             </div>
         </div> 
     </div>
 </div>
</div>
@endsection