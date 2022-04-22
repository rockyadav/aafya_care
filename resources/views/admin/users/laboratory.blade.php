@extends('layouts.adminTemplate')

@section('page-title','laboratories')

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

                    <h4 class="card-title">Laboratory</h4>

                    <div class="toolbar"> 

                    </div>

                    <div class="material-datatables">
                        
                        <div class="table-responsive">
                        <table id="userdatatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Labe Name</th>
									<th>Contact</th>
                                    <th>City</th>
                                    <th>Business Pno.</th>
                                    <th>KRA PIN</th>
                                    <th>Date</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data['list'])>0)
                                @php($i=0)
                                @foreach($data['list'] as $row)
                                <tr>
                                <td>{{$row->lab_name}}</td>
                                <td>{{$row->mobile}}</td>
                                <td>{{$row->city_name}}</td>
                                <td>{{$row->business_permit_no}}</td>
								<td>{{$row->kra_pin}}</td>
                                <td>{{date('d-m-Y',strtotime($row->created_at))}}</td>
                                <td>
                                    <td class="center">
                            <a class="changeStatus" href="#" data-toggle="tooltip" title="Change Status" id="{{ $row->id }}" onclick="changeStatus({{ $row->id }})" >
                                 @if (($row->is_verify) == '1')
                                    <div class="btn btn-success btn-sm">Verified
                                    </div>
                                 @else
                                    <div class="btn btn-warning btn-sm" v-else>
                                        Verify
                                    </div> 
                                 @endif
                            </a> 
                        </td>
                                </td> 
                                <td class="td-actions">
								<a href="{{url('admin/laboratory-user-details/'.$row->id)}}">
                                    <button type="button" rel="tooltip" class="btn btn-rose btn-sm" data-original-title="Details" title=""><i class="material-icons">visibility</i><div class="ripple-container"></div></button>
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

function changeStatus(id){
    var id = id;
        swal({
        title: 'Are you sure?',
        text: "You will be able to revert this!!!",
        type: 'info',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Yes, Change it!',
        buttonsStyling: false
        }).then(function() {
                $.ajax({
                    url: '{{ url('/') }}' + '/admin/laboratoryVerify/' + id, 
                    method:"get",
                    success:function(data)
                    { 
                        var message = 'Your status has been changed.';
                        demo.showNotification('bottom','right','success', message );
                        
                        if ($('#'+id).find('.btn-success').length){
                            $('#'+id).find(".btn").text('Deactive');
                            $('#'+id).children().removeClass();
                            $('#'+id).children().addClass('btn btn-warning btn-sm');
                        } else {
                            $('#'+id).find(".btn").text('Active');
                            $('#'+id).children().removeClass();
                            $('#'+id).children().addClass('btn btn-success btn-sm');
                         }
                    },
                    error:function(er){
                        console.log(er); 
                    }
                });
        });
    };

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
                url: base_url+'/admin/laboratoryDestroy/'+id,
                method:"get", 
            success:function(data)
            {
                if(data=='success')
                {
                    var message = 'Details has been deleted successfully.';
                    demo.showNotification('bottom','right','success', message );
                    $('#userdatatables').load(document.URL +  ' #userdatatables');
                }else{
                    var message = 'Please try again';
                    demo.showNotification('bottom','right','danger', message );
                    $('#userdatatables').load(document.URL +  ' #userdatatables');
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