@extends('layouts.adminTemplate')
@section('page-title','Sample Collector details')
@section('content')

<style type="text/css">

    .manualrow{

        padding: 25px;

    }

    .rimg{ 

      height : 50px!important;

      width : 50px!important ;

    }



    .my-modal{

        width: 28%;

    }



    @media only screen and (max-width: 600px) {

      .my-modal{

            width: 90%;

        }

      img{

            height: 180px !important;

            width: 260px !important;

      }

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

                    <div class="text-right">
                    <a href="{{url('admin/sample-collectors')}}"> <button type="button" class="btn btn-rose" style="margin: -20px 15px 0;">Back<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Sample Collectors Details</h4>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label class="col-md-2 label-on-right">Image</label>
                                        <div class="col-md-10">
                                            @if($users->image!='')
                                           <img style="width:100px; height: 80px;" src="{{url('public/photos/'.$users->image)}}" alt="Image">
                                           @else
                                            <img style="width:100px; height: 80px;" src="{{url('public/photos/user-dummy-image.png')}}" alt="Image">
                                           @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Name</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                              <input type="text" class="form-control"  value="{{$users->name}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Contact No.</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control" value="{{$users->mobile}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Email</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                              <input type="text" class="form-control"  value="{{$users->email}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">City</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{$users->city_name}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Address</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->address =='' ? 'N/A': $users->address }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Reference Name</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->reference_name =='' ? 'N/A': $users->reference_name }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Reference Id No</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->reference_id_no =='' ? 'N/A': $users->reference_id_no }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Reference Phone</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->reference_phone =='' ? 'N/A': $users->reference_phone }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Gender</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->gender =='' ? 'N/A': $users->gender }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Status</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->status =='1' ? 'Active': 'Deactive'}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div> 
                                    </div>

                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Qualification</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->qualification =='' ? 'N/A': $users->qualification }}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Create Date</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->created_at =='' ? 'N/A': date('d-m-Y',strtotime($users->created_at)) }}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div> 
                                    </div>
                 
                        </div>

                    </div>

                </div>

                <!--  end card  -->

            </div>

            <!-- end col-md-12 -->

        </div>

        <!-- end row -->

    </div>

</div>
</div>

@endsection