<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
	<meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('public/adminassets/img/logo.png')}}" />
    <link rel="icon" type="image/png" href="{{url('public/frontassets/img/favicon.jpg')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('page-title')</title>
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
    <script type="text/javascript">
        var base_url = "{{url('/')}}";
    </script>
    <script src="{{url('public/adminassets/js/jquery-3.2.1.min.js')}}"></script>
    <style type="text/css">
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        } 


    </style>
</head>

<body> 
    <div class="wrapper">
        <div class="sidebar" data-active-color="rose" data-background-color="black" data-image="{{url('public/adminassets/img/sidebar-2.jpg')}}">
        <div class="logo logo-dash text-center">
		      
            <a href="{{url('user/dashboard')}}" class="simple-text logo-normal"> <h4><b>Fast Test Series</b></h4>
                <!--img src="{{url('public/adminassets/img/mmh.png')}}" class="img-responsive"-->
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
                    <img src="{{url('public/photos/'.$user->image)}}" alt="image">
                    @else
                    <img src="{{url('public/adminassets/img/faces/marc.jpg')}}" alt="image">
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
                                <a href="{{url('user/profile')}}">
                                    <span class="sidebar-mini">MP</span>
                                    <span class="sidebar-normal">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="Logout();">
                                    <span class="sidebar-mini">Log</span>
                                    <span class="sidebar-normal">Logout</span>
                                </a> 
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">{{ csrf_field() }}</form> 
                                                   
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @php
                $page = Request::segment(2);
            @endphp
            <ul class="nav">
            <li class="@if($page=='dashboard') active @endif">
                <a href="{{url('user/dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard </p>
                </a>
            </li>
           

              <li class="@if($page=='orders') active @endif">
                <a href="{{url('user/orders')}}">
                    <i class="material-icons">bookmarks</i>
                    <p>Orders</p>
                </a>
            </li> 

              <li class="@if($page=='schedule-test-papers') active @endif">
                <a href="{{url('user/schedule-test-papers')}}">
                    <i class="material-icons">bookmarks</i>
                    <p>Schedule Test Papers</p>
                </a>
            </li> 
          <li class="@if($page=='unschedule-test-papers') active @endif">
                <a href="{{url('user/unschedule-test-papers')}}">
                    <i class="material-icons">bookmarks</i>
                    <p>Unschedule Test Papers</p>
                </a>
            </li> 

        </ul>
        </div>
    </div>
    <div class="main-panel">
        @yield('content')  
   </div>
    </div>
</body>
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
<script src="{{url('public/adminassets/js/custom.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        demo.initFormExtendedDatetimepickers();
    });
    function Logout(){
        $('#logout-form').submit();
    }
</script>
<script type="text/javascript">

	   $('.datepicker').datetimepicker({
		 format: 'DD-MM-YYYY',
		 maxDate: new Date(), 
        
	   }); 

        $('.datepicker1').datetimepicker({
         format: 'DD-MM-YYYY',
          minDate: new Date(),
          useCurrent: false, 
       }); 

    $('.datepicker2').datetimepicker({
      format: 'DD-MM-YYYY',
      minDate: new Date(), 
      useCurrent: false,
   }); 

    
	   
function deleteRow(id,url)
{
    swal({
    title: 'Are you sure?',
    text: "You want to delete this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    confirmButtonText: 'Yes',
    buttonsStyling: false
    }).then(function() {
        $.ajax({
                url: url+id,
                method:"get",
            success:function(data)
            {
                
                if(data=='success')
                {
                    var message = 'Data has been deleted successfully.';
                    demo.showNotification('bottom','right','success', message );
                    $('#datatables').load(document.URL +  ' #datatables');
                }else{
                    var message = 'Please try again';
                    demo.showNotification('bottom','right','danger', message );
                    $('#datatables').load(document.URL +  ' #datatables');
                }                    
            },
            error:function(er){
                console.log(er); 
            }
        });           
    });
}   
	   
	   
</script>
</html>