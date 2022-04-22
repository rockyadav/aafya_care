@extends('layouts.adminTemplate')
@section('page-title', 'Website Image')
@section('content') 

<style type="text/css">
.form-group input[type=file] {
    opacity: 1 !important;
    position: relative !important;
}
td {
    padding: 5px;
}
</style>
<div class="content">
<div class="container-fluid">

<div class="row">
 @include('layouts.error-sucess-messages')
<div class="col-md-12">
<div class="card">
    <div class="card-header card-header-icon" data-background-color="">
        <i class="material-icons">assignment</i>
    </div>    
    <div class="card-content">
        <h4 class="card-title">Image Upload</h4>
        <div class="row">
          <div class="col-md-12 text-center">
            <form method="post" action="{{url('upload-image')}}" enctype="multipart/form-data">
              {{csrf_field()}}
                <div class="col-md-offset-4 col-md-4" style="border: 1px solid; padding-top: 27px; margin-bottom: 10px;">
                    <div class="form-group">
                      <label class="form-control">Login Image (500*550, Format :png)</label>
                      <input type="file" name="login" class="form-control">
                    </div>
                    <!-- <div class="form-group">
                      <label class="form-control">Photo Of The Day (1370*500, Format :jpg,jpeg)</label>
                      <input type="file" name="background" class="form-control">
                    </div> -->
                    <div class="form-group">
                      <button type="submit" class="btn btn-sm">Submit</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <table border="1">
              <tr>
              <td>
                  <label>Login Image</label>
              </td>
              <td>
              <img src="{{url('public/front-assets/img/login-signup.jpg?t='.time())}}" style="width: 300px;height: 350px;" >
              </td>
              </tr>
              <!-- <tr>
              <td>
              <label>Photo Of The Day</label>
              </td>
              <td>
              <img src="{{url('public/front-assets/img/home-banner.jpg?t='.time())}}" style="width: 900px;height: 350px;">
              </td>
              </tr> -->
            </table>
          </div>
        </div>
    </div>
    <!-- end content-->
</div>
<!--  end card  -->
</div>
<!-- end col-md-12 -->
</div>
<!-- end row -->
</div>
</div>
@endsection
