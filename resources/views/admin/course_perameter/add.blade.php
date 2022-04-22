@extends('layouts.adminTemplate')
@section('page-title', 'Add test parameter')
@section('content')

<div class="content">
@include('layouts.error-sucess-messages')
 <div class="container-fluid">
     <div class="row"> 
         <div class="col-md-12">
             <div class="card">
                    <div class="back-btn text-right">
                        <a class="btn btn-rose btn-fill" href="{{ url('admin/course-parameter-list/'.$test_id) }}">Back<div class="ripple-container"></div></a>
                    </div>
                    {{ Form::open(array('url'=>route('course-perameter.store'), 'files'=>true)) }}
                     {{ csrf_field() }}
                     <div class="card-content">
                         <div class="row">


                             <div class="col-md-12">
                                <label class="col-sm-2 label-on-left">Perameter Name</label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text"  class="form-control" name="name" placeholder="Enter name" required="" value="{{old('name')}}">
                                         @if ($errors->has('name'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('name') }}</strong>
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
                                        <select class="selectpicker " data-style="select-with-transition" title="Choose Test" data-size="7" name="course" id="course_id" data-live-search="true" required="true">
                                             <option value="" >Choose Test </option>
                                             @foreach($courses as $row)
                                             <option value="{{$row->id}}" >{{$row->course_name}}</option>
                                            @endforeach
                                            </select>
                                         @if ($errors->has('course'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('course') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                             <div class="col-md-6">
                                <label class="col-sm-4 label-on-left">Perameter Order</label>
                                 <div class="col-sm-8">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="number" min="1"  class="form-control" name="parameter_order" placeholder="Enter parameter order" required="" >
                                         @if ($errors->has('parameter_order'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('parameter_order') }}</strong>
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