@extends('layouts.adminTemplate')
@section('page-title', 'Settings')
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
            <h4 class="card-title">Settings
            </h4>
            <br>
            <form role="form" method="POST" action="{{ url('update-settings') }}">
              {{ csrf_field() }}
              <div class="row"> 
              @if(count($result)>0) 
                 @php
                  $numberField = [1,2,3];
                 @endphp
                @foreach($result as $row)
                <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label"><b>{{$row->title}}</b></label>
                    <input type="hidden" name="rowId[]" value="{{ $row->id }}">
                    @if(in_array($row->id,$numberField))
                    <input type="number" name="description[]" class="form-control" value="{{$row->description}}">
                    @else
                     <textarea name="description[]" class="form-control" style="border: 1px solid #d2d2d2;" rows="4">{{ $row->description }}</textarea> 
                    @endif
                                      
                  </div>
                </div>
                @endforeach
               @endif
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
@endsection