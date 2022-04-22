<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('public/assets/image/apple-icon1.png')}}" />
    <link rel="icon" type="image/png" href="{{asset('front-assets/img/logo.png')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />  
    <title>@yield('page-title')</title> 
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{asset('public/assets/css/material-dashboard.css?v=1.2.0')}}" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{asset('public/assets/css/demo.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/custom.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <script src="{{url('public/assets')}}/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <style type="text/css">
      .dropdown-menu.open {
          z-index: 999999;
      }
      .dropdown-menu {
            margin: 0 15px; 
            padding: 0;
        }
        a.dropdown-item.active {
            background-color: #9c27b0;
            box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(156, 39, 176, 0.4);
            color: #fff;
        }
        .dropdown-menu a {
            display: block;
            width: 100%;
            padding: 5px;
            font-size: 14px;
            font-weight: 400;
        }
    </style>
    <script type="text/javascript">
    var App;
    var isAngularJsApp;
    var base_url = "{{url('/')}}";
    function confirmPopup(msg,url)
    {
      swal({
        title: msg,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false
      })
      .then((willDelete) => {
        if (willDelete) {
          window.location.assign(base_url+url);
        }else{
          return false;
        }
      });
    }
    </script>
</head> 
<style type="text/css">
    img{
        width: 200px;
        background: #0099ff;
    }

</style> 

<div class="wrapper">
        <div class="sidebar" data-active-color="purple" data-background-color="black" data-image="{{url('public')}}/assets/image/sidebar-2.jpg">
            <div class="logo text-center">
                 <a href="{{url('/')}}" class="simple-text logo-normal">
                    <img src="{{url('public/front-assets/assets/images/iic_logo.png')}}" class="logo_new">
                </a>
            </div> 
            @php
            $userdata = Auth::user();
            $user = Helper::getUser($userdata->id);
            @endphp 
            <div class="sidebar-wrapper">
            
                <div class="user">
                <div class="photo">
                  @if($user->image!='')
                    <img class="img" src="{{url('public/assets/photos')}}/{{$user->image}}" />
                  @else
                    <img class="img" src="{{url('public/')}}/assets\img\faces/marc.jpg" />
                  @endif
                </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                {{$user->name}}
                                <b class="caret"></b>
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="{{ url('profile')}}">
                                        <span class="sidebar-mini">P</span>
                                        <span class="sidebar-normal">Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <span class="sidebar-mini">L</span>
                                        <span class="sidebar-normal">Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                     {{ csrf_field() }}
                                    </form>
                                </li>             
                            </ul>
                        </div>
                    </div>
                </div>
               @php
                $page = Request::segment(1);
                $page2 = Request::segment(2);
               @endphp
                <ul class="nav">
                    <li class="@if($page=='dashboard') active @endif">
                        <a href="{{url('dashboard')}}">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>  

                    <li class="@if($page=='users') active @endif">
                        <a href="{{route('users.index')}}">
                            <i class="material-icons">dashboard</i>
                            <p>Users</p>
                        </a>
                    </li> 	

                    <li class="@if($page=='strategic-partners') active @endif">
                        <a href="{{url('strategic-partners')}}">
                            <i class="material-icons">dashboard</i>
                            <p>Strategic Partners</p>
                        </a>
                    </li>	

                    <li class="@if($page=='event') active @endif">
                        <a href="{{url('event')}}">
                            <i class="material-icons">dashboard</i>
                            <p>Events</p>
                        </a>
                    </li>	

					<li class="@if($page=='whatwedo') active @endif">
                        <a href="{{url('whatwedo')}}">
                            <i class="material-icons">dashboard</i>
                            <p> What we Do</p>
                        </a>
                    </li>						
                   
              

                    <li class="nav-item dropdown @if($page=='settings') active @endif">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">dashboard</i>
                            <p> Settings
                                <b class="caret"></b>
                            </p>
                        </a>
						
						 <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" x-placement="bottom-start"> 
                            <a class="dropdown-item @if($page=='contact-enquiry') active @endif" href="{{url('contact-enquiry')}}">Contact Enquiry</a>
                          
                        </div>
						
                    </li>

                   
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                    
                                    <i class="material-icons">person</i>
                                    {{$user->name}}
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                                <ul class="dropdown-menu">
                                   @if(Auth::user()->role==1)
                                    <li>
                                        <a href="{{ url('profile')}}">Profile</a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    
                                </ul>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                    </div>
                </div>
            </nav> 
  @yield('content')         
        </div>
      </div>
    
</body>
<!--   Core JS Files   -->

<script src="{{url('public/assets/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{url('public/assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{url('public/assets/js/material.min.js')}}" type="text/javascript"></script>
<script src="{{url('public/assets/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<!-- Library for adding dinamically elements -->
<script src="{{url('public/assets/js/arrive.min.js')}}" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{url('public/assets/js/jquery.validate.min.js')}}"></script>
<!-- Promise Library for SweetAlert2 working on IE -->
<script src="{{url('public/assets/js/es6-promise-auto.min.js')}}"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{url('public/assets/js/moment.min.js')}}"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="{{url('public/assets/js/chartist.min.js')}}"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{url('public/assets/js/jquery.bootstrap-wizard.js')}}"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="{{url('public/assets/js/bootstrap-notify.js')}}"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{url('public/assets/js/bootstrap-datetimepicker.js')}}"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{url('public/assets/js/jquery-jvectormap.js')}}"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="{{url('public/assets/js/nouislider.min.js')}}"></script>
 
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js" type="text/javascript"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<!-- <script src="{{url('assets/js/sweetalert2.js')}}"></script> -->
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{url('public/assets/js/jasny-bootstrap.min.js')}}"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{url('public/assets/js/fullcalendar.min.js')}}"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{{url('public/assets/js/jquery.tagsinput.js')}}"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{url('public/assets/js/material-dashboard.js?v=1.2.0')}}"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{url('public/assets/js/bootstrap-select.min.js')}}"></script>
<!-- <script src="{{url('public/assets/js/components-bootstrap-select.min.js')}}"></script> -->
<script src="{{url('public/assets/js/demo.js')}}"></script>
<script src="{{url('public/assets/js/sweetalert2.js')}}"></script>
<script src="{{url('public/assets/js/custom.js?time='.time())}}"></script>
<script src="{{url('public/assets/js/bootbox.min.js?time='.time())}}"></script>
<script src="https://cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        demo.checkFullPageBackgroundImage();
        setTimeout(function() {
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script> 
<script type="text/javascript"> 
 $(document).ready(function() {
  demo.initFormExtendedDatetimepickers();
	   
 }); 
 
   $('.datepicker').datetimepicker({
		 format: 'DD-MM-YYYY',
		 //defaultDate: new Date(),
		 //maxDate: new Date(), 
	   }); 
	   
	   

</script>
@yield('datatable-script')
</html>            
      
        
 