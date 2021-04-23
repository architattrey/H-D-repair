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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login','ApiController@login');
Route::post('/update-user-profile','ApiController@appUserProfileUpdate');
Route::post('/upload-image','ApiController@imageUpload');
Route::post('/update-firebase-token','ApiController@updateFireBaseToken');
Route::post('/get-all-categories','ApiController@getAllCategories');
Route::post('/get-all-sub-categories','ApiController@getAllSubCategories');
Route::post('/get-all-banners','ApiController@getAllBanners');
Route::post('/get-all-service-features','ApiController@getAllServiceFeatures');
Route::post('/get-all-service-features-type','ApiController@getAllServiceFeaturesTypes');

Route::post('/add-to-cart','ApiController@addToCart');
Route::post('/view-cart','ApiController@viewCartOfUser');
Route::post('/delete-cart-service','ApiController@deleteserviceFromCart');
Route::post('/add-delivery-address','ApiController@AddUsersDeliveryAddress');
Route::post('/get-delivery-address','ApiController@getDeliveryAddress');
Route::post('/delete-delivery-address','ApiController@deleteDeliveryAddress');
Route::post('/get-service-providers','ApiController@getServiceProvider');
Route::post('/submit-transaction','ApiController@submitTransaction');
Route::post('/send-sms-to-service-provider','ApiController@sendSmsForServiceProvider');

Route::post('/update-transaction-status','ApiController@updateTransaction');
Route::post('/old-transactions','ApiController@oldTransactions');
Route::post('/add-user-referal-code','ApiController@addReferalCode');
Route::post('/add-redemeed-data','ApiController@addRedemeedData');
Route::post('/get-wallet-data','ApiController@getAllWalletAmount');
Route::post('/get-search-data','ApiController@searchBySubCategory');
Route::post('/price-addition','ApiController@additionOfAmount');
Route::post('/get-all-states','ApiController@getAllStates');
Route::post('/get-all-cities','ApiController@getAllCities');
Route::post('/add-feedback','ApiController@addFeedbacks');
Route::get('/get-users-feedbacks','ApiController@getUsersFeedback');

#service provider 
Route::post('/service-provider-login','ServiceProviderApiController@serviceProviderLogin');
Route::post('/service-provider-update-profile','ServiceProviderApiController@serviceProviderProfileUpdate');
Route::post('/service-provider-upload-image','ServiceProviderApiController@imageUpload');
Route::post('/change-status','ServiceProviderApiController@changeStatus');
Route::post('/service-provider-update-firebase-token','ServiceProviderApiController@updateFireBaseToken');
Route::post('/orders-details','ServiceProviderApiController@getOrderDetails');
Route::post('/documents-image-upload','ServiceProviderApiController@documentsImageUpload');
Route::post('/save-documents','ServiceProviderApiController@saveDocuments');
Route::post('/update-price','ServiceProviderApiController@updatePrice');
Route::post('/update-payment-status','ServiceProviderApiController@changePaymentStatus');


#price range
Route::post('/get-price-range','ServiceProviderApiController@getAllPriceRange');



