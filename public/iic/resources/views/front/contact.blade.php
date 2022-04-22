@extends('layouts.frontTemplate')
@section('content') 
<!-- Main content Start -->
<div class="main-content">
            <!-- Breadcrumbs Section Start -->
            <div class="rs-breadcrumbs bg-6">
                <div class="container">
                    <div class="content-part text-center">
                        <h1 class="breadcrumbs-title white-color mb-0">Contact</h1>
                    </div>
                </div>
            </div>
            <!-- Breadcrumbs Section End -->

            <!-- Contact Section Start -->
            <div id="rs-contact" class="rs-contact inner pt-100 md-pt-80">
                <div class="container">
                    <div class="content-info-part mb-60">
                        <div class="row gutter-16">
                            <div class="col-lg-4 md-mb-30">
                                <div class="info-item">
                                    <div class="info-inner">
                                        <div class="icon-part">
                                            <i class="fa fa-at"></i>
                                        </div>
                                        <div class="content-part">
                                            <h4 class="title">Phone Number</h4>
                                            <a href="tel:+60322823627">+60322823627</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 md-mb-30">
                                <div class="info-item">
                                    <div class="info-inner">
                                        <div class="icon-part">
                                            <i class="fa fa-envelope-o"></i>
                                        </div>
                                        <div class="content-part">
                                            <h4 class="title">Email Address</h4>
                                            <a href="mailto:info@iic2u.com">info@iic2u.com</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="info-item">
                                    <div class="info-inner">
                                        <div class="icon-part">
                                            <i class="fa fa-map-o"></i>
                                        </div>
                                        <div class="content-part">
                                            <h4 class="title">Office Address</h4>
                                            <p>No. 1, Floor 13, Tower C, Wisma Goshen, Plaza Pantai 5, Persiaran Pantai Baru Off Jalan Pantai Baru 59200 Kuala Lumpur, MALAYSIA</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-form-part">
                        <div class="row md-col-padding">
                            <div class="col-md-5 custom1 pr-0">
                                <div class="img-part"></div>
                            </div>
                            <div class="col-md-7 custom2 pl-0">
                                <div id="form-messages"></div>
                                <form id="comman-form11" method="post" action="{{url('contact-us')}}">
								     {{ csrf_field() }}
                                    <div class="sec-title mb-53 md-mb-42">
                                        <div class="sub-title white-color">Let's Talk</div>
                                        <h2 class="title white-color mb-0">Get In Touch</h2>
										
										 @include('layouts.error-sucess-messages') 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="name" placeholder="Full Name" required="">
											 @if ($errors->has('name'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                           @endif
                                        </div>
										
										  <div class="col-md-6">
                                            <input type="text" name="phone" placeholder="Phone Number" required="">
											  @if ($errors->has('phone'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                         @endif
                                        </div>
                                        <div class="col-md-12">
                                            <input type="email" name="email" placeholder="E-mail" required="">
											 @if ($errors->has('phone'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                         @endif
                                        </div>
                                      
                                       
                                        <div class="col-md-12">
                                            <textarea name="message" placeholder="Your Message Here" required=""></textarea>
											 @if ($errors->has('message'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                                         @endif
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="readon modify">Submit Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              <!--  <div class="g-map mt-100 md-mt-80">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.919526282045!2d101.66655730092072!3d3.115991104211978!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4986e41c8d73%3A0x86bf33941545a6a0!2sWisma%20Goshen!5e0!3m2!1sen!2sin!4v1622811338579!5m2!1sen!2sin" ></iframe>
                </div>
            </div> -->
            <!-- Contact Section End -->
        </div> 
        <!-- Main content End -->
@endsection