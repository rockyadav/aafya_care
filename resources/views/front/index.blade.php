<!doctype html>
<html lang="zxx">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Aafya Care
	</title>
	<!-- Template CSS -->
	<link rel="stylesheet" href="{{url('public/frontassets/css/style-starter.css')}}">
	<!-- Testimonial CSS -->
	<link rel="stylesheet" href="{{url('public/frontassets/css/custom.css')}}">
	<!-- End Testimonial CSS -->
	<!-- Template CSS -->
	<link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap"
	 rel="stylesheet">
	<!-- Template CSS -->
</head>
<style type="text/css">
.w3l-content-with-photo-4 .content-photo-info p {
    padding-left: 30px;
}

.price-table span:first-child {
    font-size: 1em !important;
    
}

.price-table {
    height: 600px;
    overflow-y: auto;
}
.loadingLabel {
	margin-bottom: 0px;
}
.loadingIMG {
	display: none;
}
.tillnoblock {
	margin-top: 5px;
}

.tillnoblock {
		margin-top: 5px;
		text-align: center;
	}
.tillnoblock2 {
		position: relative;
		top: 28px;
		left: 90px;
}
	.tillno {
    font-size: 15px;
				text-align: justify;
				padding-left: 105px;
}
	.purchasebtn {
		position: sticky;
		bottom: 1px;
		background-color: white;
	}
</style>

<body>
	<!--w3l-header-->
	<section class="w3l-top-header-content">
		<div class="hny-top-menu">
			<div class="container">
				<div class="row">
					<div class="social-top col-lg-5 mt-lg-0 mt-sm-6">
							<div class="top-bar-text text-left"><a class="bk-button" href="#">BOOK ONLINE </a> You can
							request appointment now !</div>
					</div>

					@if (session()->has('myUserData'))
					<div class="social-top col-lg-3 mt-lg-0 mt-sm-6">
							<div class="top-bar-text text-center"><a class="bk-button" href="{{url('reports')}}">REPORTS</a></div>
					</div>

					<div class="social-top col-lg-4 mt-lg-0 mt-sm-6">
								@php $user = session('myUserData'); @endphp
							<div class="top-bar-text text-right"> You are IN <b><i> @php echo $user['UserName']; @endphp ! </i></b> 
								<a class="bk-button" href="#" onclick="Logout()">
									Logout
								</a>
						</div>
					</div>
					@endif

				</div>
			</div>
		</div>
	</section>
	<!--//top-header-content-->
	<!--w3l-header-->
	<header class="w3l-header-nav">
		<!--/nav-->
		<nav class="navbar navbar-expand-lg navbar-light px-lg-0 py-0 px-3 stroke">
			<div class="container">
				<a class="navbar-brand" href="index.html">
				<!-- if logo is image enable this  --> 
						<a class="navbar-brand" href="{{url('/')}}">
							<img src="{{url('public/frontassets/images/logo.png')}}" alt="logo" title="logo" style="width: 200px;"/>
							<!-- height: 70px; -->
						</a> 
				<button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="fa icon-expand fa-bars"></span>
					<span class="fa icon-close fa-times"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					 <ul class="navbar-nav mx-lg-auto">
						<!--<li class="nav-item active">
							<a class="nav-link" href="index.html">Home</a>
						</li>
						
						<li class="nav-item">
							<a class="nav-link" href="contact.html">Contact</a>
						</li>-->
					</ul> 
					
					<!-- <div class="call-support">
						<p>Call us for any question</p>
						<h6>+254 103 333 444</h6>
					</div> -->

					<div class="tillnoblock2">
										<img style="height: 40px;width: 80px;" src="http://zeta.elabassist.com/public/frontassets/images/mpesa.jpeg" alt="">
					</div>
						<div class="call-support">
							<p>Call us for any question</p>
							<h6>+254 103 333 444</h6>

							<div class="tillnoblock">
								<p class="tillno">Till No .</p>
								<h6 class="tillno">9565005</h6>

							</div>
						</div>
					
				</div>
			</div>
		</nav>
		<!--//nav-->
	</header>
	<!-- //w3l-header -->
	<!--banner-slider-->
	<!-- main-slider -->
	<?php 
     if($slider!='')
     {
     	$img = "public/sliders/".$slider->slider_image;
     }else{
     	$img = "../images/banner1.jpg";
     }
	?>
	<style type="text/css">
	.w3l-main-slider .banner-view {
		background: url({{$img}}) no-repeat center;
		
		}

	</style>

	<!-- ************** Login with otp ********************* -->
	<section class="w3l-main-slider" id="home1">
		<div class="banner-content banner-view">
			<div class="container">
				<div class="row">
					<div class="col-lg-7">
						<div class="banner-info-bg mt-5">
							<h6> @if($slider!='') {{$slider->title}} @endif</h6>
							<h5> @if($slider!='') {{$slider->description}} @endif</h5>
						</div>
					</div>
					<div class="col-lg-4" id="form1">
						<div class="w3l-free-consultion mt-1">
							<div class="consultation-grids">
								<div class="apply-form">
									<center>
										<h5>Login</h5>
									</center>
									<form action="{{url('OtpLogin')}}" method="GET" id="loginotp">
										<div class="admission-form11">
											<div class="form-group">
												<input type="text" name="moNumber" id="mobileNumber" class="form-control mobile_no" placeholder=" Enter Mobile Number*" required="">
											</div>
										</div>
										<button type="submit" class="btn btn-primary submit">
											<label for="" class="loadingLabel">Send OTP</label>
											<img src="{{url('public/frontassets/images/img.svg')}}" alt="spinner" class="loadingIMG">
										</button>
										<p>Don't have an account ? <a href="#" data-toggle="modal" data-target="#SignUpModal">Sign up</a></p>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4" id="form2" style="display:none">
						<div class="w3l-free-consultion mt-1">
							<div class="consultation-grids">
								<div class="apply-form">
									<form action="{{url('ValidateOTP')}}" method="get" id="loginotp1">
									<!-- {{ csrf_field() }} -->
										<div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
											<label for="Mobile Number">Enter OTP</label>
											<input class="input100" id="mobileOtp" type="password" name="otp" placeholder="Otp" style="">
											<span style="float: right; margin-left: -25px; margin-top: -25px;" toggle="#mobileOtp" class="fa fa-fw fa-eye field-icon toggle-password"></span>
											<!-- <span class="focus-input100" data-placeholder="Email"></span> -->
										</div>

										<div class="container-login100-form-btn">
											<div class="wrap-login100-form-btn" style="width: 100%; border-radius: 10px;">
												<!-- <div class="login100-form-bgbtn"></div> -->
												<!-- <button href="javascript:void(0);" class="login100-form-btn" id="btnEnterOTP"> -->
												<button type="submit" id="btnEnterOTP" class="btn btn-primary submit">
													<label for="" class="loadingLabel">Enter OTP</label>
													<img src="{{url('public/frontassets/images/img.svg')}}" alt="spinner" class="loadingIMG">
												</button>
											</div>
										</div>
									</form>

								</div>

							</div>
						</div>
					</div>
					<p id="goa"> trait_exists</p>
	</section>




	<!-- *******************login end*********************** -->

