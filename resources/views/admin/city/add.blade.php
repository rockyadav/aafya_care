@extends('layouts.adminTemplate')

@section('page-title', 'Add city')

@section('content')



<div class="content">

@include('layouts.error-sucess-messages')

 <div class="container-fluid">

     <div class="row"> 

         <div class="col-md-12">

             <div class="card">

                    <div class="back-btn text-right">

                        <a class="btn btn-rose btn-fill" href="{{ url('admin/city') }}">Back<div class="ripple-container"></div></a>

                    </div>

                    {{ Form::open(array('url'=>route('city.store'), 'files'=>true)) }}

                     {{ csrf_field() }}

                     <div class="card-content">

                         <div class="row">

                            <div class="col-md-12">
                                <label class="col-sm-2 label-on-left">City Name</label>
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



<script type="text/javascript">



$(document).ready(function(){



    

$('#manufacturer').change(function(){

    var manufacturer = $(this).val();

    if(manufacturer!=''){

        $.ajax({

           type:"GET",

           url:"{{url('admin/get-model-list')}}?manufacturer_id="+manufacturer,

           success:function(res){ 

            if(res){

                $("#model_id").empty();

                $('#model_id').selectpicker('refresh');

                $("#model_id").append('<option value=""> {{ trans('Choose model')}}</option>');

                $("#serial_number").empty();

                $('#serial_number').selectpicker('refresh');

                $("#serial_number").append('<option value=""> {{ trans('Choose model first')}}</option>');

                $.each(res,function(key,value){

                    $("#model_id").append('<option value="'+key+'">'+value+'</option>');

                });

                $('#model_id').selectpicker('refresh');

           

            }else{

               $("#model_id").empty();

               $("#model_id").append('<option value=""> {{ trans('Choose manufacturer first')}}</option>');

                $('#model_id').selectpicker('refresh');



              $("#serial_number").empty();

              $("#serial_number").append('<option value=""> {{ trans('Choose model first')}}</option>');

              $('#serial_number').selectpicker('refresh');

               

            }

           }

        });



    }else{



          $("#model_name").empty();

          $("#model_name").append('<option value=""> {{ trans('Choose manufacturer first')}}</option>');

          $('#model_name').selectpicker('refresh');



            $("#serial_number").empty();

          $("#serial_number").append('<option value=""> {{ trans('Choose model first')}}</option>');

          $('#serial_number').selectpicker('refresh');

    }      

   });





$('#model_id').change(function(){

    var model_id = $(this).val();

    if(model_id!=''){

        $.ajax({

           type:"GET",

           url:"{{url('admin/get-serial-number-list')}}?model_id="+model_id,

           success:function(res){ 

            if(res){

                $("#serial_number").empty();

                $('#serial_number').selectpicker('refresh');

                $("#serial_number").append('<option value=""> {{ trans('Choose serial number')}}</option>');

                $.each(res,function(key,value){

                    $("#serial_number").append('<option value="'+key+'">'+value+'</option>');

                });

                $('#serial_number').selectpicker('refresh');

           

            }else{

               $("#serial_number").empty();

               $("#serial_number").append('<option value=""> {{ trans('Choose model first')}}</option>');

                $('#serial_number').selectpicker('refresh');

               

            }

           }

        });



    }else{



          $("#model_name").empty();

          $("#model_name").append('<option value=""> {{ trans('Choose manufacturer first')}}</option>');

          $('#model_name').selectpicker('refresh');

    }      

   });





});

</script>





@endsection