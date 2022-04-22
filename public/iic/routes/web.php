<?php

/*
|--------------------------------------------------------------------------
| Web Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/  

Route::get('all-clear', function() {
   $exitCode = Artisan::call('cache:clear');
   $exitCode = Artisan::call('config:cache');
   $exitCode = Artisan::call('view:clear');
   echo 'done';
});


//echo phpinfo();


date_default_timezone_set("Asia/Calcutta");
ini_set('max_input_vars','6000' );
ini_set('max_execution_time', 1000);
ini_set('memory_limit', '1024M');
ini_set('post_max_size', '800M');

Route::get('phpinfo', function(){
echo phpinfo();
});

Route::get('/', 'HomeController@index');


Route::post('resend-mail', 'HomeController@resendMail');
Route::post('forgot-password', 'HomeController@forgotPassword');
Route::post('subscribe-now', 'HomeController@subscribeNow');
Route::post('otp-verify', 'HomeController@otpVerify');
Route::post('new-password', 'HomeController@newPassword');
Route::get('mail-verify/{email}/{token}', 'HomeController@mailVerify');

Route::get('logout', 'HomeController@logout');


Route::get('user-login', 'HomeController@userlogin');
Route::get('signup', 'HomeController@userRegister');
Route::post('save-signup', 'HomeController@userRegisterAction');
Route::get('about-us', 'HomeController@aboutUs');
Route::get('contact-us', 'HomeController@contactUs');
Route::post('contact-us', 'HomeController@contactUsSave');
Route::get('chairmans-message', 'HomeController@chairmansMessage');
Route::get('what-we-do', 'HomeController@whatWeDo');
Route::get('events', 'HomeController@events');
Route::get('event-details/{id}', 'HomeController@eventDetails');

Route::get('strategic-partner-registration', 'HomeController@strategicPartnerRegistration');
Route::post('strategic-partner-registration-save', 'HomeController@strategicPartnerRegistrationSave');




Auth::routes(); 

Route::get('home', 'Admin\HomeController@checkLogin')->name('home');
//check login
Route::get('checklogin', 'Admin\HomeController@checkLogin');

Route::group(['middleware' => 'AdminMiddleware' ],function () {

	Route::get('dashboard', 'Admin\HomeController@index');

	
	
	//users listing
	Route::resource('users', 'Admin\UserController');
	Route::get('users/destroy/{id}', 'Admin\UserController@destroy');
	Route::get('users-subscription/{id}', 'Admin\UserController@userSubscription');
	Route::get('users-downloads/{id}', 'Admin\UserController@userDownloads');
	Route::get('users/login/{id}', 'Admin\UserController@login');

	

	Route::get('profile', 'Admin\ProfileController@index');
	Route::post('profile-update', 'Admin\ProfileController@profile');
	Route::post('change-image', 'Admin\ProfileController@changeImage');

	//website image
	
	Route::get('settings', 'Admin\ProfileController@settings');
	Route::post('update-settings', 'Admin\ProfileController@updateSettings');

	Route::get('contact-enquiry', 'Admin\ProfileController@contactEnquiry');
	Route::get('strategic-partners', 'Admin\ProfileController@strategicPartners');

	Route::get('pages/{url}', 'Admin\ProfileController@pages');
	Route::post('update-pages', 'Admin\ProfileController@updatePages');
	Route::get('remove-addmore-detail/{id}', 'Admin\ProfileController@removeAddMore');
	
	
	//events section 
    Route::resource('event','Admin\EventController');
	Route::get('event/edit/{id}','Admin\EventController@edit');
	Route::post('event/update','Admin\EventController@update');
	Route::get('event-destroy/{id}', 'Admin\EventController@destroy');
	
	//What we do section 
    Route::resource('whatwedo','Admin\WhatwedoController');
	Route::get('whatwedo/edit/{id}','Admin\WhatwedoController@edit');
	Route::post('whatwedo/update','Admin\WhatwedoController@update');
	Route::get('whatwedo-destroy/{id}', 'Admin\WhatwedoController@destroy');

	
});



// users routes 
Route::group(['prefix'=>'user','middleware' => 'UserMiddleware' ],function () {
	Route::get('my-profile', 'User\UserController@index');
	Route::get('my-download', 'User\UserController@myDownload');
	Route::get('my-purchase', 'User\UserController@myPurchase');
	Route::get('my-subscription', 'User\UserController@mySubscription');
	Route::get('my-wishlist', 'User\UserController@myWishlist');
	Route::get('remove-wishlist/{id}', 'User\UserController@removeWishlist');
	Route::get('checkout', 'HomeController@checkout');
	Route::post('pay-now', 'HomeController@payNow');
	Route::get('download-now/{url}', 'User\UserController@imageDownload');
	Route::post('update-profile', 'User\UserController@updateProfile');
	Route::get('delete-account', 'User\UserController@deleteAccount');
});






Route::get('/404', function () {
    return view('errors.404');
});

Route::get('/500', function () {
    return view('errors.500');
});

Route::get('/403', function () {
    return view('errors.500');
});