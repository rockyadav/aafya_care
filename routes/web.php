<?php
date_default_timezone_set('Asia/Kolkata');

Auth::routes();

//Admin Panel routes

Route::get('/admin-login',function(){
	return view('auth.login');
});

Route::get('user-login',function(){
	return view('user.user_login');
});

Route::get('home',function(){
      return redirect('admin/dashboard');
});


Route::get('register','Admin\Adminlogin@register');




Route::group([ 'prefix' => 'admin', 'middleware' => 'AdminMiddleware' ],function (){
	
	//dashboard page section
	Route::get('dashboard','Admin\Dashboard@index');
	Route::get('profile','Admin\Dashboard@profile');
	Route::post('profile','Admin\Dashboard@profile');
	Route::post('change-image','Admin\Dashboard@changeImage');
	Route::get('contacts','Admin\Dashboard@contacts');
	Route::get('contact-destroy/{id}','Admin\Dashboard@contact_distroy');


    // Customers section
	Route::get('customer', 'Admin\CustomerController@customers');
	Route::get('user-edit/{id}', 'Admin\CustomerController@user_edit');
	Route::post('update_user', 'Admin\CustomerController@update_user');
    Route::get('user-add', 'Admin\CustomerController@user_add');
    Route::post('add_user_action', 'Admin\CustomerController@add_user_action');
    Route::get('user_destroy/{id}', 'Admin\CustomerController@user_destroy');
	Route::get('user-details/{id}', 'Admin\CustomerController@user_details');
	Route::get('userChnageStatus/{id}','Admin\CustomerController@userChnageStatus'); 
	Route::post('export_users','Admin\CustomerController@export_users'); 
	Route::post('update_payment_status','Admin\CustomerController@update_payment_status');

//laboratory
   Route::get('laboratory-users', 'Admin\CustomerController@laboratoryUsers');
   Route::get('laboratory-user-details/{id}', 'Admin\CustomerController@laboratoryUserDetails');
 Route::get('laboratoryVerify/{id}','Admin\CustomerController@laboratoryVerify');  
 Route::get('laboratoryDestroy/{id}','Admin\CustomerController@laboratoryDestroy'); 
  




//sample-collectors
   Route::get('sample-collectors', 'Admin\CustomerController@sampleCollectors');
   Route::get('sample-collector-details/{id}', 'Admin\CustomerController@sampleCollectorDetails');
 Route::get('sampleCollectorChangeStatus/{id}','Admin\CustomerController@sampleCollectorChangeStatus');  
  Route::get('sampleCollectorDestroy/{id}','Admin\CustomerController@sampleCollectorDestroy'); 


//telecallers
   Route::get('telecallers', 'Admin\CustomerController@telecallers');
   Route::get('telecaller-details/{id}', 'Admin\CustomerController@telecallerDetails');

   Route::get('telecallerChangeStatus/{id}','Admin\CustomerController@telecallerChangeStatus');
 Route::get('telecallerDestroy/{id}','Admin\CustomerController@telecallerDestroy'); 



	
	//Course section 
    Route::resource('course','Admin\CourseController');
	Route::get('course/edit/{id}','Admin\CourseController@edit');
	Route::post('course/update','Admin\CourseController@update');
	Route::get('course-destroy/{id}', 'Admin\CourseController@destroy');
	
	//Slider
	
    Route::resource('slider', 'Admin\SliderController');
	Route::get('slider/edit/{id}','Admin\SliderController@edit');
	Route::post('slider/update','Admin\SliderController@update');
	Route::get('slider-destroy/{id}', 'Admin\SliderController@destroy');
	

   
	//Course Perameter section 
	Route::resource('course-perameter','Admin\CoursePerameterController');
	Route::get('course-perameter/edit/{id}','Admin\CoursePerameterController@edit');
	Route::post('course-perameter/update','Admin\CoursePerameterController@update');
	Route::get('course-perameter-destroy/{id}', 'Admin\CoursePerameterController@destroy');

	Route::get('parameter-test','Admin\CoursePerameterController@testList');
	
	Route::get('course-parameter-list/{id}','Admin\CoursePerameterController@courseParameterList');

	Route::get('course-perameter-add/{id}','Admin\CoursePerameterController@courseParameterAdd');
    
    
    //Testimonial
	
    Route::resource('testimonial', 'Admin\TestimonialController');
	Route::get('testimonial/edit/{id}','Admin\TestimonialController@edit');
	Route::post('testimonial/update','Admin\TestimonialController@update');
	Route::get('testimonial-destroy/{id}', 'Admin\TestimonialController@destroy');

	//Laboratory

	Route::get('laboratory-profile','Admin\LaboratoryController@profile');
	Route::post('laboratory-profile','Admin\LaboratoryController@profile');
	Route::post('laboratory-change-image','Admin\LaboratoryController@changeImage');

	Route::get('laboratory-customers', 'Admin\LaboratoryController@customers');

	Route::get('laboratory-generate-report/{id}', 'Admin\LaboratoryController@laboratoryGenerateReport');

	Route::post('generateReportAction', 'Admin\LaboratoryController@generateReportAction');

	Route::get('laboratory-preview-report/{id}', 'Admin\LaboratoryController@laboratoryDownloadReport');

	Route::get('laboratory-customer-details/{id}', 'Admin\LaboratoryController@customer_details');

	Route::post('SubmittedLaboratory','Admin\LaboratoryController@SubmittedLaboratory');


//Sample Collector
	Route::get('sample-collector-profile','Admin\SampleCollectorController@profile');
	Route::post('sample-collector-profile','Admin\SampleCollectorController@profile');
	
	Route::post('sample-collector-change-image','Admin\SampleCollectorController@changeImage');

	Route::get('sample-collector-customers', 'Admin\SampleCollectorController@customers');

	Route::get('sample-collector-customer-details/{id}', 'Admin\SampleCollectorController@customer_details');

Route::post('takeSampleCustomer', 'Admin\SampleCollectorController@takeSampleCustomer');
	


//Telecaller
	Route::get('telecaller-profile','Admin\TelecallerController@profile');
	Route::post('telecaller-profile','Admin\TelecallerController@profile');
	Route::post('telecaller-change-image','Admin\TelecallerController@changeImage');

	Route::get('telecaller-customers', 'Admin\TelecallerController@customers');

	Route::get('telecaller-customer-details/{id}', 'Admin\TelecallerController@customer_details');
	
	Route::get('telecaller-customer-edit/{id}', 'Admin\TelecallerController@telecaller_customer_edit');
	
	Route::post('telecaller_customer_edit_action', 'Admin\TelecallerController@telecaller_customer_edit_action');


	//city list
	Route::resource('city','Admin\CityController');
	Route::get('city/edit/{id}','Admin\CityController@edit');
	Route::post('city/update','Admin\CityController@update');
	Route::get('city-destroy/{id}', 'Admin\CityController@destroy');

	 
	
});


