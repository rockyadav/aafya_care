@extends('layouts.adminTemplate')
@section('page-title', $data['detail']->title)
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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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
            <h4 class="card-title">{{$data['detail']->title}}
            </h4>
            <br>
            <form role="form" method="POST" action="{{ url('update-pages') }}">
              {{ csrf_field() }}
              <div class="row"> 
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label"><b>Title</b></label>
                    <input type="text" name="title" class="form-control" value="{{$data['detail']->title}}" required="">  
                  </div>
                </div>
                
                <div class="col-md-12" @if($data['titlehide']==1) style="display: none;" @endif>
                  <div class="form-group">
                    <label class="control-label"><b>Description</b></label>
                    <input type="hidden" name="rowId" value="{{ $data['detail']->id }}">
                    <textarea name="description" class="form-control ckeditor" style="border: 1px solid #d2d2d2;" rows="10">{{ $data['detail']->description }}</textarea>    
                  </div>
                </div>
              </div>  
              
			
              <center><button type="submit" class="btn btn-rose center-block">Update</button></center>
              <div class="clearfix"></div>
            </form>
          </div>
        </div> 
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>

@endsection