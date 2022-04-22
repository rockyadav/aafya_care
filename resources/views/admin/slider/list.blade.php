@extends('layouts.adminTemplate')

@section('page-title','Slider')

@section('content')

<style>

.rimg{ 

  height : 50px!important;

  width : 50px!important ;

}

</style>

<div class="content">

@include('layouts.error-sucess-messages')

<div class="container-fluid">

    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header card-header-icon" data-background-color="green">

                    <i class="material-icons">account_circle</i>

                </div>

                <div class="card-content">

                    <h4 class="card-title">Slider</h4>

                    <div class="toolbar">

                    </div>

                    <div class="material-datatables">

                      <!--   <div class="add-more text-right">

                            <a class="btn btn-rose btn-fill" href="{{route('slider.create')}}">Add<div class="ripple-container"></div></a>

                        </div> -->

                        <div class="table-responsive">

                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

                            <thead>

                                <tr>

								<th>Slider Image</th>
								<th>Title</th>
								<th>Description</th>
								<th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @if(count($sliderList)>0)

                                @foreach($sliderList as $cl)

                               <tr>
									 <td>
										@if($cl->slider_image!='')
										 <img style="width:150px;" src="{{ url('public/sliders/'.$cl->slider_image) }}" alt="Image">
										@else
										 <img style="width:150px;" src="{{ URL::asset('public/sliders/placeholder.png') }}" alt="Image">
										 @endif

									 </td>
									<td>{{$cl->title}}</td>
									<td>
										{{$cl->description}}
											
									</td>
									<td class="td-actions text-right">
										<a href="{{url('admin/slider/edit/'.$cl->id)}}"><button type="button" rel="tooltip" class="btn btn-success">
                                            <i class="material-icons">edit</i>
                                        </button></a>
										
										<!-- <a href="javascript:void(0);" onclick="deleteData('{{$cl->id}}');">
                                        <button type="button" rel="tooltip" class="btn btn-danger">
                                            <i class="material-icons">close</i>
                                        </button></a> -->
									 
									</td>
								</tr>

                                @endforeach

								@else

								 <tr>

                                    <td colspan="9">

									   <h4 style="color:red;"><b>Result not found.</b> </h4>

									</td>

								</tr>

                              

                                @endif

                            </tbody>

                        </table>

                        </div>

                    </div>

                </div>

                <!-- end content-->

            </div>

        </div>

    </div>

</div>

</div>







<script type="text/javascript">





function deleteData(id)

{

    swal({

    title: 'Are you sure?',

    text: "You want to delete this!",

    type: 'warning',

    showCancelButton: true,

    confirmButtonClass: 'btn btn-success',

    cancelButtonClass: 'btn btn-danger',

    confirmButtonText: 'Yes',

    buttonsStyling: false

    }).then(function() {

        $.ajax({

                url: base_url+'/admin/slider-destroy/'+id,

                method:"get",

            success:function(data)

            {

                

                if(data=='success')

                {

                    var message = 'Details has been deleted successfully.';

                    demo.showNotification('bottom','right','success', message );

                    $('#datatables').load(document.URL +  ' #datatables');

                }else{

                     alert('Please try again....');

                }                    

            },

            error:function(er){

                console.log(er); 

            }

        });           

    });

}

</script>

@endsection