@extends('layouts.sampleCollectorTemplate')

@section('page-title','Customers')

@section('content')

<div class="content">

<div class="container-fluid">
    <div class="row">
     @include('layouts.error-sucess-messages')

        <div class="col-md-12">

            <div class="card">

                <div class="card-header card-header-icon" data-background-color="green">

                    <i class="material-icons">account_circle</i>
 
                </div>

                <div class="card-content">

                    <h4 class="card-title">Customer Request</h4>

                    <div class="toolbar"> 

                    </div>

                    <div class="material-datatables">
                        <div class="add-more text-right">

                            <a class="btn btn-success btn-fill" href="#" data-toggle="modal" data-target="#myModal">Take Sample<div class="ripple-container"></div></a>

                            <a class="btn btn-success btn-fill" href="#" data-toggle="modal" data-target="#resendModal">Resend Unique Code<div class="ripple-container"></div></a>

                        </div>
                        
                        <div class="table-responsive">
                        <table id="userdatatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Reg No.</th>
                                    <th>Name</th>
									<th>Contact</th>
									<th>Test</th>
                                    <th>Date</th>
                                    <th>status</th>
									<th>Due On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data['list'])>0)
                                @php($i=0)
                                @foreach($data['list'] as $row)
                                <tr>
                                    <td>{{$row->registration_no}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->mobile}}</td>
									<td>{{$row->course_name}}</td>
                                    <td>{{date('d-m-Y',strtotime($row->created_date))}}</td>
                                    <td>{{$row->status}}
                                    </td> 
									 <td>{{date('d-m-Y h:s:a',strtotime($row->created_date))}}</td>
                                    <td class="td-actions">
                                        @if($row->status!="Report Generated" && $row->status!="Submitted in Lab")
                                         <a href="javascript:void(0)" onclick="changeStatus('{{$row->id}}')">
                                            <button type="button" rel="tooltip" class="btn btn-success btn-sm" data-original-title="Sample status" title="">
                                                <i class="material-icons">commute</i>
                                            <div class="ripple-container"></div></button>
                                        </a>
                                        @endif

									 <a href="{{url('admin/sample-collector-customer-details/'.$row->id)}}">
                                            <button type="button" rel="tooltip" class="btn btn-success btn-sm" data-original-title="View" title="">
                                                <i class="material-icons">visibility</i>
                                            <div class="ripple-container"></div></button>
                                        </a> 
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
                <!-- end content-->
            </div>
        </div>
    </div>
</div>
</div>


 <!-- Resend modal -->
<div id="changeStatusModal" class="modal model-wide fade" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <i class="material-icons">group_add</i>
               Take Sample
               </h4>
            </div>
            <div class="modal-body">
           <form method="post" class="take-sample-formsss" action="{{url('admin/takeSampleCustomer')}}" class="form-horizontal" accept-charset="UTF-8" role="form" enctype="multipart/form-data">  
            {{ csrf_field() }}    
              <input type="hidden" name="user_id" id="to_user" value="" required>      
                     <div class="">
                    <div class="card-content row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group label-floating">
                    <label class="label-control">Status</label>
                    <select class=" form-group selectpicker" data-style="select-with-transition" title="Choose course" data-size="7" name="sample_status" id="sample_status" data-live-search="true" required="true" tabindex="-98">
                       <option value="" disabled="">Choose teacher </option>
                        <option value="Sample Taken">Sample Taken</option>
                        <option value="Refused">Refused</option>
                        <option value="Locked">Locked</option>
                        <option value="Not Available">Not Available</option>
                     </select>


                        </div>
                    </div>


                        </div>
                    </div>
               
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit_collect" name="submit" class="btn btn-success add" value="submit">Submit</button>
                 </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                   Close
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Resend modal -->

<div id="resendModal" class="modal model-wide fade" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <i class="material-icons">group_add</i>
               Resend Unique Code
               </h4>
            </div>
            <div class="modal-body">
                
    <form method="post" id="resend-code-form" action="{{ url('admin/takeSampleCustomer')}}" class="form-horizontal" accept-charset="UTF-8" role="form" enctype="multipart/form-data">  
            {{ csrf_field() }}          
                     <div class="">
                        <div class="card-content row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                           <div class="form-group label-floating">
                                <label class="label-control">Registerd Mobile No.</label>
                                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required >
                                 @if ($errors->has('mobile'))
                                    <span class="error-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                            </div> 
                        </div>
                            
                        </div>
                    </div>
               
            </div>
            <div class="modal-footer">
                <button type="submit" id="resend" name="submit" class="btn btn-success add" value="submit">Resend</button>
                 </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                   Close
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function changeStatus(userid,rowid)
    { 
        $('#to_user').val(userid);
        
        $('#changeStatusModal').modal({
            show: 'false'
        }); 
    
    }

$(document).ready(function(){
    
    $('.take-sample-form').on('submit',function(e){
        e.preventDefault();
        
        var url = $(this).attr('action'),
            post = $(this).attr('method'),
            data = new FormData(this);

            $.ajax({
                url: url,
                method: post,
                data: data,
                success: function(data){
                       console.log(data);
                    var message = data.msg;
                    if(data.status==1)
                    {
                        sweetAlert(message);
                        /* jQuery('#myModal').modal('hide');
                         $(".take-sample-form")[0].reset();*/
                         
                    }else{
                       sweetAlert(message);
                       
                    }
                },
                error: function(xhr, status, error){
                    alert(xhr.responseText);
                },
                processData: false,
                contentType: false
            });
        });
    }); 

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
                url: base_url+'/admin/user_destroy/'+id,
                method:"get", 
            success:function(data)
            {
                if(data=='success')
                {
                    var message = 'Customer request has been deleted successfully.';
                    demo.showNotification('bottom','right','success', message );
                    $('#userdatatablesss').load(document.URL +  ' #userdatatablesss');
                }else{
                    var message = 'Please try again';
                    demo.showNotification('bottom','right','danger', message );
                    $('#userdatatablesss').load(document.URL +  ' #userdatatablesss');
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