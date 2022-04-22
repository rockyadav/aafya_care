<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


//webservices
Route::group([ 'prefix' => 'service-provider'],function () {
	//login and sign-up api
	Route::post('login','Webservice\ServiceproviderController@userLogin');

	//sign up
	Route::post('sign-up', 'Webservice\ServiceproviderController@signUp');
	Route::post('verifyOtp', 'Webservice\ServiceproviderController@verifyOtp');
	Route::post('resendOtp', 'Webservice\ServiceproviderController@resendOtp');

	//country list
	Route::post('countryList', 'Webservice\ServiceproviderController@countryList');

	//forgot password
	Route::post('forgotPassword', 'Webservice\ServiceproviderController@forgotPassword');
	Route::post('resetPassword', 'Webservice\ServiceproviderController@resetPassword');

	//logout
	Route::get('logout', 'Webservice\ServiceproviderController@logout');

	//profile
	Route::post('getProfile', 'Webservice\ServiceproviderController@getProfile');
	Route::post('updateProfile', 'Webservice\ServiceproviderController@updateProfile');
	Route::post('businessProfile', 'Webservice\ServiceproviderController@businessProfile');
	Route::post('getBusinessprofile', 'Webservice\ServiceproviderController@getBusinessprofile');

	//gallery
	Route::post('galleryImages', 'Webservice\ServiceproviderController@galleryImages');
	Route::post('saveImage', 'Webservice\ServiceproviderController@saveImage');
	Route::post('deleteImage', 'Webservice\ServiceproviderController@deleteImage');
	Route::post('deletemultiImages', 'Webservice\ServiceproviderController@deletemultiImages');
	
	//services types
	Route::post('getMainServiceList', 'Webservice\ServiceproviderController@getMainServiceList');

	//provider services 
	Route::post('addService', 'Webservice\ServiceproviderController@addService');
	Route::post('updateService', 'Webservice\ServiceproviderController@updateService');Route::post('deleteService', 'Webservice\ServiceproviderController@deleteService');
	Route::post('servicesList', 'Webservice\ServiceproviderController@getMyServicesList');
	Route::post('getServiceDetails', 'Webservice\ServiceproviderController@getServiceDetails');
	//tags
	Route::post('addTag', 'Webservice\ServiceproviderController@addTag');
	Route::post('updateTag', 'Webservice\ServiceproviderController@updateTag');
	Route::post('deleteTag', 'Webservice\ServiceproviderController@deleteTag');
	Route::post('tagsList', 'Webservice\ServiceproviderController@getMyTagsList');
	
	Route::post('checkAvailability', 'Webservice\ServiceproviderController@checkAvailability');  

	//customers
	Route::post('customerList', 'Webservice\ServiceproviderController@getMyCustomerList');
	Route::post('getCustomerReviews', 'Webservice\ServiceproviderController@getCustomerReviews');
	
	//vacations
	Route::post('addVacations', 'Webservice\ServiceproviderController@addVacations');Route::post('updateVacations', 'Webservice\ServiceproviderController@updateVacations');
	Route::post('getVacationList', 'Webservice\ServiceproviderController@getVacationList');
	Route::post('deleteVacations', 'Webservice\ServiceproviderController@deleteVacations');
	
	//break time
	Route::post('getBreakTimeList', 'Webservice\ServiceproviderController@getBreakTimeList');
	Route::post('addBreakTime', 'Webservice\ServiceproviderController@addBreakTime');Route::post('deleteBreakTime', 'Webservice\ServiceproviderController@deleteBreakTime');
	Route::post('updateBreakTime', 'Webservice\ServiceproviderController@updateBreakTime');

	//appointments
	Route::post('getAppointmentRequest', 'Webservice\ServiceproviderController@getAppointmentRequest');
	Route::post('acceptRejectAppointmentRequest', 'Webservice\ServiceproviderController@acceptRejectAppointmentRequest');
	 Route::post('completeAppointment', 'Webservice\ServiceproviderController@completeAppointment');
	 Route::post('getAppointmentsHistory', 'Webservice\ServiceproviderController@getAppointmentsHistory');
	 Route::post('PayCashPayment', 'Webservice\ServiceproviderController@PayCashPayment'); 

	//contact us
	Route::post('contactUs', 'Webservice\ServiceproviderController@contactUs');
	
	// notificatios
	Route::post('getNotificationList', 'Webservice\ServiceproviderController@getNotificationList');

	Route::post('getPaymentHistry', 'Webservice\ServiceproviderController@getPaymentHistry');
	
	Route::get('check', 'Webservice\ServiceproviderController@check');
	
});


 Route::group([ 'prefix' => 'customer'],function () {
	//login and sign-up api
	Route::post('updateProfile','Webservice\CustomerController@updateProfile');
	
	//check auth
	Route::group(['middleware' => 'auth:api'], function(){
		//logout 
		Route::get('logout', 'Webservice\CustomerController@logout');
	});
	
	Route::post('getMainService', 'Webservice\CustomerController@getMainService');
	Route::post('getBannerList', 'Webservice\CustomerController@getBannerList');
	Route::post('getServiceProviderByCategory', 'Webservice\CustomerController@getServiceProviderByCategory');
	Route::post('getServiceProviderDetails', 'Webservice\CustomerController@getServiceProviderDetails');
	Route::post('writeReview', 'Webservice\CustomerController@writeReview');
	Route::post('getReview', 'Webservice\CustomerController@getReview');
	Route::post('getAllReviews', 'Webservice\CustomerController@getAllReviews');
	Route::post('getServiceDetails', 'Webservice\CustomerController@getServiceDetails');
	Route::post('availability', 'Webservice\CustomerController@availability');
	Route::post('bookAppointments', 'Webservice\CustomerController@bookAppointments');Route::post('searchServiceProviders', 'Webservice\CustomerController@searchServiceProviders');
	Route::post('changeImage', 'Webservice\CustomerController@changeImage');
	Route::post('getMyAppointments', 'Webservice\CustomerController@getMyAppointments');Route::post('cancelMyAppointment', 'Webservice\CustomerController@cancelMyAppointment');
	Route::post('updateMyAppointment', 'Webservice\CustomerController@updateMyAppointment');
	
	Route::post('getNotificationList', 'Webservice\CustomerController@getNotificationList');
	
	Route::post('getServiceProviderByBanner', 'Webservice\CustomerController@getServiceProviderByBanner');
});


//end
