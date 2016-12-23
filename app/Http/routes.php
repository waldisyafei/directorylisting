<?php

use App\Models\Message;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Frontend\FrontendController@index');
//Route::get('category', 'Frontend\FrontendController@category');
Route::get('details', 'Frontend\FrontendController@details');

Route::group(['prefix' => 'category'], function(){
	Route::get('{slug}', 'Frontend\ListingsController@category');
});

Route::group(['prefix' => 'listings'], function(){
	Route::get('{category_slug}/{listing_slug}', 'Frontend\ListingsController@listing_details');
});

Route::group(['prefix' => 'noncust-ads'], function(){
	Route::get('login', 'Frontend\NonCustomersAds@login');
	Route::get('logout', 'Frontend\NonCustomersAds@logout');
	Route::post('login', 'Frontend\NonCustomersAds@do_login');
	Route::get('{ads_hash}', 'Frontend\NonCustomersAds@edit_ads');
	Route::post('{ads_hash}', 'Frontend\NonCustomersAds@update');
});



Route::controllers([
	'app-admin/auth' => 'Auth\AuthController',
	'app-admin/password' => 'Auth\PasswordController',
]);

Route::controllers([
	'auth-customers' => 'Auth\AuthCustomersController'
]);

Route::controllers([
	'auth-nonsubs' => 'Auth\AuthNonSubscriberController'
]);

