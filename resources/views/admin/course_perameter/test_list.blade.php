@extends('layouts.adminTemplate')

@section('page-title','Test perameters')

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

                    <h4 class="card-title">Test parameter</h4>

                    <div class="toolbar">

                    </div>

                    <div class="material-datatables">

                       <!--  <div class="add-more text-right">

                            <a class="btn btn-rose btn-fill" href="{{route('course-perameter.create')}}">Add<div class="ripple-container"></div></a>

                        </div> -->

                        <div class="table-responsive">

                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

                            <thead>

                                <tr>

                                     <th>Test Name</th>
                                     <th>Date</th>
                                     <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @if(count($data['list'])>0)

                                @php($i=0)

                                @foreach($data['list'] as $row)

                                <tr>
                                    <td>{{$row->course_name}}</td>
                                    <td>{{date('d-m-Y',strtotime($row->created_date))}}</td>

                                    <td class="td-actions">

									 

                                        <a href="{{url('admin/course-parameter-list/'.$row->id)}}"><button type="button" rel="tooltip" class="btn btn-success" title="View">
                                            <i class="material-icons">visibility</i>
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


</script>

@endsection