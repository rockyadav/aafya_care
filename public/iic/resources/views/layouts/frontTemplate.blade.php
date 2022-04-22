<!DOCTYPE html>
<html lang="zxx">
    <head> 
        <!-- meta tag -->
        <meta charset="utf-8">
        <title>International Investment Consortium(IIC)</title>
        <meta name="description" content="">
        <!-- responsive tag -->
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon -->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" type="image/x-icon" href="{{url('public/front-assets/assets/images/fav.png')}}">
        <!-- Bootstrap v4.4.1 css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/bootstrap.min.css')}}">
        <!-- font-awesome css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/font-awesome.min.css')}}">
        <!-- animate css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/animate.css')}}">
        <!-- aos css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/aos.css')}}">
        <!-- owl.carousel css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/owl.carousel.css')}}">
        <!-- slick css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/slick.css')}}">
        <!-- off canvas css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/off-canvas.css')}}">
        <!-- linea-font css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/fonts/linea-fonts.css')}}">
        <!-- flaticon css  -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/fonts/flaticon.css')}}">
        <!-- magnific popup css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/magnific-popup.css')}}">
        <!-- Main Menu css -->
        <link rel="stylesheet" href="{{url('public/front-assets/assets/css/rsmenu-main.css')}}">
        <!-- nivo slider CSS -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/inc/custom-slider/css/nivo-slider.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/inc/custom-slider/css/preview.css')}}">
        <!-- rsmenu transitions css -->
        <link rel="stylesheet" href="{{url('public/front-assets/assets/css/rsmenu-transitions.css')}}">
        <!-- spacing css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/rs-spacing.css')}}">
        <!-- style css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/style.css')}}"> <!-- This stylesheet dynamically changed from style.less -->
        <!-- responsive css -->
        <link rel="stylesheet" type="text/css" href="{{url('public/front-assets/assets/css/responsive.css')}}">
    </head>
	<script>
	var site_url = "{{url('/')}}";
	</script>
    <body class="defult-home">

        <!-- Preloader area start here -->
        <div id="loader" class="loader">
            <div class="spinner"></div>
        </div>
        <!--End preloader here -->

         <!--Full width header Start-->
 <div class="full-width-header">
    <!-- Toolbar Start -->
    <div class="toolbar-area hidden-md">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="toolbar-contact">
                        <ul>
                            <li><i class="flaticon-email"></i><a href="mailto:info@iic2u.com">info@iic2u.com</a></li>
                            <li><i class="flaticon-call"></i><a href="tel:+123456789">+60 3 2282 3627 </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="toolbar-sl-share">
                        <ul>
                            <li class="opening"><a href="{{url('signup')}}">Register</a></li>
                            <li class="opening"><a href="{{url('user-login')}}">Login</a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Toolbar End -->
    
    <!--Header Start-->
    <header id="rs-header" class="rs-header">
        <!-- Menu Start -->

             @php
                $page = Request::segment(1);

               @endphp
        <div class="menu-area menu-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1">
                        <div class="logo-area">
                            <a href="{{url('/')}}"><img src="{{url('public/front-assets/assets/images/logo-dark.png')}}" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-11 text-right">
                        <div class="rs-menu-area">
                            <div class="main-menu">
                                <div class="mobile-menu">
                                    <a class="rs-menu-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </div>

                                <nav class="rs-menu pr-65">
                                    <ul class="nav-menu">
                                        <li class="rs-mega-menu mega-rs  @if($page=='') current-menu-item @endif"> <a href="{{url('/')}}">Home</a></li>

                                        <li class="menu-item-has-children @if($page=='about-us' || $page=='chairmans-message' || $page=='strategic-partner-registration') current-menu-item @endif">
                                            <a href="{{url('about-us')}}">Who We Are</a>
                                            <ul class="sub-menu">
												 <li><a href="{{url('about-us')}}"> About </a></li>
												 <li><a href="{{url('chairmans-message')}}"> Chairmans-Message</a></li>
                                                <li><a href="{{url('strategic-partner-registration')}}">Strategic-Partnership-Form</a></li>
                                            </ul>
                                        </li>
										
										  <li class="@if($page=='what-we-do') current-menu-item @endif">
                                            <a href="{{url('what-we-do')}}">What We Do</a>
                                        </li>

                                        <li class="">
                                            <a href="#">Where We Are</a>
                                        </li>
                                        <li class="menu-item-has-children @if($page=='events' || $page=='event-details') current-menu-item @endif">
                                            <a href="#">Information Center</a>
                                            <ul class="sub-menu">
                                                <li><a href="{{url('events')}}">Events</a></li>
                                                <li><a href="#">Projects</a></li>
                                            </ul>
                                        </li> 
                                        <li class="@if($page=='contact-us') current-menu-item @endif">
                                            <a href="{{url('contact-us')}}">Contact</a>
                                        </li>
                                    </ul> <!-- //.nav-menu -->
                                </nav>
                            </div> <!-- //.main-menu -->
                            <div class="expand-btn-inner">
                                <ul>
                                    <li>
                                        <a id="nav-expander" class="humburger nav-expander" href="#">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                            <span class="dot3"></span>
                                            <span class="dot4"></span>
                                            <span class="dot5"></span>
                                            <span class="dot6"></span>
                                            <span class="dot7"></span>
                                            <span class="dot8"></span>
                                            <span class="dot9"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu End -->

        <!-- Canvas Menu start -->
        <nav class="right_menu_togle hidden-md">
            <div class="close-btn">
                <span id="nav-close" class="humburger">
                    <span class="dot1"></span>
                    <span class="dot2"></span>
                    <span class="dot3"></span>
                    <span class="dot4"></span>
                    <span class="dot5"></span>
                    <span class="dot6"></span>
                    <span class="dot7"></span>
                    <span class="dot8"></span>
                    <span class="dot9"></span>
                </span>
            </div>
            <div class="canvas-logo">
                <a href="index.php"><img src="{{url('public/front-assets/assets/images/logo-dark.png')}}" alt="logo"></a>
            </div>
            <div class="offcanvas-text">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
            </div>
            <div class="canvas-contact">
                <ul class="contact">
                    <li><i class="flaticon-location"></i> 
                        IR Mohamed Shafii Bin Haji Mustafa
                        No. 1, Floor 13, Tower C, Wisma Goshen, Plaza Pantai 5, Persiaran Pantai Baru Off Jalan Pantai Baru 59200 Kuala Lumpur, MALAYSIA</li>
                    <li><i class="flaticon-call"></i><a href="tel:+880155-69569">+60 3 2282 3627</a></li>
                    <li><i class="flaticon-email"></i><a href="mailto:info@iic2u.com">info@iic2u.com</a></li>
                    <li><i class="flaticon-clock"></i>10:00 - 17:00</li>
                </ul>
                <ul class="social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </nav>
        <!-- Canvas Menu end -->
    </header>
    <!--Header End-->
