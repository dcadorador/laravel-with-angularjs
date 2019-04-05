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

Route::get('/', function () {
    return redirect('login');
});
Route::get('/upsell','TicketController@cancelUpsell');
Route::get('/memberium/cancel/subscription/rerun','PostController@cancelSubscriptionRetries')->name('subscription.rerun');
Route::post('/memberium/cancel/subscription','PostController@cancelSubscription')->name('subscription.cancel');
Route::get('/ipn/cancel','PostController@cancelFromIpnLogs')->name('cancellation.ipn.logs');
Route::get('/infusionsoft/oauth/reauth','InfusionsoftOauthController@reauth');
Route::get('/infusionsoft/oauth/redirect','InfusionsoftOauthController@redirect');
Route::post('/contact/hook','SystemController@contactDeleted');


Route::group(['middleware' => 'auth'], function() {

	Route::group(['prefix' => 'dashboard'], function() {

	    Route::get('/', 'Common\Dashboard\Report@index')->name('dashboard.report.index');

	    Route::resource('ipn', 'Common\Dashboard\IPN', [
	    	'only' => 'index',
	    	'as'   => 'dashboard'
	    ]);

	    Route::resource('autologin-logs', 'Common\Dashboard\AutologinLog', [
	    	'only' => 'index',
	    	'as'   => 'dashboard'
	    ]);

	    Route::resource('manual-cancellations', 'Common\Dashboard\ManualCancellation', [
	    	'only' => 'index',
	    	'as'   => 'dashboard'
	    ]);

	    Route::resource('memberium-cancellations', 'Common\Dashboard\MemberiumCancellation', [
	    	'only' => 'index',
	    	'as'   => 'dashboard'
	    ]);

	    Route::resource('sync-logs', 'Common\Dashboard\SyncLog', [
	    	'only' => 'index',
	    	'as'   => 'dashboard'
	    ]);

	    Route::resource('upsell-logs', 'Common\Dashboard\UpSell', [
	    	'only' => 'index',
	    	'as'   => 'dashboard'
	    ]);
	});

	Route::resource('orders', 'Order', [
    	'only' => 'index',
    	'as'   => ''
    ]);
    
});

Route::get('password-reset', 'Auth\ResetPasswordController@showResetForm');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('tests/test_connection', 'TestINFS@test_connection');
Route::get('tests/add_contact', 'TestINFS@add_contact');
Route::get('tests/update_contact', 'TestINFS@update_contact');
Route::get('tests/query_table', 'TestINFS@query_table');
Route::get('tests/get_card', 'TestINFS@get_card');
Route::get('tests/add_card', 'TestINFS@add_card');
Route::get('tests/get_product', 'TestINFS@get_product');
Route::get('tests/add_product', 'TestINFS@add_product');
Route::get('tests/add_order', 'TestINFS@create_order');
Route::get('tests/add_tag', 'TestINFS@manage_group');
Route::get('tests/assign_tag', 'TestINFS@assign_group');
Route::get('tests/remove_tag', 'TestINFS@remove_group');


Route::get('orderdata', 'PostController@recevieOrder')->name("DDPost handler");
Route::get('sendtogoogleanalytics', 'PostController@sendToGoogleAnalytics')->name("Match records and send to google analytics");
Route::get('sendtofacebook', 'PostController@sendToFacebook')->name("Match records and send to facebook");
Route::get('syncinfs', 'PostController@syncInfs')->name("Send subs and orders to Infusionsoft / Memberium");
Route::post('ipn', 'PostController@recevieIpn')->name("CB ipn handler");
Route::get('autologin', 'AutoLoginController@index')->name("CB Autologin");

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('products','ProductController@index')->name('products');
    Route::post('products','ProductController@create')->name('products.create');
    Route::post('products/edit','ProductController@update')->name('products.update');
    Route::get('products/{product}/delete','ProductController@delete')->name('products.delete');

    Route::get('system','SystemController@index')->name('system');
    Route::post('system/update','SystemController@update')->name('system.update');

    Route::get('users','UserController@index')->name('users');
    Route::post('users','UserController@create')->name('users.create');
    Route::post('users/edit','UserController@edit')->name('users.edit');
    Route::get('users/{user}/delete','UserController@delete')->name('user.delete');

    Route::get('domains','DomainController@index')->name('domains');
    Route::post('domains','DomainController@create')->name('domains.create');
    Route::post('domains/edit','DomainController@edit')->name('domains.edit');
    Route::get('domains/{domain}/delete','DomainController@delete')->name('domains.edit');
});
