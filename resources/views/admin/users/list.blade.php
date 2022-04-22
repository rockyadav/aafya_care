@extends('layouts.adminTemplate')

@section('page-title','Customers')

@section('content')

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

                    <h4 class="card-title">Customer Request</h4>

                    <div class="toolbar"> 

                    </div>

                    <div class="material-datatables">
                        
                        <div class="table-responsive">
                        <table id="userdatatablesss" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
									<th>Contact</th>
                                    <th>City</th>
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
                                    <td>{{$row->name}}</td>
                                     <td>{{$row->mobile}}</td>
                                     <td>{{$row->city_name}}</td>
									<td>{{$row->course_name}}</td>
                                    <td>{{date('d-m-Y',strtotime($row->created_date))}}</td>
                                    <td>{{$row->status}}
                                    </td> 
									 <td>{{date('d-m-Y h:s:a',strtotime($row->created_date))}}</td>
                                    <td class="td-actions">
									 <a href="{{url('admin/user-details/'.$row->id)}}">
                                            <button type="button" rel="tooltip" class="btn btn-rose btn-sm" data-original-title="View" title="">
                                                <i class="material-icons">visibility</i>
                                            <div class="ripple-container"></div></button>
                                        </a>  
                                      
                                        <a href="javascript:void(0);" onclick="deleteData('{{$row->id}}');">
                                        <button type="button" title="Delete" rel="tooltip" class="btn btn-danger">
                                            <i class="material-icons">close</i>
                                        </button></a>
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
                        <div class="text-center">{{$data['list']->links()}}</div>
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