<section class="w3l-main-slider" id="home" style="display:none;">
<div class="banner-content banner-view">
  <div class="container"> 
  	<div class="row">
		<div class="col-lg-7">
			<div class="banner-info-bg mt-5">
				<h6> @if($slider!='') {{$slider->title}} @endif</h6>
				<h5> @if($slider!='') {{$slider->description}} @endif</h5>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="w3l-free-consultion mt-1">
				<div class="consultation-grids">
	<div class="apply-form">
		<h5>Book Your Test</h5>
		<?php /* @include('layouts.error-sucess-messages') */?>
		<form action="{{url('bookingFormAction')}}" method="post" id="">
			  {{ csrf_field() }}
			<div class="admission-form11">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Full Name*" name="name" required="">
				</div>
				
				<div class="form-group">
					<input type="number" name="age" class="form-control mobile_no" placeholder="Age*" required="">
				</div>
<!-- 				
				<div class="form-group">
					<input type="radio" name="gender" value="0" class="" required="">Male </br> 
					<input type="radio" name="gender" value="0" class="" required="">Female
				</div> -->

				<!-- <div class="form-group">
					<input type="text" name="mobile" class="form-control mobile_no" placeholder="Phone Number*" required="">
				</div> -->

				<!-- <select class="form-control" name="city" required="">
					<option value="">City/Town</option>
					@foreach($city as $row)
					<option value="{{$row->id}}">{{$row->name}}</option>
					@endforeach
				</select> -->
			</div>
			<select class="form-control test_option" name="test" required="">
					<option value="">Select Test</option>
					<!-- @foreach($tests as $test)
					<option value="@php echo $test['TestID']; @endphp">@php echo $test['TestName']; @endphp</option>
					@endforeach -->
					<option value="1532" name="test">SARS COV 2 ANTIGEN TEST</option>
					<option value="1224" name="test">SARS-CoV2 (COVID-19) Real Time RT PCR </option>
					<option value="215" name="profile">PRE-EMPLOYMENT HEALTH CHECK UP</option>
					<option value="219" name="profile">JOB HEALTH FITMENT HEALTH SCREENING</option>
					<option value="225" name="profile">ANNUAL HEALTH SCREENING-FEMALE</option>
					<option value="224" name="profile">ANNUAL HEALTH SCREEN -MALE</option>
					<option value="1165" name="test">THYROID FUNCTION TEST</option>
					<option value="226" name="profile">DIABETIC SCREENING-ADVANCED</option>
					<option value="213" name="profile">LIPID PROFILE-COMPLETE</option>
					<option value="240" name="profile">LIVER FUNCTION-BASIC</option>
					<option value="241" name="profile">LIVER FUNCTION-ADVANCED</option>
					<option value="218" name="profile">DOMESTIC WORKER HEALTH SCREENING</option>
					<option value="1038" name="test">CHOLINESTERASE</option>
			</select>
			<input type="hidden" name="selectedTest" id="selectedTest" class="form-control">			
			<input type="hidden" name="selectedTestType" id="selectedTestType" class="form-control">
			<input type="hidden" name="selectedProfile" id="selectedProfile" class="form-control">
			<div class="form-group">
					<input type="text" name="bookDate" id="bookDate" class="form-control date_sel" placeholder="Date*" required="">
				</div>
				<div class="form-group">
					<input type="text" name="bookTime" id="bookTime" onchange="setTime(this)" class="form-control time_sel" placeholder="Time*" required="" autocomplete="off">
				</div>
				<input type="hidden" name="selectedDateAndTime" id="selectedDateAndTime" class="form-control">
				<label class="NOP" style="font-size: 12px;color: red;"></label>
			<button type="submit" class="btn btn-primary submit btn_appointmnt">
							<label for="" class="loadingLabel">Book Now</label>
							<img src="{{url('public/frontassets/images/img.svg')}}" alt="spinner" class="loadingIMG">			
			</button>
		</form>
	</div> 
				</div>
			</div>
		</div>
	</div>
  </div>