</div>
<!--Full width header End-->

    <!-- ================= Header end here =================== -->
    @yield('content')

    <!-- =================== Footer ========================  -->
   <!-- Footer Start -->
     <footer id="rs-footer" class="rs-footer">
            <div class="container">
               <!-- <div class="footer-newsletter">
                    <div class="row y-middle">
                        <div class="col-md-6 sm-mb-26">
                            <h3 class="title white-color mb-0">Newsletter Subscribe</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <form class="newsletter-form">
                                <input type="email" name="email" placeholder="Your email address" required="">
                                <button type="submit"><i class="fa fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div> -->
                <div class="footer-content pt-62 pb-79 md-pb-64 sm-pt-48">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12 footer-widget md-mb-39">
                            <div class="about-widget pr-15">
                                <div class="logo-part">
                                    <a href="index.php"><img src="{{url('public/front-assets/assets/images/logo.png')}}" alt="Footer Logo"></a>
                                </div>
                                <p class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                <div class="btn-part">
                                    <a class="readon" href="about.php">Discover More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 md-mb-32 footer-widget">
                            <h4 class="widget-title">Contact Info</h4>
                            <ul class="address-widget pr-40">
                                <li>
                                    <i class="flaticon-location"></i>
                                    <div class="desc">IR Mohamed Shafii Bin Haji Mustafa
                                        No. 1, Floor 13, Tower C, Wisma Goshen, Plaza Pantai 5, Persiaran Pantai Baru Off Jalan Pantai Baru 59200 Kuala Lumpur, MALAYSIA</div>
                                </li>
                                <li>
                                    <i class="flaticon-call"></i>
                                    <div class="desc">
                                        <a href="tel:+8801739753105">+60 3 2282 3627 </a>
                                    </div>
                                </li>
                                <li>
                                    <i class="flaticon-email"></i>
                                    <div class="desc">
                                        <a href="mailto:info@iic2u.com">info@iic2u.com</a>
                                    </div>
                                </li>
                                <li>
                                    <i class="flaticon-clock"></i>
                                    <div class="desc">
                                        10:00 - 17:00
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 footer-widget">
                            <h4 class="widget-title">Latest Posts</h4>
                            <div class="footer-post">
                            	
                            	@foreach($fevents as $fev)
                                <div class="post-wrap mb-15">
                                    <div class="post-img">
                                        <a href="{{url('event-details/'.base64_encode($fev->id))}}"><img src="{{url('public/events/'.$fev->image)}}" alt=""></a>
                                    </div>
                                    <div class="post-desc">
                                        <a href="{{url('event-details/'.base64_encode($fev->id))}}"><img src="{{url('public/events/'.$fev->image)}}')}}">{{$fev->title}}</a>
                                        <div class="date-post">
                                            <i class="fa fa-calendar"></i>
                                           {{date("d-M-Y",strtotime($fev->event_date))}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row y-middle">
                        <div class="col-lg-6 col-md-8 sm-mb-21">
                            <div class="copyright">
                                <p>Copyright ©2021 International Investment Consortium (IIC) All Rights Reserved.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 text-right sm-text-center">
                            <ul class="footer-social">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- start scrollUp  -->
        <div id="scrollUp">
            <i class="fa fa-angle-up"></i>
        </div>
        <!-- End scrollUp  -->

        <!-- Search Modal Start -->
         <!--  <div aria-hidden="true" class="modal fade search-modal" role="dialog" tabindex="-1">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="flaticon-cross"></span>
            </button>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="search-block clearfix">
                        <form>
                            <div class="form-group">
                                <input class="form-control" placeholder="Search Here..." type="text" required="">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Search Modal End -->

        <!-- modernizr js -->
        <script src="{{url('public/front-assets/assets/js/modernizr-2.8.3.min.js')}}"></script>
        <!-- jquery latest version -->
        <script src="{{url('public/front-assets/assets/js/jquery.min.js')}}"></script>
        <!-- Bootstrap v4.4.1 js -->
        <script src="{{url('public/front-assets/assets/js/bootstrap.min.js')}}"></script>
        <!-- Menu js -->
        <script src="{{url('public/front-assets/assets/js/rsmenu-main.js')}}"></script> 
        <!-- op nav js -->
        <script src="{{url('public/front-assets/assets/js/jquery.nav.js')}}"></script>
        <!-- owl.carousel js -->
        <script src="{{url('public/front-assets/assets/js/owl.carousel.min.js')}}"></script>
        <!-- Slick js -->
        <script src="{{url('public/front-assets/assets/js/slick.min.js')}}"></script>
        <!-- isotope.pkgd.min js -->
        <script src="{{url('public/front-assets/assets/js/isotope.pkgd.min.js')}}"></script>
        <!-- imagesloaded.pkgd.min js -->
        <script src="{{url('public/front-assets/assets/js/imagesloaded.pkgd.min.js')}}"></script>
        <!-- wow js -->
        <script src="{{url('public/front-assets/assets/js/wow.min.js')}}"></script>
        <!-- aos js -->
        <script src="{{url('public/front-assets/assets/js/aos.js')}}"></script>
        <!-- Skill bar js -->
        <script src="{{url('public/front-assets/assets/js/skill.bars.jquery.js')}}"></script>
        <script src="{{url('public/front-assets/assets/js/jquery.counterup.min.js')}}"></script>        
         <!-- counter top js -->
        <script src="{{url('public/front-assets/assets/js/waypoints.min.js')}}"></script>
        <!-- video js -->
        <script src="{{url('public/front-assets/assets/js/jquery.mb.YTPlayer.min.js')}}"></script>
        <!-- magnific popup js -->
        <script src="{{url('public/front-assets/assets/js/jquery.magnific-popup.min.js')}}"></script>
        <!-- Nivo slider js -->
        <script src="{{url('public/front-assets/assets/inc/custom-slider/js/jquery.nivo.slider.js')}}"></script>
        <!-- plugins js -->
        <script src="{{url('public/front-assets/assets/js/plugins.js')}}"></script>
        <!-- contact form js -->
        <script src="{{url('public/front-assets/assets/js/contact.form.js')}}"></script>
        <!-- main js -->
        <script src="{{url('public/front-assets/assets/js/main.js')}}"></script>
		 <script src="{{url('public/front-assets/assets/js/custom.js')}}"></script>
		 @include('layouts.front-error-sucess-messages') 
    </body>
</html>
   