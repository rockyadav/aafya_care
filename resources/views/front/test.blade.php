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
	<link rel="stylesheet" href="{{url('public/frontassets/css/custom.css')}}">
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
</style>

<body>
	<!--w3l-header-->
	<section class="w3l-top-header-content">
		<div class="hny-top-menu">
			<div class="container">
				<div class="row">
					<div class="social-top col-lg-12 mt-lg-0 mt-sm-6">
						<div class="top-bar-text text-center"><a class="bk-button" href="#">BOOK ONLINE </a> You can
							request appointment now !</div>
					</div>

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
							<img src="{{url('public/frontassets/images/logo.png')}}" alt="logo" title="logo" style="height: 70px;width: 200px;"/>
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
					
					<div class="call-support">
						<p>Call us for any question</p>
						<h6>+254 745 889 399 |  728 929 256</h6>
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
	<section class="w3l-main-slider" id="home">
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
					<input type="text" name="mobile" class="form-control mobile_no" placeholder="Phone Number*" required="">
				</div>

				<select class="form-control" name="city" required="">
					<option value="">City/Town</option>
					@foreach($city as $row)
					<option value="{{$row->id}}">{{$row->name}}</option>
					@endforeach
				</select>
			</div>
			<select class="form-control test_option" name="test" required="">
					<option value="">Select Test</option>
					@foreach($courses as $row)
					<option value="{{$row->id}}">{{$row->course_name}}</option>
					@endforeach
			</select>
			<button type="submit" class="btn btn-primary submit">Book Now</button>
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
	   {{ csrf_field() }}
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

	</section>
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
			                    <span>Price Ksh{{$row->dis_price}}</span>
			                    <span>Features included!</span>
			                </div>
			                <div class="text-center" style="text-align: center;">
			                <p><?php echo $row->description; ?>
						  </p>
						  </div>
			                <a href="#">purchase</a>
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
				<a href="javascript:void(0)">A Part of TNH</a>
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



  <script type="text/javascript">
	   $(document).ready(function () {
	   $('#verifyOtpForm').on('submit',function(e){
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