@extends('layouts.adminTemplate')
@section('page-title','Product details')
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
                    <div class="user-profile">
                        @if($product->product_image!='')
                        <img src="{{ url('public/products/'.$product->product_image) }}" />
                        @else 
                        <img src="{{url('public/photos/user-dummy-image.png')}}" />
                        @endif
                    </div>
					<div class="text-right">
                    <a href="{{url('admin/product')}}"> <button type="button" class="btn btn-primary" style="margin: -20px 15px 0;">Back<div class="ripple-container"></div></button></a>
                    </div>
					
					
					<br><br>
                    <div class="card-content">
                        <ul class="nav nav-pills nav-pills-warning">
                            <li class="active">
                                <a href="#pill1" data-toggle="tab">Product Info</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Name</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{$product->product_name}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div> 
									
									<div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Title</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{$product->product_title}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div> 
									<div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Price</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{$product->product_price}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div> 
									<div class="col-md-6">
                                        <label class="col-md-4 label-on-right">Discount Price</label>
                                        <div class="col-md-8">
                                            <div class="form-group label-floating is-empty">
                                                <input type="text" class="form-control"  value="{{$product->product_dis_price}}" disabled="true">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="col-md-2 label-on-right">Description</label>
                                        <div class="col-md-10">
                                            <div class="form-group label-floating is-empty">
                                               <?php echo $product->product_description; ?>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
									
                                     <div class="col-md-12">
                                        <label class="col-md-2 label-on-right">Image</label>
                                        <div class="col-md-10">
                                            <div class="form-group label-floating is-empty">
                                                @if($product->product_image!='')
												<img src="{{ url('public/products/'.$product->product_image) }}" class="rimg" />
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