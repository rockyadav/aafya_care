@extends('layouts.laboratoryTemplate')
@section('page-title', 'Generate Report')
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
                    <a class="btn btn-success btn-fill" href="{{ url('admin/laboratory-customers') }}">Back<div class="ripple-container"></div></a>
                </div>
             {{ Form::open(array('url'=>url('admin/generateReportAction'), 'files'=>true,'id'=>'reportForm')) }}
                  {{ csrf_field() }}
               <div class="card-content">
					     <input type="hidden" name="user_id" required="" value="{{$user->id}}">
                <input type="hidden" name="test_id" required="" value="{{$user->test_id}}">

              

               @if($report=='')
                 @if(count($test)>0)
                    @foreach($test as $row)
                     <div class="row">
                          <div class="col-md-12">
                                <label class="col-sm-2 label-on-left"><b>{{$row->name}}</b></label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text" class="form-control" name="values[{{$row->id}}]" placeholder="Enter value" required="" value="{{old('values')}}">
                                     </div>
                                 </div>
                            </div>
                        </div>
                            @endforeach
                       @endif

                   @else

                   @php 
                      $rarray = array();
                      $rarray =json_decode($report->p_values);

                     @endphp

                 @foreach ($rarray as $key => $value)
              
                     @php 
                      $valname = Helper::getTableRow('course_perameters',array('id'=>$key));
                     @endphp
                     <div class="row">
                      @if($valname->name=='SARS-COV-2')
                          <div class="col-md-12">
                                <label class="col-sm-2 label-on-left"><b>{{$valname->name}}</b></label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                           <select class="selectpicker " data-style="select-with-transition" title="Choose {{$valname->name}}" data-size="7" name="values[{{$key}}]" required="true">
                                             <option value="Detected" >Detected</option>
                                             <option value="Not Detected" >Not Detected</option>
                                            </select>
                                     </div>
                                 </div>
                            </div>
                            @else

                              <div class="col-md-12">
                                <label class="col-sm-2 label-on-left"><b>{{$valname->name}}</b></label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text" class="form-control" name="values[{{$key}}]" placeholder="Enter value" required="" value="{{$value}}">
                                     </div>
                                 </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                   @endif


                   <div class="row">
                          <div class="col-md-12">
                                <label class="col-sm-2 label-on-left"><b>Reviewed By</b></label>
                                 <div class="col-sm-10">
                                     <div class="form-group label-floating is-empty">
                                         <label class="control-label"></label>
                                         <input type="text" class="form-control" name="reviewed_by" placeholder="Enter reviewed by" required="" value="@if($report==''){{old('reviewed_by')}}@else{{$report->reviewed_by}}@endif">
                                     </div>
                                 </div>
                            </div>
                        </div>

                     <div class="row text-center">
                         <button class="btn btn-success btn-fill" type="submit" onclick="return confirm('Are you sure you want to Save?')">Submit</button>
                     @if($report!='')
                        <a href="{{url('admin/laboratory-preview-report/'.base64_encode($report->id))}}" target="_new">
                          <button class="btn btn-primary btn-fill" type="button">Preview</button>
                          </a>
                       @endif
                     </div>
                         
                     </div>
                  {{Form::close()}}
             </div>
         </div> 
     </div>
 </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){ 

  function sendPenddingPayment()
  { 
  
   swal({
        title: 'Are you sure?',
        text: "Are you sure you want to send pending profile mail?",
        type: 'info',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Yes!,change it to Yes',
        buttonsStyling: false
        }).then(function() {
      
           return true;
    
    });
  }


  });
</script>
@endsection