</div>
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#otpModal">
  Launch demo modal
</button> -->
<!-- Modal -->

<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verify OTP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form action="{{url('verifyOtp')}}" method="post" id="verifyOtpForm">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="modal-body">
        <div class="form-group">
									<input type="text" name="otp" class="form-control" placeholder="Enter otp*" required="">
								</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-primary" id="resendOtp">Resend</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
								<span class="modal-title" id="exampleModalLabel">Your Appointment has been booked successfully .</span>
								</div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary" id="resendOtp">Ok</button> -->
      </div>
    </div>
  </div>
</div>

	</section>

	<div class="modal fade" id="SignUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form action="{{url('Signup')}}" method="post" id="signUpForm">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="modal-body">
        <div class="form-group">
									<input type="text" name="name" class="form-control" placeholder="name *" required="">
								</div>
								<div class="form-group">
									<label for="">(Mobile Number will be your "Username")</label>
									<input type="text" name="mobilemnumber" class="form-control" placeholder="Mobile Number *" required="">
								</div>
								<div class="form-group">
									<input type="text" name="birthdate" id="birthdate" class="form-control" placeholder="Birth Date *" required="">
								</div>
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Enter Email *" required="">
								</div>
								<div class="form-group">
									<label for="gender">Gender *</label>
								<select name="gender" id="gender" required=""> 
										<option value="0">Male</option>
										<option value="1">Female</option>
								</select>
								<input type="hidden" name="namegender" id="idgender" value="0">
								</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
     </form>
    </div>
  </div>