Route::get('/', 'HomeController@index');
Route::get('/test', 'HomeController@test');


Route::post('bookingFormAction', 'HomeController@bookingFormAction');
Route::post('verifyOtp', 'HomeController@verifyOtp');
Route::get('resendOtp', 'HomeController@resendOtp');

Route::get('about-us', 'HomeController@about_us');
Route::get('contact-us', 'HomeController@contact_us');


Route::get('registration','HomeController@registration');

Route::get('laboratory-registration','HomeController@laboratory_registration');

Route::post('laboratory_registration_action','HomeController@laboratory_registration_action');

Route::get('sample-collector-registration','HomeController@sample_collector_registration');

Route::post('sample_collector_action','HomeController@sample_collector_action');

Route::get('telecaller-registration','HomeController@telecaller_registration');

Route::post('telecaller_registration_action','HomeController@telecaller_registration_action');

Route::get('OtpLogin','HomeController@OtpLogin');

Route::get('ValidateOTP','HomeController@ValidateOTP');

Route::get('reports','HomeController@reports');

Route::get('Logout','HomeController@fnLogout');

Route::post('Signup','HomeController@Signup');

Route::get('cartprofiles','HomeController@addProfilesToCart');






//page not found
Route::get('/404', function () {
    return abort(404);
});
