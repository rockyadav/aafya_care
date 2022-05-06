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
                <a class="navbar-brand" href="{{url('/')}}">
                    <!-- if logo is image enable this  -->
                    <a class="navbar-brand" href="{{url('/')}}">
                        <img src="{{url('public/frontassets/images/logo.png')}}" alt="logo" title="logo" style="width: 200px;" />
                    </a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa icon-expand fa-bars"></span>
                        <span class="fa icon-close fa-times"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="call-support">
                            <!-- <p>Call us for any question</p>
						<h5>121-345-64369</h5> -->
                        </div>
                    </div>
            </div>
        </nav>
        <!--//nav-->
    </header>
    <!-- //w3l-header -->

    <section class="w3l-main-slider11" id="home1">
        <div class="banner-content banner-view">
            <div class="container">
                <div class="row">
                    <h4>Sample Collector Registration</h4>
                </div>
                <br>
                <div class="col-md-12">
                    @include('layouts.error-sucess-messages')
                    <form action="{{url('sample_collector_action')}}" method="post" id="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row setup-content" id="step-1">
                            <div class="offset-md-2 col-md-8">
                                <div class="setup_inner">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input name="name" type="text" value="{{old('name')}}" class="form-control txt_Space" placeholder="Enter Name" required="" />
                                                @if ($errors->has('name'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input maxlength="100" name="mobile" value="{{old('mobile')}}" type="text" class="form-control aphone" placeholder="Enter Phone Number" required="" />
                                                <span class="error-block error_mobile">
                                                    <strong></strong>
                                                </span>
                                                @if ($errors->has('mobile'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('mobile') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input name="email" type="email" id="user_email" class="form-control" placeholder="Enter Email" value="{{old('email')}}" required="" />
                                                <span class="error-block error_email"><strong></strong></span>
                                                @if ($errors->has('email'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">City</label>
                                                <select class="form-control" name="city" required="">
                                                    <option>Select city</option>
                                                    @foreach($city as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('city'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Laboratory</label>
                                                <select class="form-control" name="lab_name" required="">
                                                    <option>Select laboratory</option>
                                                    @foreach($laboratory as $row)
                                                    <option value="{{$row->id}}">{{$row->lab_name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('lab_name'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('lab_name') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Highest Qualification</label>
                                                <input name="qualification" type="text" class="form-control" placeholder="Enter Highest  Qualification" required="" value="{{old('qualification')}}" />
                                                @if ($errors->has('qualification'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('qualification') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">National Id</label>
                                                <input name="national_id" type="text" class="form-control" placeholder="Enter National Id" required="" value="{{old('national_id')}}" />
                                                @if ($errors->has('national_id'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('national_id') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <textarea name="address" type="text" class="form-control" placeholder="Enter Address" required="" />{{old('address')}}</textarea>
                                                @if ($errors->has('address'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Your Picture (jpg,png,jpeg Only)</label>
                                                <input name="image" type="file" class="form-control" required="" />
                                                @if ($errors->has('image'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Educational Certificate (PDF,DOC Only)</label>
                                                <input name="certificate" type="file" class="form-control" required="" />
                                                @if ($errors->has('certificate'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('certificate') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <h4>Reference</h4>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Reference Name</label>
                                                <input name="reference_name" type="text" value="{{old('reference_name')}}" class="form-control" placeholder="Enter reference name" />
                                                @if ($errors->has('reference_name'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('reference_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Reference ID No.</label>
                                                <input name="reference_id_no" type="text" value="{{old('reference_id_no')}}" class="form-control" placeholder="Enter Reference ID No" />
                                                @if ($errors->has('reference_id_no'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('reference_id_no') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Reference Phone No</label>
                                                <input name="reference_phone_no" type="text" value="{{old('reference_phone_no')}}" class="form-control" placeholder="Enter Reference Phone No" />
                                                @if ($errors->has('reference_phone_no'))
                                                <span class="error-block">
                                                    <strong>{{ $errors->first('reference_phone_no') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

    </section>

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

            <p class="text-center">
                <a href="http://zetatest.elabassist.com/">Partner Laboratory Login</a>
            </p>

            <p class="text-center" style="font-size: 8px;">
                <a href="javascript:void(0)">A Part of Zeta Healthcare Limited</a>
            </p>
            <p>
                <a href="https://www.facebook.com/pg/AafyaCare/shop/?referral_code=page_shop_tab&preview=1" target="_blank">
                    <img style="float:right;margin-top:-66px;margin-right:75px;" src="{{url('public/frontassets/images/icon_facebook.png')}}" alt="">
                </a>
            </p>

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
<script type="text/javascript">
    $(document).ready(function() {
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',

            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });

        $('.popup-with-move-anim').magnificPopup({
            type: 'inline',

            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-slide-bottom'
        });
    });
    $('.carousel').carousel({
        interval: 2000
    })
</script>


<!-- //script for Testimonials-->
<!-- //script -->

<script src="{{url('public/frontassets/js/bootstrap.min.js')}}"></script>