Route::group(['prefix' => 'app-admin', 'middleware' => 'auth'], function() {

	Route::get('/', 'Backend\BackendController@index');

	Route::group(['prefix' => 'users'], function() {
		Route::get('/', 'Backend\UsersController@index');
		Route::get('create', 'Backend\UsersController@create');
		Route::post('create', 'Backend\UsersController@store');
		Route::get('edit/{id}', 'Backend\UsersController@edit');
		Route::post('edit/{id}', 'Backend\UsersController@update');
		Route::get('delete/{id}', 'Backend\UsersController@destroy');
		Route::get('profile/{id}', 'Backend\UsersController@profile');
	});
	
	Route::group(['prefix' => 'customers'], function() {
		Route::get('/', 'Backend\CustomersController@index');
		Route::get('create', 'Backend\CustomersController@create');
		Route::post('create', 'Backend\CustomersController@store');
		Route::get('edit/{id}', 'Backend\CustomersController@edit');
		Route::post('edit/{id}', 'Backend\CustomersController@update');
		Route::get('delete/{id}', 'Backend\CustomersController@destroy');
		Route::get('profile/{id}', 'Backend\CustomersController@profile');
	});

	Route::group(['prefix' => 'roles'], function() {
		Route::get('/', 'Backend\RolesController@index');
		Route::get('create', 'Backend\RolesController@create');
		Route::post('create', 'Backend\RolesController@store');
		Route::get('edit/{id}', 'Backend\RolesController@edit');
		Route::post('edit/{id}', 'Backend\RolesController@update');
		Route::get('delete/{id}', 'Backend\RolesController@destroy');
	});

	Route::group(['prefix' => 'listings'], function() {
		Route::get('/', 'Backend\ListingsController@index');
		Route::get('create', 'Backend\ListingsController@create');
		Route::post('create', 'Backend\ListingsController@store');
		Route::get('edit/{id}', 'Backend\ListingsController@edit');
		Route::post('edit/{id}', 'Backend\ListingsController@update');
		Route::get('approve/{id}', 'Backend\ListingsController@approve');
		Route::get('suspend/{id}', 'Backend\ListingsController@suspend');
		Route::get('delete/{id}', 'Backend\ListingsController@destroy');

		Route::group(['prefix' => 'categories'], function(){
			Route::get('/', 'Backend\ListingCategoriesController@index');
			Route::get('create', 'Backend\ListingCategoriesController@create');
			Route::post('create', 'Backend\ListingCategoriesController@store');
			Route::get('edit/{id}', 'Backend\ListingCategoriesController@edit');
			Route::post('edit/{id}', 'Backend\ListingCategoriesController@update');
			Route::get('delete/{id}', 'Backend\ListingCategoriesController@destroy');
		});
	});

	Route::group(['prefix' => 'approvals'], function(){
		Route::get('listings', 'Backend\ApprovalsController@listings');
		Route::get('listings/view/{id}', 'Backend\ApprovalsController@show_listing');
		Route::get('listings/view/{id}/approve', 'Backend\ApprovalsController@approve_listing');
		Route::get('listings/view/{id}/reject', 'Backend\ApprovalsController@reject_listing');

		Route::get('ads', 'Backend\ApprovalsController@ads');
		Route::get('ads/view/{id}', 'Backend\ApprovalsController@show_ad');
		Route::get('ads/view/{id}/approve', 'Backend\ApprovalsController@approve_ad');
		Route::get('ads/view/{id}/reject', 'Backend\ApprovalsController@reject_ad');

	});

	Route::group(['prefix' => 'permissions'], function(){
		Route::get('/', 'Backend\PermissionsController@index');
		Route::get('create', 'Backend\PermissionsController@create');
		Route::post('create', 'Backend\PermissionsController@store');
		Route::get('edit/{id}', 'Backend\PermissionsController@edit');
		Route::post('edit/{id}', 'Backend\PermissionsController@update');
		Route::get('delete/{id}', 'Backend\PermissionsController@destroy');
	});

	Route::group(['prefix' => 'ads'], function() {
		Route::get('/', 'Backend\AdsController@index');
		Route::get('noncust', 'Backend\AdsController@index_noncust');
		Route::get('create', 'Backend\AdsController@create');
		Route::post('create', 'Backend\AdsController@store');
		Route::get('edit/{id}', 'Backend\AdsController@edit');
		Route::post('edit/{id}', 'Backend\AdsController@update');
		Route::get('renew/{id}', 'Backend\AdsController@renew');
		Route::post('renew/{id}', 'Backend\AdsController@renew_ads_slot');
		Route::get('delete/{id}', 'Backend\AdsController@destroy');

		Route::get('buy/complete', 'Backend\AdsController@buyComplete');
	});

	Route::group(['prefix' => 'packages'], function() {
		Route::get('/', 'Backend\PackagesController@index');
		Route::get('create', 'Backend\PackagesController@create');
		Route::post('create', 'Backend\PackagesController@store');
		Route::get('edit/{id}', 'Backend\PackagesController@edit');
		Route::post('edit/{id}', 'Backend\PackagesController@update');
		Route::get('delete/{id}', 'Backend\PackagesController@destroy');
	});

	Route::group(['prefix' => 'settings'], function(){
		Route::get('site', 'Backend\SettingsController@site');
		Route::post('site', 'Backend\SettingsController@store_site');

		Route::get('packages', 'Backend\SettingsController@packages');
		Route::post('packages', 'Backend\SettingsController@store_package');

		Route::get('listings', 'Backend\SettingsController@listings');
		Route::post('listings', 'Backend\SettingsController@store_listings');

		Route::get('ads', 'Backend\SettingsController@ads');
		Route::post('ads', 'Backend\SettingsController@store_ads');

		Route::get('ads-price', 'Backend\SettingsController@ads_price');
		Route::post('ads-price', 'Backend\SettingsController@set_ads_price');
		Route::post('expiry', 'Backend\SettingsController@expiry');
		Route::post('noncust-ads-price', 'Backend\SettingsController@noncustset_ads_price');
	});

	Route::group(['prefix' => 'billings'], function(){
		Route::group(['prefix' => 'listing'], function(){
			Route::get('/', 'Backend\BillingsController@index_listing');

			Route::get('view/{id}', 'Backend\BillingsController@show');
			Route::get('{id}/confirm', 'Backend\BillingsController@confirm_payment');
			Route::get('{id}/unconfirm', 'Backend\BillingsController@cancel_payment');
			Route::get('delete/{id}', 'Backend\BillingsController@destroy');
		});
		Route::group(['prefix' => 'ads'], function(){
			Route::get('/', 'Backend\BillingsController@index_ads');

			Route::get('view/{id}', 'Backend\BillingsController@show');
			Route::get('{id}/confirm', 'Backend\BillingsController@confirm_payment');
			Route::get('{id}/unconfirm', 'Backend\BillingsController@cancel_payment');
			Route::get('delete/{id}', 'Backend\BillingsController@destroy');
		});
	});

	Route::get('geo/getZone', 'Backend\BackendController@getZone');
	
});

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function(){
	Route::group(['prefix' => 'message'], function(){
		Route::get('send', 'MessagesController@send');
		Route::get('get', 'MessagesController@get');
	});
});

Route::group(['prefix' => 'notif'], function(){
	Route::get('get', 'NotificationsController@get');


	Route::get('test', 'NotificationsController@get');
	Route::get('send', 'Frontend\FrontendController@updatePost');
});

