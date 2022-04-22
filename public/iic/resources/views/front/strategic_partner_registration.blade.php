@extends('layouts.frontTemplate')
@section('content') 
<!-- Main content Start -->
<div class="main-content">
            <!-- Breadcrumbs Section Start -->
            <div class="rs-breadcrumbs bg-8">
                <div class="container">
                    <div class="content-part text-center">
                        <h1 class="breadcrumbs-title white-color mb-0">Strategic Partner</h1>
                    </div>
                </div>
            </div>
            <!-- Breadcrumbs Section End -->

            <!-- Account Login Start -->
            <div id="rs-my-account" class="rs-my-account pt-100 pb-100 md-pt-57 md-pb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="regi-side">
                                <div class="sec-title">
                                    <h2 class="title">Registration</h2>
									 @include('layouts.error-sucess-messages') 
                                </div>
                                <form class="register-form" id="register-form" method="post" action="{{url('strategic-partner-registration-save')}}">
								 {{ csrf_field() }}
								  <div class="row">
                                     <div class="col-md-6">
										<label class="input-label">Company Name <span class="req">*</span></label>
										<input class="custom-placeholder" type="text" name="company_name" value="{{old('company_name')}}" required="">
									   @if ($errors->has('company_name'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('company_name') }}</strong>
                                            </span>
                                           @endif
										  </div>
										  
										 <div class="col-md-6">
										<label class="input-label">Mobile <span class="req">*</span></label>
										<input class="custom-placeholder" type="text" name="mobile" value="{{old('mobile')}}" required="">
									   @if ($errors->has('mobile'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                           @endif
										  </div>
									</div>

                                    <label class="input-label">Official Email Address <span class="req">*</span></label>
                                    <input class="custom-placeholder" type="email" name="email" value="{{old('email')}}" required="">
									  @if ($errors->has('email'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                           @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="input-label">Your Designation/Title <span class="req">*</span></label>
                                            <input class="custom-placeholder" type="text" name="ceo_md" required="">
											@if ($errors->has('ceo_md'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('ceo_md') }}</strong>
                                            </span>
                                           @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="input-label">Country<span class="req">*</span></label>
                                            <input class="custom-placeholder" type="text" name="country" required="">
											@if ($errors->has('country'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                            </span>
                                           @endif
                                        </div>
                                    </div>

                                    <div class="row">

                                       <div class="col-md-6">
                                            <label class="input-label">Industry <span class="req">*</span></label>
                                            <input class="custom-placeholder" type="text" name="industry" required="">
											@if ($errors->has('industry'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('industry') }}</strong>
                                            </span>
                                           @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="input-label">Company Website URL<span class="req">*</span></label>
                                            <input class="custom-placeholder" type="text" name="company_website_url" required="">
											@if ($errors->has('company_website_url'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('company_website_url') }}</strong>
                                            </span>
                                           @endif
                                        </div>
                                    </div>
									
									  <div class="row">

                                       <div class="col-md-6">
                                            <label class="input-label">Project Interest <span class="req">*</span></label>
                                            <input class="custom-placeholder" type="text" name="project_interest" required="">
											@if ($errors->has('project_interest'))
                                             <span class="error-block">
                                            <strong>{{ $errors->first('project_interest') }}</strong>
                                            </span>
                                           @endif
                                        </div>
                                      
                                    </div>

                                  

                                    <div class="submit-btn">
                                        <button class="readon" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Account Login End -->
        </div> 
        <!-- Main content End -->
@endsection