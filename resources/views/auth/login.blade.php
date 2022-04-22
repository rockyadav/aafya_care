<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('public/frontassets/img/logo.png')}}" />
    <link rel="icon" type="image/png" href="{{url('public/frontassets/img/logo.png')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Aafya Care</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{url('public/adminassets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{url('public/adminassets/css/material-dashboard.css?v=1.2.0')}}" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{url('public/adminassets/css/demo.css')}}" rel="stylesheet" />
    <!--  Custom CSS     -->
    <link href="{{url('public/adminassets/css/custom.css')}}" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .card-login .card-title {
            margin-top: 5px;
            margin-bottom: 5px;
            font-weight: 700;
            font-size: 24px;
        }
        .login-page>.content, .lock-page>.content {
            position: absolute;
            transform: translateY(-50%);
            top: 50%;
            margin: auto;
            right: 0;
            left: 0;
            padding: 0px;
            min-height: auto;
        }
        .full-page.login-page {
            height: 100vh;
            position: relative;
        }
    </style>
</head>
<body class="off-canvas-sidebar">
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header logo-header">
                <a class="navbar-brand" href="#"><img src="{{url('public/frontassets/images/logo.png')}}" class="img-responsive" style="max-width:300px;"></a>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" >
            <div class="content">
               
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
						 @include('layouts.error-sucess-messages')
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                 {{ csrf_field() }}
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="#00a4ef" style="background:#00a4ef;padding:15px 0px;">
                                        <h4 class="card-title">Login</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email address</label>
                                                <input type="text" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password"  class="form-control" required>
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg" name="login" style="background:#00a4ef;padding:10px 0px;color:#FFF;">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
             
        </div>
    </div>
</body>

<script src="{{url('public/adminassets/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{url('public/adminassets/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/adminassets/js/material.min.js')}}"></script>
<script src="{{url('public/adminassets/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{url('public/adminassets/js/arrive.min.js')}}" type="text/javascript"></script>
<script src="{{url('public/adminassets/js/jquery.validate.min.js')}}"></script>
<script src="{{url('public/adminassets/js/es6-promise-auto.min.js')}}"></script>
<script src="{{url('public/adminassets/js/moment.min.js')}}"></script>
<script src="{{url('public/adminassets/js/chartist.min.js')}}"></script>
<script src="{{url('public/adminassets/js/jquery.bootstrap-wizard.js')}}"></script>
<script src="{{url('public/adminassets/js/bootstrap-notify.js')}}"></script>
<script src="{{url('public/adminassets/js/bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('public/adminassets/js/jquery-jvectormap.js')}}"></script>
<script src="{{url('public/adminassets/js/nouislider.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<script src="{{url('public/adminassets/js/jquery.select-bootstrap.js')}}"></script>
<script src="{{url('public/adminassets/js/jquery.datatables.js')}}"></script>
<script src="{{url('public/adminassets/js/sweetalert2.js')}}"></script>
<script src="{{url('public/adminassets/js/jasny-bootstrap.min.js')}}"></script>
<script src="{{url('public/adminassets/js/fullcalendar.min.js')}}"></script>
<script src="{{url('public/adminassets/js/jquery.tagsinput.js')}}"></script>
<script src="{{url('public/adminassets/js/material-dashboard.js')}}?v=1.2.0"></script>
<script src="{{url('public/adminassets/js/demo.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        demo.initFormExtendedDatetimepickers();
        demo.initDashboardPageCharts();
        demo.initVectorMap();
        demo.checkFullPageBackgroundImage();
        setTimeout(function() {
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>
</html>