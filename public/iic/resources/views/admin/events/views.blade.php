@extends('layouts.adminTemplate')
@section('page-title','Manual details')
@section('content')

<style type="text/css">


.rimg{ 
  height : 120px!important;
  width  : 200px!important ;
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
                    <a href="{{url('admin/manual')}}"> <button type="button" class="btn btn-rose" style="margin: -20px 15px 0;">Back<div class="ripple-container"></div></button></a>
                    </div>
                    <div class="card-content">
                        <ul class="nav nav-pills nav-pills-warning">
                            <li class="active">
                                <a href="#pill1" data-toggle="tab">Manual Info</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Title</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                {{$manual->manual_title}}
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div> 
									
									<div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Category</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                {{$manual->service_name}}
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div> 
									<div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Manufacturer</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                {{$manual->manufacturer_name}}
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div> 
									<div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Model</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                {{$manual->model_name}}
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Serial-no</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                               {{$manual->serial_number}}
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Status</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                               @if($manual->status==1)  Active @else Deactive @endif
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Date</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                               {{date('d-m-Y',strtotime($manual->created_date))}}
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-md-12">
                                        <label class="col-md-2 label-on-right">Description</label>
                                        <div class="col-md-10">
                                            <div class="form-group label-floating is-empty">
                                               {{$manual->manual_description}}
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Manual File</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                @if($manual->manual_file!='')
												<a href="{{url('public/manual_files/'.$manual->manual_file)}}" target="_new"><img src="{{url('public/icons/pdf.png')}}" class="rimg"></a>
												@else 
												<img src="{{url('public/photos/user-dummy-image.png')}}" class="rimg"  />
												@endif
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Manual Image</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                @if($manual->manual_image!='')
                                                <img src="{{ url('public/manual_images/'.$manual->manual_image) }}" class="rimg" />
                                                @else 
                                                <img src="{{url('public/photos/user-dummy-image.png')}}" class="rimg"  />
                                                @endif
                                            </div>
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
@endsection