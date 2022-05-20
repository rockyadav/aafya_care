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
	<link href="//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700&display=swap" rel="stylesheet">
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
						<div class="top-bar-text text-center"><a class="bk-button" href="#">REPORTS</a></div>
					</div>

					<div class="social-top col-lg-4 mt-lg-0 mt-sm-6">
						@php $user = session('myUserData'); @endphp
						<div class="top-bar-text text-right"> You are IN <b><i> @php echo $user['UserName']; @endphp ! </i></b>
							<a class="bk-button" href="#" onclick="Logout()">Logout</a>
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
						<img src="{{url('public/frontassets/images/logo.png')}}" alt="logo" title="logo" style="width: 200px;" />
						<!-- height: 70px; -->
					</a>
					<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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

						<!-- <div class="tillnoblock2">
						<img style="height: 40px;width: 80px;" src="{{url('public/frontassets/images/mpesa.jpeg')}}" alt="">
					</div> -->
						<div class="call-support">
							<p>Call us for any question</p>
							<h6>+254 103 333 444</h6>

							<!-- <div class="tillnoblock">
								<p class="tillno">Till No .</p>
								<h6 class="tillno">9565005</h6>

							</div> -->
						</div>
					</div>
			</div>
		</nav>
		<!--//nav-->
	</header>
	<!-- //w3l-header -->

	<!-- services block3 -->
	<div class="w3l-open-block-services py-5">
		<div class="container py-lg-5 pt-4">
			@php $count = 1; @endphp

			@foreach($myreports as $repo)
			@if($count == 1)

			<div class="row mt-30 mb-30">
				<div class="col-lg-3 col-md-6">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-signal service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">@php echo $repo['PatientName']; @endphp</h4>
						<p>
							Tests :- @php echo $repo['TotalTestList']; @endphp
						</p>
						<div class="open-description">
							<p></p>
							<button class="btn btn-primary btnReport" url="@php echo $repo['PDFFileName']; @endphp" id="@php echo $repo['TestRegnID']; @endphp" style="margin-top: 25px;">Report</button>
						</div>
					</div>
				</div>
				@php $count += 1; @endphp
				@elseif($count == 2)

				<div class="col-lg-3 col-md-6 mt-md-0 mt-5 pt-md-0 pt-3">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-assistive-listening-systems service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">@php echo $repo['PatientName']; @endphp</h4>
						<p>
							Tests :- @php echo $repo['TotalTestList']; @endphp
						</p>
						<div class="open-description">
							<!-- <p>No need to follow up or spend time on transportation. A hassle free Report on your whatsapp! Just relax at your home to serve you in fastest possible way! </p>  -->
							<button class="btn btn-primary btnReport" url="@php echo $repo['PDFFileName']; @endphp" id="@php echo $repo['TestRegnID']; @endphp" style="margin-top: 25px;">Report</button>
						</div>
					</div>
				</div>
				@php $count += 1; @endphp
				@elseif($count == 3)

				<div class="col-lg-3 col-md-6 mt-lg-0 mt-5 pt-lg-0 pt-3">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-diamond service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">@php echo $repo['PatientName']; @endphp</h4>
						<p>
							Tests :- @php echo $repo['TotalTestList']; @endphp
						</p>
						<div class="open-description" style="padding-bottom: 25px;">
							<!-- <p>Just fill the form & relax! our trained Technician will visit your place as per your prescribed schedule and take the Sample!</p> 
							<p></p> -->
							<button class="btn btn-primary btnReport" url="@php echo $repo['PDFFileName']; @endphp" id="@php echo $repo['TestRegnID']; @endphp" style="margin-top: 25px;">Report</button>
						</div>
					</div>
				</div>
				@php $count += 1; @endphp
				@elseif($count == 4)

				<div class="col-lg-3 col-md-6 mt-lg-0 mt-5 pt-lg-0 pt-3">
					<div class="card text-center">
						<div class="icon-holder">
							<span class="fa fa-magic service-icon" aria-hidden="true"></span>
						</div>
						<h4 class="mission">@php echo $repo['PatientName']; @endphp</h4>
						<p>
							Tests :- @php echo $repo['TotalTestList']; @endphp
						</p>
						<div class="open-description" style="padding-bottom: 25px;">
							<!-- <p>Our lab environment or processes are fully scientific, safe, secure to ensure we must handle every test at utmost care.</p>
							<p></p>  -->
							<button class="btn btn-primary btnReport" url="@php echo $repo['PDFFileName']; @endphp" id="@php echo $repo['TestRegnID']; @endphp" style="margin-top: 25px;">Report</button>
						</div>
					</div>
				</div>
			</div>
			@php $count = 1; @endphp
			@endif
			@endforeach
			@if($count == 2 || $count == 3 || $count == 4)
		</div>
		@endif
		<!-- <div class="row">
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
			</div> -->
	</div>
	</div>

	<!-- footer-66 -->
	<footer class="w3l-footer-66">
		<div class="cpy-right py-3" style="position: relative;">
			<div class="row">
				<div class="col-sm-4 col-lg-4 col-md-4">
					<p class="text-center" style="position: absolute; bottom: 17px;">
						<a href="#">
							<img style="height: 100px;width: 170px;" src="{{url('public/frontassets/images/mpesa-removebg-preview.png')}}" alt="">
						</a>
						<label for="Till No : ">Till No : <strong>9565005</strong></label>

					</p>
				</div>
				<div class="col-sm-4 col-lg-4 col-md-4">
					<p class="text-center">
						<a href="{{url('laboratory-registration')}}">Laboratory Registration</a>
					</p>

					<p class="text-center">
						<a href="{{url('sample-collector-registration')}}">Sample Collector Registration</a>
					</p>

					<p class="text-center">
						<a href="{{url('telecaller-registration')}}">Employee Registration</a>
					</p>

					<p class="text-center">
						<a href="http://zetatest.elabassist.com/">Partner Laboratory Login</a>
					</p>
					<p class="text-center" style="font-size: 8px;">
						<a href="javascript:void(0)">A Part of Zeta Healthcare Limited</a>
					</p>
				</div>
				<div class="col-sm-4 col-lg-4 col-md-4">
					<p>
						<a href="{{url('public/frontassets/apk/Zeta-06-02-22.apk.apk')}}" download="Zeta-06-02-22.apk.apk">
							<img style="float:right;margin-right:75px;margin-top:5px;" src="{{url('public/frontassets/images/playstore.png')}}" alt="playstore logo">
						</a>
					</p>
					<p class="text-center">
						<a href="https://www.facebook.com/pg/AafyaCare/shop/?referral_code=page_shop_tab&preview=1" target="_blank">
							<img style="float:right;margin-right:15px;" src="{{url('public/frontassets/images/icon_facebook.png')}}" alt="fb logo">
						</a>
					</p>

				</div>
			</div>
		</div>


		<!-- move top -->
		<button onclick="topFunction()" id="movetop" title="Go to top">
			<span class="fa fa-level-up"></span>
		</button>


		<script>
			// When the user scrolls down 20px from the top of the document, show the button
			window.onscroll = function() {
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
	$(function() {
		$('.navbar-toggler').click(function() {
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


@if (session()->has('success_message'))
@if(session()->get('success_message')=="Success")
<script type="text/javascript">
	$(document).ready(function() {
		$('#otpModal').modal('show');

	});
</script>
@endif
@endif

@if (session()->has('success_email'))
@if(session()->get('success_email')=="Success")
<script type="text/javascript">
	$(document).ready(function() {
		$('#successModal').modal('show');

	});
</script>
@endif
@endif

@if (session()->has('myUserData'))
<script type="text/javascript">
	$(document).ready(function() {
		$('#home').show();
		$('#home1').hide();

	});
</script>
@endif

<!-- <script src="{{url('public/frontassets/js/bootstrap.min.js')}}"></script> -->

<script>
	$('.btnReport').click(function() {

		// var pdf = $(this).attr("url");
		// filename = pdf.replace("~", "");
		// filename ='http://zetatest.elabassist.com/'+ filename;
		// window.open(filename);


		var TestRegnID = $(this).attr('id');

		$.ajax({
			cache: false,
			type: "GET",
			beforeSend: function() {},
			url: 'http://zetatest.elabassist.com/Services/Test_RegnService.svc/GetReleaseTestReport_Global',
			data: {
				LabID: "a76aeb22-c144-4748-a75c-9ba45ea80d8c",
				UserTypeID: 1,
				TestRegnID: TestRegnID,
			},
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			success: function(objresult) {
				if (objresult) {
					var objres = objresult.d[0];
					if (objres) {

						if (objres.PdfName != "") {
							var filename = objres.PdfName.replace("../", "");
							filename = filename.replace("~", "");
							filename = 'http://zetatest.elabassist.com/' + filename;
							window.open(filename);
							// w.document.title = "PDF Report";
							// w.document.location.href = filename;
						} else {
							alert("Error to Load PDF for Registration.");
						}
					}
				} else {
					console.log('Error To retrive Data');
					alert("Error to Load PDF for Registration.");
				}
			},
			error: function(result) {
				alert("Login Failed. Please try Again.");
			}
		});

	});

	function loadReportList() {
		$.ajax({
			cache: false,
			type: "GET",
			url: url + "?otp=" + mainOTP + "",
			beforeSend: function() {},
			data: JSON.stringify(varifyOTP),
			dataType: "json",
			contentType: "application/json; charset=utf-8",
			success: function(obj) {
				// alert(obj)
				var values = obj.d;
				if (values.Result == "Success.") {
					alert("OTP matched!!!!");
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
		});
	}

	function Logout() {

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
				window.location = '{{url("HomeController")}}';
			},
		});
	}
</script>