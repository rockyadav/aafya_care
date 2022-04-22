@extends('layouts.adminTemplate')

@section('page-title', 'Update event')

@section('content')



<div class="content">

<style type="text/css">

.rimg{ 

  height : 50px!important;

  width : 50px!important ;

}

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

                        <a class="btn btn-rose btn-fill" href="{{ url('event')}}">Back<div class="ripple-container"></div></a>

                    </div>

                     {{ Form::model($event, ['route' => ['event.update', $event->id], 'method' => 'patch','files'=>true]) }}

                     {{ csrf_field() }}

                     <div class="card-content">

                        <div class="card-content">

                         <div class="row">  
						 
						 
						 <div class="col-md-6">
                                <label class="col-sm-2 label-on-left">Title</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="title" placeholder="Enter title" required="" value="{{$event->title}}">
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
                                         <input type="text"  class="form-control datepicker" name="event_date" placeholder="Enter event date" required="" value="{{$event->event_date}}">
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
                                        <input type="file" name="image">
										 @if($event->image!='')
										 <br>
											<a href="{{url('public/events/'.$event->image)}}">
												<img src="{{url('public/events/'.$event->image)}}" style="width: 50px; margin-left: 50px;" alt="Image" title="Image"></a>
											@endif
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
                                         <textarea type="text"  class="form-control ckeditor" name="description" placeholder="Enter description" required="" >{{$event->description}}</textarea>
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