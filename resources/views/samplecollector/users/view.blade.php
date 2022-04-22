@extends('layouts.sampleCollectorTemplate')

@section('page-title','Customer details')

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
                    <a href="{{url('admin/sample-collector-customers')}}"> <button type="button" class="btn btn-success" style="margin: -20px 15px 0;">Back<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Customer Details</h4>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                <div class="row">
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
                                        <label class="col-md-4 label-on-right">City</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{$users->city_name}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Test</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{$users->course_name}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Full Address</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->full_address =='' ? 'N/A': $users->full_address }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Address Pin </label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->address_pin =='' ? 'N/A': $users->address_pin }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Landmark</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->landmark =='' ? 'N/A': $users->landmark }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">DOB</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->dob =='' ? 'N/A': $users->dob }}"
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
                                        <label class="col-md-4 label-on-right">Blood Group</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->blood_group =='' ? 'N/A': $users->blood_group }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Any Treatment </label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->any_treatment =='' ? 'N/A': $users->any_treatment }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Visit Date</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->visit_date =='' ? 'N/A': date('d-m-Y',strtotime( $users->visit_date)) }}" 
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Visit Time</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->visit_time =='' ? 'N/A': $users->visit_time }}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Status</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->status =='' ? 'Pending': $users->status }}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Taken Date</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->sample_collect_date =='' ? 'Pending': $users->sample_collect_date }}" disabled="true">
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