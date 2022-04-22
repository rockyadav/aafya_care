@extends('layouts.adminTemplate')

@section('page-title', 'Update city')

@section('content')



<div class="content">

@include('layouts.error-sucess-messages')

 <div class="container-fluid">

     <div class="row"> 

         <div class="col-md-12">

             <div class="card">

                    <div class="back-btn text-right">

                        <a class="btn btn-rose btn-fill" href="{{ url('admin/city')}}">Back<div class="ripple-container"></div></a>

                    </div>

                     {{ Form::model($city, ['route' => ['city.update', $city->id], 'method' => 'patch','files'=>true]) }}

                     {{ csrf_field() }}

                     <div class="card-content">

                        <div class="card-content">

                         <div class="row">  

                            <div class="col-md-12">
                                <label class="col-sm-2 label-on-left">City Name</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="name" placeholder="Enter name" required="" value="{{$city->name}}">
                                         @if ($errors->has('name'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                         </div>

                         <div class="row text-center">
                             <button class="btn btn-rose btn-fill" type="submit">Update</button>
                         </div>
                     </div>

                  {{Form::close()}}

             </div>

         </div> 

     </div>

 </div>

</div>



@endsection