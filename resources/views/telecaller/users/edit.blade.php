@extends('layouts.telecallerTemplate')
@section('page-title', 'Update Customer')
@section('content')

<div class="content">
<style type="text/css">
   .fileinput img{
      width: 100px; height: 100px;
   }
   .error-block{
    color: red;
   }
</style>
  @if ($message = Session::get('success') || $message = Session::get('error'))
  @include('layouts.error-sucess-messages')
  @endif
 <div class="container-fluid">
     <div class="row"> 
         <div class="col-md-12">
             <div class="card">
                    <div class="back-btn text-right">
                        <a class="btn btn-success btn-fill" href="{{ url('admin/telecaller-customers') }}">Back<div class="ripple-container"></div></a>
                    </div>

               <form method="post" action="{{url('admin/telecaller_customer_edit_action')}}" accept-charset="UTF-8" role="form" enctype="multipart/form-data">
                       {{ csrf_field() }}
                     <div class="card-content">
                         <div class="row">
						  <input type="hidden" name="user_id" required="" value="{{$user->id}}">
                          <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Name</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text" class="form-control" name="name" placeholder="Enter name" required="" value="{{$user->name}}">
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
                                         <input type="number" class="form-control" name="mobile" placeholder="Enter mobile no." required="" value="{{$user->mobile}}">
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
                                         <input type="email"  class="form-control" name="email" placeholder="Enter email"  value="{{$user->email}}">
                                         @if ($errors->has('email'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>
                           
							 <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Test</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                        <select class="selectpicker " data-style="select-with-transition" title="Choose Test" data-size="7" name="test_id" id="course" data-live-search="true" required="true">
                                             <option value="" >Choose Test </option>
                                             @foreach($courses as $row)
                                             <option value="{{$row->id}}" @if($row->id==$user->test_id) selected @endif >{{$row->course_name}}</option>
                                            @endforeach
                                            </select>
                                         @if ($errors->has('test_id'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('test_id') }}</strong>
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
                                        <select class="selectpicker " data-style="select-with-transition" title="Choose City" data-size="7" name="city" id="City" data-live-search="true" required="true">
                                             <option value="" >Choose City </option>
                                             @foreach($city as $row)
                                             <option value="{{$row->id}}" @if($row->id==$user->city) selected @endif >{{$row->name}}</option>
                                            @endforeach
                                            </select>
                                         @if ($errors->has('city'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                            
                             <div class="col-md-6">
                                <label class="col-sm-4 label-on-left">ID/Passport No</label>
                                 <div class="col-sm-8">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="text" class="form-control" name="id_passport_no" placeholder="Enter id/passport no" value="{{$user->id_passport_no}}">
                                            @if ($errors->has('id_passport_no'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('id_passport_no') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							<div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Gender</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                        <select class="selectpicker " data-style="select-with-transition" title="Choose gender" data-size="7" name="gender" id="gender" data-live-search="true" required="true">
                                             <option value="" >Choose gender </option>
                                             <option value="Male" @if($user->gender=="Male") selected @endif >Male</option>
											 <option value="Female" @if($user->gender=="Female") selected @endif >Female</option>
                                            </select>
                                         @if ($errors->has('gender'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                            <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Full Address</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="text" class="form-control" name="full_address" placeholder="Enter full address" value="{{$user->full_address}}">
                                            @if ($errors->has('full_address'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('full_address') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							 <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Address Pin</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="text" class="form-control" name="address_pin" placeholder="Enter full address pin" value="{{$user->address_pin}}">
                                            @if ($errors->has('address_pin'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('address_pin') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							 <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Landmark</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="text" class="form-control" name="landmark" placeholder="Enter landmark" value="{{$user->landmark}}">
                                            @if ($errors->has('landmark'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('landmark') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							 <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">DOB</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="date" class="form-control" name="dob" placeholder="Enter dob" value="{{$user->dob}}">
                                            @if ($errors->has('dob'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							<div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Blood Group</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="text" class="form-control" name="blood_group" placeholder="Enter blood group" value="{{$user->blood_group}}">
                                            @if ($errors->has('blood_group'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('blood_group') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							 <div class="col-md-6">
                                <label class="col-sm-4 label-on-left">Any Treatment</label>
                                 <div class="col-sm-8">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="text" class="form-control" name="any_treatment" placeholder="Enter any_treatment" value="{{$user->any_treatment}}">
                                            @if ($errors->has('any_treatment'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('any_treatment') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							 <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Visit Date</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                            <input type="date" class="form-control" name="visit_date" placeholder="Enter visit date" value="{{$user->visit_date}}">
                                            @if ($errors->has('visit_date'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('visit_date') }}</strong>
                                            </span>
                                         @endif

                                     </div>
                                 </div>
                            </div>
							
							 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Visit Time</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="time" class="form-control"  value="{{ $user->visit_time =='' ? 'N/A': $user->visit_time }}" name="visit_time">
                                                @if ($errors->has('visit_time'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('visit_time') }}</strong>
                                            </span>
                                         @endif
                                            </div>
                                        </div> 
                                    </div>

                         </div>
                         <div class="row text-center">
                             <button class="btn btn-success btn-fill" type="submit">Update</button>
                         </div>
                         
                     </div>
                </form>
             </div>
         </div> 
     </div>
 </div>
</div>
@endsection