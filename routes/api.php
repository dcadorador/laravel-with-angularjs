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

Route::group(['prefix' => 'v1'], function() {
   
   	Route::resource('reports', 'Api\Report', [
   		'only' => ['index'],
   		'as'   => 'api'
   	]);

   	Route::resource('ipn-logs', 'Api\IpnLog', [
   		'only' => ['index'],
   		'as'   => 'api'
   	]);

   	Route::resource('autologin-logs', 'Api\AutologinLog', [
   		'only' => ['index'],
   		'as'   => 'api'
   	]);

   	Route::resource('manual-cancellation-logs', 'Api\ManualCancellation', [
   		'only' => ['index'],
   		'as'   => 'api'
   	]);

   	Route::resource('memberium-cancellation-logs', 'Api\MemberiumCancellation', [
   		'only' => ['index'],
   		'as'   => 'api'
   	]);

   	Route::resource('sync-logs', 'Api\SyncLog', [
   		'only' => ['index'],
   		'as'   => 'api'
   	]);

      Route::resource('upsell-logs', 'Api\UpsellLog', [
         'only' => ['index'],
         'as'   => 'api'
      ]);      

   	Route::resource('users', 'Api\User', [
   		'only' => ['index', 'store', 'update', 'destroy'],
   		'as'   => 'api'
   	]);

   	Route::resource('products', 'Api\Product', [
   		'only' => ['index', 'store', 'update', 'destroy'],
   		'as'   => 'api'
   	]);
   	
   	Route::resource('system-settings', 'Api\SystemSetting', [
   		'only' => ['index', 'update'],
   		'as'   => 'api'
   	]);

   	Route::get('domain/all', 'Api\Domain@all');
   	Route::resource('domain', 'Api\Domain', [
   		'only' => ['index', 'store', 'update', 'destroy'],
   		'as'   => 'api'
   	]);


      Route::resource('orders', 'Api\Order', [
         'only' => ['index', 'store', 'update', 'destroy'],
         'as'   => 'api'
      ]);

});