</div>

	<!-- /main-slider -->
	<!-- //banner-slider-->
	<!-- /content-6-->
	<section class="w3l-content-6">
		<!-- /content-6-main-->
		<div class="content-6-mian py-5">
			<div class="container py-lg-5">
				<div class="title-content text-left mb-4">
					<h3 class="hny-title">Karibu Sana!</h3>
				</div>
				<div class="content-info-in row">
					<div class="content-gd col-lg-6 pl-lg-4">
						<p style="text-align: justify;padding-top: 20px;">Aafya.Care offers a total healthcare solution in helping the community in monitoring, maintaining and protecting one’s health.We’re here to put better health in your hands so you can feel your best today and long into the future.
                       Aafya.Care has been introduced to take care of mitigating the growing health risks. Understanding your daily routine, we are providing you Preventive Health Screening by vialsiting your place to collect sample as per your schedule.<br>

                            •	COVID 19 Test<br>
							•	Blood Test<br>
							•	Medical Check-Up<br>
							•	Online Medical Laboratory<br>
                       </p>
					</div>
					<div class="content-gd col-lg-6 pl-lg-4">
						<p style="text-align: justify;"> 
							Once the test is ordered, our qualified laboratory attendant visit you and take a blood sample.  Results are typically available within a couple of days (depending upon the test).  The results are sent directly to the individual but may also be forwarded to the individual’s physician upon request.  There are many benefits direct access lab testing has over the traditional process of going first to a doctor, who would then send the patient to a lab with a blood test referral.  Some of these benefits include preventive checkup, convenience, affordability, and confidentiality.
							Our aim is to provide you the services about your health care that you can rely on as being accurate.
                        </p>
					</div>

				</div>
		</div>
	</section>
	<!-- //content-6-->
	<!-- services block3 -->
	<div class="w3l-open-block-services py-5">
		<div class="container py-lg-5 pt-4">
			<div class="row">
				<div class="title-content text-center mb-5 col-md-12"> 
					<h3 class="hny-title mb-5">Most Trusted Diagnostics. Most Affordable Rates</h3>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-signal service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">Accredited <br>Labs</h4>
						<div class="open-description">
							<p>Certified by Office of the Director General of Health under Ministry of Health to Test Covid 19 and concerned tests from relevant Govenment departments.</p> 
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 mt-md-0 mt-5 pt-md-0 pt-3">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-assistive-listening-systems service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">Fast & Accurate <br>Reports</h4>
						<div class="open-description">
							<p>No need to follow up or spend time on transportation. A hassle free Report on your whatsapp! Just relax at your home to serve you in fastest possible way! </p> 
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 mt-lg-0 mt-5 pt-lg-0 pt-3">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-diamond service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">FREE Sample<br> Collection</h4>
						<div class="open-description" style="padding-bottom: 25px;">
							<p>Just fill the form & relax! our trained Technician will visit your place as per your prescribed schedule and take the Sample!</p> 
							<p></p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 mt-lg-0 mt-5 pt-lg-0 pt-3">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-magic service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">SAFE & <br>Hygiene</h4>
						<div class="open-description" style="padding-bottom: 25px;">
							<p>Our lab environment or processes are fully scientific, safe, secure to ensure we must handle every test at utmost care.</p>
							<p></p> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- /w3l-content-with-photo-4-->
	<section class="w3l-content-with-photo-4">
		<!-- /content-grids-->
		<div class="content-photo-info py-5"> 
			<div class="title-content text-left mb-lg-5 mt-4"> 
				<h3 class="hny-title text-center">Other Available Tests</h3>
			</div>
			<div class="container">
				<div class="row row-flex">
					@foreach($courses as $row)
			        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
			            <div class="price-table pt-bg-black">
			                <div>
			                    <span>{{$row->course_name}}</span>
			                    <span>Price Ksh {{$row->dis_price}}</span>
			                    <span>Features included!</span>
			                </div>
			                <div class="text-center" style="text-align: center;">
			                <p><?php echo $row->description; ?>
																			</p>
																			</div>
			                <a onclick="addProfile(this)" id="{{$row->id}}">purchase</a>
			            </div>
			        </div>
			        @endforeach
			      
		    	</div>
		    </div>
		</div>
	</section>
	<!-- /Covid-6-->
	<section class="covid">
		<div class="container">
			<div class="row">
				<div class="col-md-12 mb-5">
					<h3 class="text-center">Aafya.Care possess some of the world's most complicated machines which automate the blood checking process. Meaning minimal touching of blood vials by human hands. Safety procedures here are:</h3>
				</div>
				<div class="col-md-6">
					<div class="covid_inner">
						<img src="{{url('public/frontassets/images/ppe.png')}}">
						<h4 class="text-center">Mandatory use of Personal Protective Equipment (PPE) at all times + It’s daily sanitization.</h4>
					</div>
				</div>

				<div class="col-md-6">
					<div class="covid_inner">
						<img src="{{url('public/frontassets/images/sd-2-meter.png')}}">
						<h4 class="text-center">Mandatory social distance of 2 meter between lab technicians</h4>
					</div>
				</div>
				<div class="col-md-6">
					<div class="covid_inner">
						<img src="{{url('public/frontassets/images/decontamination.png')}}">
						<h4 class="text-center">Mandatory decontamination of phlebetomy room after each sample collection.</h4>
					</div>
				</div>

				<div class="col-md-6">
					<div class="covid_inner">
						<img src="{{url('public/frontassets/images/sanitization.png')}}">
						<h4 class="text-center">Periodic decontamination / sanitization of all surfaces.</h4>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /Covid-6-->
	<!--Testinomial-->
	<section class="testimonial text-center">
        <div class="container">
            <div class="heading white-heading">
                Testimonials
            </div>
            <div id="testimonial4" class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x swipe_x" data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="2000">
             
                <div class="carousel-inner" role="listbox">

                	 @php $i = 0; @endphp
					   @foreach($testimonial as $test)
					    @php $i++; @endphp
                    <div class="carousel-item @if($i==1) active @endif">
                        <div class="testimonial4_slide">
                            <img src="{{url('public/testimonial/'.$test->image)}}" class="img-circle img-responsive" />
                             <h4><?php echo $test->title; ?></h4>
                            <p><?php echo $test->description; ?></p>
                           
                        </div>
                    </div>
                     @endforeach
                  
                </div>
                <a class="carousel-control-prev" href="#testimonial4" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#testimonial4" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </div>
    </section>
	
	<!-- end testimonial section -->

	<!-- footer-66 -->
	<footer class="w3l-footer-66">
		<div class="cpy-right py-3">

			<p class="text-center">
				<a href="{{url('laboratory-registration')}}">Laboratory Registration</a>
			</p>

			<p class="text-center">
				<a href="{{url('sample-collector-registration')}}">Sample Collector Registration</a>
			</p>

			<p class="text-center">
				<a href="{{url('telecaller-registration')}}">Employee Registration</a>
			</p>

			<p class="text-center" style="font-size: 8px;">
				<a href="javascript:void(0)">A Part of Zeta Healthcare Limited</a>
			</p>

		</div>

		
		<!-- move top -->
		<button onclick="topFunction()" id="movetop" title="Go to top">
			<span class="fa fa-level-up"></span>
		</button>


		<script>
			// When the user scrolls down 20px from the top of the document, show the button
			window.onscroll = function () {
				scrollFunction()
			};

			function scrollFunction() {
				if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
					document.getElementById("movetop").style.display = "block";
				} else {
					document.getElementById("movetop").style.display = "none";
				}
			}

			// When the user clicks on the button, scroll to the top of the document
			function topFunction() {
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
			}
		</script>
		<!-- /move top -->
	</footer>
	<!--//footer-66 -->
	<div class="pun"><!-- Place at bottom of page --></div>
	<style>
		/* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.pun {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading .pun {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .pun {
    display: block;
}
	</style>
</body>

</html>

<script src="{{url('public/frontassets/js/jquery-3.3.1.min.js')}}"></script>
<!-- disable body scroll which navbar is in active -->

<!--//-->
<script>
	$(function () {
		$('.navbar-toggler').click(function () {
			$('body').toggleClass('noscroll');
		})
	});

	$('select.test_option').on('change', function() {
  // alert( this.value );
		$("#selectedTest").val(this.value);
		$("#selectedTestType").val(this.name);

});
</script>
<!--/scroll-down-JS-->
<!-- stats -->
<script src="{{url('public/frontassets/js/jquery.waypoints.min.js')}}"></script>
<script src="{{url('public/frontassets/js/jquery.countup.js')}}"></script>
<script>
	$('.counter').countUp();
</script>
<!-- //stats -->
<script src="{{url('public/frontassets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script>
	$('select[name="gender"]').change(function(){

		var value = $(this).val()
		$("#idgender").val(value)
})
</script>

<script type="text/javascript">
	$('.carousel').carousel({
  interval: 2000
})
</script>


@if (session()->has('success_message'))
  @if(session()->get('success_message')=="Success")
	 <script type="text/javascript">
	   $(document).ready(function () {
	        $('#otpModal').modal('show');

}); 
	    </script>
    @endif	
 @endif

	@if (session()->has('success_email'))
  @if(session()->get('success_email')=="Appointment Booked .")
	 <script type="text/javascript">
	   $(document).ready(function () {
	        $('#successModal').modal('show');

}); 
	    </script>
    @endif
 @endif

	@if (session()->has('myUserData'))
	 <script type="text/javascript">
	   $(document).ready(function () {
	        $('#home').show();
									$('#home1').hide();

}); 
	    </script>
 @endif

  <script type="text/javascript">
			
			var nop = JSON.parse(localStorage.getItem('pros'));
			$('.NOP').text("Number of Profiles selected : " + nop.length == 0 || nop.length == null ? "0" : nop.length)

	   $(document).ready(function () {
	   $('#verifyOtpForm').on('submit',function(e) {
        e.preventDefault();
            var url = $(this).attr('action'),
            post = $(this).attr('method'),
            data = new FormData(this);

            $.ajax({
                url: url,
                method: post,
                data: data,
                dataType: "json",
                success: function(data){
                     var message = data.message;
                     if(data.status ==1){
                       alert(message);
					   $('#otpModal').modal('hide');
					   location.reload(true);
					}else{
                        alert(message);
                    }
                },
                error: function(xhr, status, error){
                    alert(xhr.responseText);
                },
                processData: false,
                contentType: false
            });
        }); 



	   
	   $("#resendOtp").click(function(){

            $.ajax({
               url:"{{url('resendOtp')}}",
                method: 'GET',
                dataType: "json",
                success: function(data){
                     var message = data.message;
                     if(data.status ==1){
                       alert(message);
					}else{
                        alert(message);
                    }
                },
                error: function(xhr, status, error){
                    alert(xhr.responseText);
                },
                processData: false,
                contentType: false
            });
     
	});

}); 

</script>


<script src="{{url('public/frontassets/js/bootstrap.min.js')}}"></script>
<script src="{{url('public/frontassets/js/jquery.datetimepicker.full.min.js')}}"></script>
<link rel="stylesheet" href="{{url('public/frontassets/css/jquery.datetimepicker.css')}}">
<link rel="stylesheet" href="https://unpkg.com/js-datepicker/dist/datepicker.min.css">

<script src="https://unpkg.com/js-datepicker"></script>
<script>
	$(".btn_appointmnt").click(function() {
				document.getElementsByClassName('loadingIMG').style.display = 'block';
    document.getElementsByClassName('loadingLabel').style.display = 'none';		
	})
</script>
<script>
    // const datepicker = require('js-datepicker')
    const picker = datepicker('#bookDate', {
        // Event callbacks.
        onSelect: instance => {
            // Show which date was selected.
            console.log(instance.dateSelected)
        },

        onShow: instance => {
            // console.log('Calendar showing.')
        },

        onHide: instance => {
            // console.log('Calendar hidden.')
        },

        onMonthChange: instance => {
            // Show the month of the selected date.
            // console.log(instance.currentMonthName)
        },

        // Customizations.
        formatter: (input, date, instance) => {
            // This will display the date as `1/1/2019`.
            const v = date.toLocaleDateString()
            var dob = v.split("/")
            var b = dob[1] + "-" + dob[0] + "-" + dob[2]
												
            input.value = b
            $("#bookDate").html(b);

        },

        position: 'bl', // Top right.
        startDay: 1, // Calendar week starts on a Monday.
        customDays: ['S', 'M', 'T', 'W', 'Th', 'F', 'S'],
        customMonths: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        overlayButton: 'Go!',
        overlayPlaceholder: 'Enter a 4-digit year',

        // Settings.
        alwaysShow: false, // Never hide the calendar.
        dateSelected: new Date(), // Today is selected.
        maxDate: new Date(2099, 0, 1), // Jan 1st, 2099.
        minDate: new Date(1900, 1, 1), // June 1st, 2016.
        startDate: new Date(), // This month.
        showAllDates: true, // Numbers for leading & trailing days outside the current month will show.

        // Disabling things.
        noWeekends: false, // Saturday's and Sunday's will be unselectable.
        disabledDates: [new Date(2050, 0, 1), new Date(2050, 0, 3)], // Specific disabled dates.
        disableMobile: true, // Conditionally disabled on mobile devices.
        disableYearOverlay: false, // Clicking the year or month will *not* bring up the year overlay.

        // ID - be sure to provide a 2nd picker with the same id to create a daterange pair.
        id: 2
    })
    picker.calendarContainer.style.setProperty('font-size', '1.0rem')
</script>

<script>
    // const datepicker = require('js-datepicker')
    const dtpicker = datepicker('#birthdate', {
        // Event callbacks.
        onSelect: instance => {
            // Show which date was selected.
            console.log(instance.dateSelected)
        },

        onShow: instance => {
            // console.log('Calendar showing.')
        },

        onHide: instance => {
            // console.log('Calendar hidden.')
        },

        onMonthChange: instance => {
            // Show the month of the selected date.
            // console.log(instance.currentMonthName)
        },

        // Customizations.
        formatter: (input, date, instance) => {
            // This will display the date as `1/1/2019`.
            const v = date.toLocaleDateString()
            var dob = v.split("/")
												var c = dob[0] + "-" + dob[1] + "-" + dob[2]
												
												$("#birthdate").val(c);

        },

        position: 'bl', // Top right.
        startDay: 1, // Calendar week starts on a Monday.
        customDays: ['S', 'M', 'T', 'W', 'Th', 'F', 'S'],
        customMonths: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        overlayButton: 'Go!',
        overlayPlaceholder: 'Enter a 4-digit year',

        // Settings.
        alwaysShow: false, // Never hide the calendar.
        dateSelected: new Date(), // Today is selected.
        maxDate: new Date(2099, 0, 1), // Jan 1st, 2099.
        minDate: new Date(1850, 1, 1), // June 1st, 2016.
        startDate: new Date(), // This month.
        showAllDates: true, // Numbers for leading & trailing days outside the current month will show.

        // Disabling things.
        noWeekends: false, // Saturday's and Sunday's will be unselectable.
        disabledDates: [new Date(2050, 0, 1), new Date(2050, 0, 3)], // Specific disabled dates.
        disableMobile: true, // Conditionally disabled on mobile devices.
        disableYearOverlay: false, // Clicking the year or month will *not* bring up the year overlay.

        // ID - be sure to provide a 2nd picker with the same id to create a daterange pair.
        id: 2
    })
    picker.calendarContainer.style.setProperty('font-size', '1.0rem')
</script>

<script>
    $('#bookTime').datetimepicker({
        datepicker: false,
        timepicker: true,
        formatDate: 'Y/m/d',
        format: 'H:i',
        step: 5,
    });

    function setTime() {
        var bookTime = $('#bookTime').val();
        bookTime = bookTime + ":00"
        var bookDate = $('#bookDate').val();
        var da = bookDate.split("-");
        var dat = da[2] + "-" + da[1] + "-" + da[0];
        bookDate = dat + " " + bookTime;
        $("#selectedDateAndTime").val(bookDate);
    }
</script>
<!-- ************** -->

<script>
	// ***********************
	$('#loginotp').on('submit', function(e) {
		e.preventDefault();
		var url = $(this).attr('action');
			var post = $(this).attr('method');
		var enteredNumber = document.getElementById("mobileNumber").value;
		url = url+"?number="+enteredNumber+""
		
		// console.log(url);
		// console.log(post);
		// console.log(newUser);

		$.ajax({
			url: url,
			method: "GET",
			dataType: "json",
			beforeSend: function(){
				$('.loadingIMG').show();
				$('.loadingLabel').hide();
			},
			success: function(data) {
				var daataa = data.d;
				console.log(data);
				// var message = data.message;
				if (daataa.Result == "Success") {
					localStorage.setItem("UserData", JSON.stringify(daataa));
					$("#form1").hide();
					$("#form2").show();
					$("#home").hide();
				} else {
						alert("OTP not working. Please contact zeta Healthcare .")
				}
			},
			complete: function(){
				$('.loadingIMG').hide();
				$('.loadingLabel').show();
			},
			error: function(xhr, status, error) {
				alert(xhr.responseText);
			},
			processData: false,
			contentType: false
		});
	});

</script>
<!-- ************** -->

<script>
	$('#loginotp1').on('submit', function(e) {
		e.preventDefault();
			var mainOTP = document.getElementById("mobileOtp").value;
			var mainUser = JSON.parse(localStorage.getItem("UserData"));


		if (mainOTP == "") {
			alert("Please enter OTP");
		} else if (mainUser.UserName != "" && mainOTP != "") {
			var varifyOTP = 
			{
				"objSP": {
						"Task": 2,
						"UserName": mainUser.UserName,
						"OTP": mainOTP
				}
			}
			var url = "{{url('ValidateOTP')}}"

				$.ajax({
				cache: false,
				type: "GET",
				url: url +"?otp="+mainOTP+"",
				beforeSend: function(){
				$('.loadingIMG').show();
				$('.loadingLabel').hide();
				},
				data: JSON.stringify(varifyOTP),
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function(obj) {
					// alert(obj)
					var values = obj.d;
					if (values.Result == "Success.") {
						alert("You are now logged In .");
						$("#form1").hide();
						$("#home1").hide();
						$("#form2").hide();
						$("#home").show();
						$("#UnameTitle").text(values.ShortName);
						localStorage.setItem("myUserData", JSON.stringify(values));
						window.location.reload();
					} else {
						if (values.Result == "OTP is Not Matched.") alert("Please Enter Valid OTP");
						else {
							alert("Something Wrong");
						}
					}
				},
				complete: function(){
				$('.loadingIMG').hide();
				$('.loadingLabel').show();
			},
			});

			}
	});
	// 	function validateOTP() {
	// 		var mainOTP = document.getElementById("mobileOtp").value;
	// 		var mainUser = JSON.parse(localStorage.getItem("UserData"));


	// 	if (mainOTP == "") {
	// 		alert("Please enter OTP");
	// 	} else if (mainUser.UserName != "" && mainOTP != "") {
	// 		var varifyOTP = {
	// 			"objSP": {
	// 				"Task": 2,
	// 				"UserName": mainUser.UserName,
	// 				"OTP": mainOTP,
	// 			}
	// 		}

	// 			$.ajax({
	// 			cache: false,
	// 			type: "POST",
	// 			url: "{{url('ValidateOTP')}}",
	// 			beforeSend: function() {},
	// 			data: JSON.stringify(varifyOTP),
	// 			dataType: "json",
	// 			contentType: "application/json; charset=utf-8",
	// 			success: function(obj) {
	// 				// var values = obj.d;
	// 				// if (values.Result == "Success.") {
	// 				// 	alert("OTP matched!!!!");
	// 				// 	$("#form1").hide();
	// 				// 	$("#form2").hide();
	// 				// 	$("#form3").show();
	// 				// 	$("#UnameTitle").text(values.ShortName);
	// 				// 	localStorage.setItem("veinRes", JSON.stringify(values));
	// 				// 	window.location.reload();
	// 				// } else {
	// 				// 	if (res == "OTP is Not Matched.") alert("Please Enter Valid OTP");
	// 				// 	else {
	// 				// 		alert("Something Wrong");
	// 				// 	}
	// 				// }
	// 			},
	// 		});

	// 		}
	// }

	function Logout() 
	{

		var url = "{{url('Logout')}}"
		$.ajax({
				cache: false,
				type: "GET",
				url: url,
				beforeSend: function() {},
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function(obj) {
					// alert(obj)
						localStorage.removeItem('myUserData');
						localStorage.removeItem('pros');
						window.location.reload();
				},
			});
	}

	function addProfile(elem)
	{
						var iiD = $(elem).attr("id")
						var zetaPorfiles = JSON.parse(localStorage.getItem('pros'));

						if(zetaPorfiles != null)
							{
									if(zetaPorfiles.includes(iiD))
									{
										let index = zetaPorfiles.indexOf(iiD);
											$(elem).text("Purchased");
											$(elem).css('color', 'red');
									}else {
										zetaPorfiles.push(iiD);
										$('.NOP').text("Number of Profiles selected : " + zetaPorfiles.length)
										localStorage.setItem('pros',JSON.stringify(zetaPorfiles))
										$("#selectedProfile").val(zetaPorfiles.toString());
									}
						}
						else 
						{
							zetaPorfiles = [iiD];
							$('.NOP').text("Number of Profiles selected : " + zetaPorfiles.length)
							localStorage.setItem('pros',JSON.stringify(zetaPorfiles))
							$("#selectedProfile").val(zetaPorfiles.toString());
						}

							$(elem).text("Purchased");
							$(elem).css('color', 'red');
													
						// var url = "{{url('cartprofiles')}}"
						// $.ajax({
						// 		cache: false,
						// 		type: "GET",
						// 		url: url+"?profiles="+zetaPorfiles.toString()+"",
						// 		beforeSend: function() {},
						// 		dataType: "json",
						// 		contentType: "application/json; charset=utf-8",
						// 		success: function(obj) {
						// 			// alert(obj)
						// 			$(elem).text("Purchased");
						// 			$(elem).css('color', 'red')
						// 		},
						// 	});
						// window.location.reload();
	}
</script>