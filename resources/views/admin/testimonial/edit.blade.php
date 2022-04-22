@extends('layouts.adminTemplate')

@section('page-title', 'Update testimoninal')

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

</style>

@include('layouts.error-sucess-messages')

 <div class="container-fluid">

     <div class="row"> 

         <div class="col-md-12">

             <div class="card">

                    <div class="back-btn text-right">

                        <a class="btn btn-rose btn-fill" href="{{ url('admin/testimonial')}}">Back<div class="ripple-container"></div></a>

                    </div>

                     {{ Form::model($testimonial, ['route' => ['testimonial.update', $testimonial->id], 'method' => 'patch','files'=>true]) }}

                     {{ csrf_field() }}

                     <div class="card-content">

                        <div class="card-content">

                         <div class="row">  

                            <div class="col-md-6">
                                <label class="col-sm-2 label-on-left">Title</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="title" placeholder="Enter title" required="" value="{{$testimonial->title}}">
                                         @if ($errors->has('title'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('title') }}</strong>
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
                                         @if ($errors->has('image'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                         @endif
										 <br>
										 <img style="width:100px; height: 80px" src="{{url('public/testimonial/'.$testimonial->image)}}" alt="Image">
                                     </div>
                                 </div>
                            </div>

                             <div class="col-md-12">
                                <label class="col-sm-2 label-on-left">Description</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="description" placeholder="Enter Description" required="" value="{{$testimonial->description}}">
                                         @if ($errors->has('image'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('image') }}</strong>
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