<!doctype html>
<html lang="en"> 
 
<head> 
    <meta charset="utf-8" /> 
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('public')}}/assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="{{url('public')}}/assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Reset Password</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{url('public')}}/assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{url('public')}}/assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{url('public')}}/assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<div class="wrapper wrapper-full-page">
        <div class="full-page lock-page" filter-color="black" data-image="{{url('public')}}/assets/img/lock.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | green | orange | red | purple" -->
             
            <div class="content">
            <div class="col-md-4 col-md-offset-4">
                 @include('layouts.error-sucess-messages')
                 @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                 @endif
            </div>
           <br><br><br>
                <form method="post" action="{{ route('password.email') }}"> 
                    {{ csrf_field() }}
                    <div class="card card-profile card-hidden">
                        <div class="card-avatar">
                            <a href="#pablo">
                                <img class="avatar" src="{{url('public')}}/assets/img/faces/avatar.jpg" alt="...">
                            </a>  
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Reset Password</h4>
                            <div class="form-{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label">E-Mail Address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-rose btn-round">Password Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        
<!--   Core JS Files   -->
<script src="{{url('public')}}/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/js/material.min.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Library for adding dinamically elements -->
<script src="{{url('public')}}/assets/js/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{url('public')}}/assets/js/jquery.validate.min.js"></script>
<!-- Promise Library for SweetAlert2 working on IE -->
<script src="{{url('public')}}/assets/js/es6-promise-auto.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{url('public')}}/assets/js/moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="{{url('public')}}/assets/js/chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{url('public')}}/assets/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="{{url('public')}}/assets/js/bootstrap-notify.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{url('public')}}/assets/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{url('public')}}/assets/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="{{url('public')}}/assets/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{url('public')}}/assets/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{url('public')}}/assets/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="{{url('public')}}/assets/js/sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{url('public')}}/assets/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{url('public')}}/assets/js/fullcalendar.min.js"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  --> 
<script src="{{url('public')}}/assets/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{url('public')}}/assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{url('public')}}/assets/js/demo.js"></script>
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

</html>