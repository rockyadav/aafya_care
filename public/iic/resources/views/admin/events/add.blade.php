@extends('layouts.adminTemplate')

@section('page-title', 'Add Event')

@section('content')



<div class="content">

<style type="text/css">

   .fileinput img{

      width: 100px; height: 100px;

   }
   
   .label-on-left {
       padding-top: 15px !important;
   }

</style>

@include('layouts.error-sucess-messages')

 <div class="container-fluid">

     <div class="row"> 

         <div class="col-md-12">

             <div class="card">

                    <div class="back-btn text-right">

                        <a class="btn btn-rose btn-fill" href="{{ url('event') }}">Back<div class="ripple-container"></div></a>

                    </div>

                    {{ Form::open(array('url'=>route('event.store'), 'files'=>true)) }}

                     {{ csrf_field() }}

                     <div class="card-content">

                         <div class="row">
                            <div class="col-md-6">
                                <label class="col-sm-2 label-on-left">Title</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="title" placeholder="Enter title" required="" value="{{old('title')}}">
                                         @if ($errors->has('title'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                            <div class="col-md-6">
                                <label class="col-sm-3 label-on-left">Event Date</label>
                                 <div class="col-sm-9">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control datepicker" name="event_date" placeholder="Enter event date" required="" value="{{old('event_date')}}">
                                         @if ($errors->has('event_date'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('event_date') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                            <div class="col-md-6">
                                <label class="col-sm-2 label-on-left">Image</label>
                                 <div class="col-sm-10">
                                     <div class="label-floating is-empty">
                                        <label class="control-label"></label>
                                        <input type="file" name="image" style="padding:0px;">
                                         @if ($errors->has('image'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>


                             <div class="col-md-12">
                                <label class="col-sm-2 label-on-left">Description</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <textarea type="text"  class="form-control ckeditor" name="description" placeholder="Enter description" required="" >{{old('description')}}</textarea>
                                         @if ($errors->has('description'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('description') }}</strong>
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