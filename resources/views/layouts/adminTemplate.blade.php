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
        <div class="sidebar" data-active-color="green" data-background-color="black" data-image="{{url('public/adminassets/img/sidebar-1.jpg')}}">
        <div class="logo logo-dash text-center">
		      
            <a href="{{url('admin/dashboard')}}" class="simple-text logo-normal"> <h4><b>Aafya Care</b></h4>
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
                                <a href="{{url('admin/profile')}}">
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
                <a href="{{url('admin/dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard </p>
                </a>
            </li>
           
            <li class="@if($page=='customer' || $page=='user-details') active @endif">
                <a href="{{url('admin/customer')}}">
                    <i class="material-icons">face</i>
                    <p>Customer Request</p>
                </a>
            </li>


             <li class="@if($page=='laboratory-users' || $page=='laboratory-user-details') active @endif">
                <a href="{{url('admin/laboratory-users')}}">
                    <i class="material-icons">face</i>
                    <p>Laboratory User</p>
                </a>
            </li>

             <li class="@if($page=='sample-collectors' || $page=='sample-collector-details') active @endif">
                <a href="{{url('admin/sample-collectors')}}">
                    <i class="material-icons">face</i>
                    <p>Sample Collector</p>
                </a>
            </li>

             <li class="@if($page=='telecallers' || $page=='telecaller-details') active @endif">
                <a href="{{url('admin/telecallers')}}">
                    <i class="material-icons">face</i>
                    <p>Telecaller</p>
                </a>
            </li>
			
			 <li class="@if($page=='slider' || $page=='slider-add' || $page=='slider-edit') active @endif">
                <a href="{{url('admin/slider')}}">
                    <i class="material-icons">bookmarks</i>
                    <p>Home Slider</p>
                </a>
            </li> 

              <li class="@if($page=='course' || $page=='course-add' || $page=='course-edit') active @endif">
                <a href="{{url('admin/course')}}">
                    <i class="material-icons">bookmarks</i>
                    <p>Test</p>
                </a>
            </li> 
			
			

             <li class="@if($page=='course-perameter' || $page=='course-perameter-add' || $page=='course-perameter-edit') active @endif">
                <a href="{{url('admin/parameter-test')}}">
                    <i class="material-icons">group</i>
                    <p>Test Parameters</p>
                </a>
            </li> 

             <li class="@if($page=='testimonial' || $page=='testimonial-add' || $page=='testimonial-edit') active @endif">
                <a href="{{url('admin/testimonial')}}">
                    <i class="material-icons">group</i>
                    <p>Testimonials</p>
                </a>
            </li> 

             <li class="@if($page=='city') active @endif">
                <a href="{{url('admin/city')}}">
                    <i class="material-icons">assignment</i>
                    <p>Cities</p>
                </a>
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
              
            </div>
			 @if(Session::get('country_login')!='' && Auth::user()->role==1) 
				   <div class="pull-right">
                            <a class="btn btn-rose btn-fill" href="{{url('admin/back_to_admin')}}">Back to admin<div class="ripple-container"></div></a>
                        </div>
				 
			   @endif
        </div>
    </nav>

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

$('#userdatatables').DataTable({
"pagingType": "full_numbers",
"lengthMenu": [
[10, 25, 50, -1],
[10, 25, 50, "All"]
],
"aaSorting": [],
responsive: true,
language: {
search: "_INPUT_",
searchPlaceholder: "Search records",
zeroRecords: "Nothing found - sorry",
infoEmpty: "No records available",
}

});


    
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
      //minDate: new Date(), 
      useCurrent: false,
   }); 


     $('#mydatatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "aaSorting": [],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
                zeroRecords: "Nothing found - sorry",
                infoEmpty: "No records available",
            }

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