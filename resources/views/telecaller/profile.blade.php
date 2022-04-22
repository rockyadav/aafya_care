@extends('layouts.telecallerTemplate')

@section('page-title','Update Profile')

@section('content')

<div class="content">

    @include('layouts.error-sucess-messages')

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header card-header-icon" data-background-color="green">

                        <i class="material-icons">perm_identity</i>

                    </div>

                    <div class="card-content">

                        <h4 class="card-title">Update Profile</h4>

                        <form method="post" action="{{url('admin/telecaller-profile')}}" onsubmit="return pasCheck()">

                            {{csrf_field()}}

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group label-floating">

                                        <label class="control-label">User Name</label>

                                        <input type="text" class="form-control" name="username" required="" value="{{$data['user']->username}}">

                                        <input type="hidden" class="form-control" name="rowid" required="" value="{{$data['user']->id}}">

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group label-floating">

                                        <label class="control-label">Full Name</label>

                                        <input type="text" class="form-control" name="name" required="" value="{{$data['user']->name}}">

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group label-floating">

                                        <label class="control-label">Mobile Number</label>

                                        <input type="number" class="form-control" name="mobile" required="" value="{{$data['user']->mobile}}">

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group label-floating">

                                        <label class="control-label">Email Id</label>

                                        <input type="email" class="form-control" name="email" required="" value="{{$data['user']->email}}">

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group label-floating">

                                        <label class="control-label">Password</label>

                                        <input type="password" class="form-control pass" name="password">

                                        <span class="pass1"></span>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group label-floating">

                                        <label class="control-label">Confirm Password</label>

                                        <input type="password" class="form-control con-pass" name="con-password">

                                        <span class="errorpass pass2"></span>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="form-group">

                                        <label>About Me</label>

                                        <div class="form-group label-floating">

                                            <textarea class="form-control" rows="5" name="address">{{$data['user']->address}}</textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <button type="submit" class="btn btn-success pull-right">Update Profile</button>

                            <div class="clearfix"></div>

                        </form>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card card-profile">

                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                        <div class="fileinput-new thumbnail img-circle">

                            @if($data['user']->image!='')

                            <img src="{{url('public/photos/'.$data['user']->image)}}" alt="image">

                            @else

                            <img src="{{url('public/adminassets/img/faces/marc.jpg')}}" alt="image">

                            @endif

                        </div>

                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>

                        <div class="card-content">

                            <h4 class="card-title">{{$data['user']->first_name.' '.$data['user']->last_name}}</h4>

                            <p class="description">{{$data['user']->aboutme}}</p>

                        </div>

                        <div>

                            <form id="change-image" action="{{url('admin/change-image')}}" method="post" enctype="multipart/form-data">

                                {{csrf_field()}}

                                <span class="btn btn-round btn-success btn-file">

                                    <span class="fileinput-new">Change Photo</span>

                                    <span class="fileinput-exists">Change</span>

                                    <input type="file" class="image-change" name="image" required=""/>

                                    <input type="hidden" name="rowid" required="" value="{{$data['user']->id}}" />

                                </span>                                

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('.pass').blur(function(){
            if($('.pass').val()!='')
            {
                $('.con-pass').attr('required',true);
            }else{

                $('.con-pass').attr('required',false);

            }

        });



        $('.con-pass').blur(function(){

            var pass = $('.pass').val();

            var cpass = $('.con-pass').val();

            if(pass!=cpass)

            {

                $('.con-pass').val('');

                $('.errorpass').html('<span style="color:red;">Password not match!</span>');

            }else{

                $('.errorpass').html('');

            }

        });



        $('.image-change').change(function(){

            $('#change-image').submit();

        });

    });



</script>

<script type="text/javascript">

    

  function pasCheck(){

      var pass = $('.pass').val();

      var cpass = $('.con-pass').val();



      if(pass!="")

        {

          if(pass.length<6){

            $('.pass1').html('<span style="color:red;">Password length must be greater then 5 characters</span>');

            return false;

          }else{

            $('.pass1').html(' ');

          }

          if(pass.length>10){

            $('.pass1').html('<span style="color:red;">Password length must be smaller then 10 characters</span>');

            return false;

          }

        }

      if(pass!=cpass){

        $('.errorpass').html('<span style="color:red;">Password not match!</span>');

        return false;

      }

 

  } 



  jQuery('.txt_Space').keyup(function () { 

    this.value = this.value.replace(/[^a-zA-Z ]/g,'');

    });





</script>

@endsection