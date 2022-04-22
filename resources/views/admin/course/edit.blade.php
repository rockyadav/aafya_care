@extends('layouts.adminTemplate')

@section('page-title', 'Update Test')

@section('content')



<div class="content">

@include('layouts.error-sucess-messages')

 <div class="container-fluid">

     <div class="row"> 

         <div class="col-md-12">

             <div class="card">

                    <div class="back-btn text-right">

                        <a class="btn btn-rose btn-fill" href="{{ url('admin/course')}}">Back<div class="ripple-container"></div></a>

                    </div>

                     {{ Form::model($course, ['route' => ['course.update', $course->id], 'method' => 'patch','files'=>true]) }}

                     {{ csrf_field() }}

                     <div class="card-content">

                        <div class="card-content">

                         <div class="row">  

                            <div class="col-md-12">
                                <label class="col-sm-1 label-on-left">Name</label>
                                 <div class="col-sm-11">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="course_name" placeholder="Enter name" required="" value="{{$course->course_name}}">
                                         @if ($errors->has('course_name'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('course_name') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

							 <div class="col-md-6">
                                <label class="col-sm-2 label-on-left">Price</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="number" min="0" class="form-control" name="price" placeholder="Enter price" required="" value="{{$course->price}}">
                                         @if ($errors->has('price'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>
							
							 <div class="col-md-6">
                                <label class="col-sm-4 label-on-left">Discount Price</label>
                                 <div class="col-sm-8">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="number" min="0" class="form-control" name="dis_price" placeholder="Enter discount price" required="" value="{{$course->dis_price}}">
                                         @if ($errors->has('dis_price'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('dis_price') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                            <div class="col-md-12">
                                <label class="col-sm-2 label-on-left">Description</label>
                                 <div class="col-sm-10">
                                     <div class="label-floating is-empty">
                                        <label class="control-label"></label>
                                        <textarea type="text" name="description" class="form-control ckeditor">{{$course->description}}</textarea>
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