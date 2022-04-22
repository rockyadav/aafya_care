@extends('layouts.adminTemplate')
@section('page-title','Laboratory details')
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
                    <a href="{{url('admin/laboratory-users')}}"> <button type="button" class="btn btn-rose" style="margin: -20px 15px 0;">Back<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Laboratory User Details</h4>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Lab Name</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                              <input type="text" class="form-control"  value="{{$users->lab_name}}" disabled="true">
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
                                                <input type="text" class="form-control" value="{{$users->email}}" disabled="true">
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
                                                <input type="text" class="form-control"  value="{{$users->address}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Business Permit No.</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->business_permit_no =='' ? 'N/A': $users->business_permit_no }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">KRA Pin</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->kra_pin =='' ? 'N/A': $users->kra_pin }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">National Id</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->national_id =='' ? 'N/A': $users->national_id }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Test Process Name</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->test_process_name =='' ? 'N/A': $users->test_process_name }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Mpesa Till No</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->mpesa_till_no =='' ? 'N/A': $users->mpesa_till_no }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-md-6">
                                        <label class="col-md-5 label-on-right">Bank Name & Branch</label>
                                        <div class="col-md-7">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->bank_name_and_account =='' ? 'N/A': $users->bank_name_and_account }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    

                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Account Number</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->account_number =='' ? 'N/A': $users->account_number }}"
                                                 disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Is Verify</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->is_verify =='1' ? 'Verified': 'Not Verify' }}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div> 
                                    </div>
									
                                    <div class="col-md-12">
                                        <label class="col-md-2 label-on-right">Lab Equipments</label>
                                        <div class="col-md-10">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{ $users->lab_equipments =='' ? 'N/A': $users->lab_equipments }}"
                                                 disabled="true">
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