Route::group(['prefix' => 'account', 'middleware' => 'authCustomer'], function() {

	// Index (Dashboard) of subscriber page
	Route::get('/', 'Customers\CustomersController@index');
	Route::get('listing_stats', 'Customers\ListingsController@statistics');
	Route::get('edit_info', 'Customers\CustomersController@edit_info');
	Route::post('edit_info/{id}', 'Customers\CustomersController@update_info');

	Route::group(['prefix' => 'listings'], function(){
		Route::get('/', 'Customers\ListingsController@index');
		Route::get('create', 'Customers\ListingsController@create');
		Route::post('create', 'Customers\ListingsController@store');
		Route::get('edit/{id}', 'Customers\ListingsController@edit');
		Route::post('edit/{id}', 'Customers\ListingsController@update');
		Route::get('delete/{id}', 'Customers\ListingsController@destroy');

		Route::post('upload_image', 'Customers\ListingsController@upload_image');
		//Route::post('listing_stats', 'Customers\ListingsController@upload_image');


		Route::get('buy', 'Customers\ListingsController@buy');
		Route::post('buy', 'Customers\ListingsController@buy_listing_slot');
		Route::get('buy/complete', 'Customers\ListingsController@buyComplete');

		Route::get('renew', 'Customers\ListingsController@renew');
		Route::post('renew', 'Customers\ListingsController@renew_listing_slot');
		Route::get('renew/complete', 'Customers\ListingsController@renewComplete');

		Route::get('get_sub_categories', 'Customers\ListingsController@getSubcategory');
	});

	Route::get('listing-wizard', 'Customers\ListingsController@buy');
	Route::get('ads-wizard', 'Customers\AdsController@buy');

	Route::group(['prefix' => 'ads'], function(){
		Route::get('/', 'Customers\AdsController@index');
		Route::get('create', 'Customers\AdsController@create');
		Route::post('create', 'Customers\AdsController@store');
		Route::get('edit/{id}', 'Customers\AdsController@edit');
		Route::post('edit/{id}', 'Customers\AdsController@update');
		Route::get('delete/{id}', 'Customers\AdsController@destroy');

		Route::post('upload_image', 'Customers\AdsController@upload_image');

		//Route::get('buy', 'Customers\AdsController@buy');
		Route::post('buy', 'Customers\AdsController@buy_ads_slot');
		Route::get('buy/complete', 'Customers\AdsController@buyComplete');

		Route::get('renew/{id}', 'Customers\AdsController@renew');
		Route::post('renew/{id}', 'Customers\AdsController@renew_ads_slot');
		Route::get('renew/complete', 'Customers\AdsController@renewComplete');
	});

	Route::group(['prefix' => 'billings'], function(){
		Route::get('/', 'Customers\BillingsController@index');
		Route::get('view/{id}', 'Customers\BillingsController@show');

		Route::get('confirm/{id}', 'Customers\BillingsController@confirm_get');
		Route::post('confirm/{id}', 'Customers\BillingsController@confirm_post');
		Route::get('confirm/delimage/{id}', 'Customers\BillingsController@delimage');
		Route::get('confirm/edit/{id}', 'Customers\BillingsController@edit_confirm');
	});

	Route::group(['prefix' => 'sub-account'], function(){
		Route::get('/', 'Customers\CustomersController@sub_account');
	});
});

Route::group(['prefix' => 'nonsubs', 'middleware' => 'authNonSubscriber'], function() {

	// Index (Dashboard) of subscriber page
	Route::get('/', 'Nonsubs\NonSubscriberController@index');
	//Route::get('listing_stats', 'Customers\ListingsController@statistics');

	Route::get('edit_info', 'Nonsubs\NonSubscriberController@edit_info');
	Route::post('edit_info/{id}', 'Nonsubs\NonSubscriberController@update_info');

	Route::get('ads-wizard', 'Nonsubs\AdsController@wizard');

	Route::group(['prefix' => 'ads'], function(){
		Route::get('/', 'Nonsubs\AdsController@index');
		Route::get('create', 'Nonsubs\AdsController@create');
		Route::post('create', 'Nonsubs\AdsController@store');
		Route::get('edit/{id}', 'Nonsubs\AdsController@edit');
		Route::post('edit/{id}', 'Nonsubs\AdsController@update');
		Route::get('delete/{id}', 'Nonsubs\AdsController@destroy');

		Route::post('upload_image', 'Nonsubs\AdsController@upload_image');

		Route::get('buy', 'Nonsubs\AdsController@buy');
		Route::post('buy', 'Nonsubs\AdsController@buy_ads_slot');
		Route::get('buy/complete', 'Nonsubs\AdsController@buyComplete');

		Route::get('renew/{id}', 'Nonsubs\AdsController@renew');
		Route::post('renew/{id}', 'Nonsubs\AdsController@renew_ads_slot');
		Route::get('renew/complete', 'Nonsubs\AdsController@renewComplete');
	});

	Route::group(['prefix' => 'billings'], function(){
		Route::get('/', 'Nonsubs\BillingsController@index');
		Route::get('view/{id}', 'Nonsubs\BillingsController@show');

		Route::get('confirm/{id}', 'Nonsubs\BillingsController@confirm_get');
		Route::post('confirm/{id}', 'Nonsubs\BillingsController@confirm_post');
	});
});