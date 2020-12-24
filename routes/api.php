<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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




Route::group(
    ['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function(){
        Route::prefix('api')->name('api.')->middleware(['api'])->group(function(){
            //Route::get('test','ClientController@get_client');


            Route::post('create_un_complete_user','ClientController@create_un_complete_user');

            Route::put('update_un_complete_user','ClientController@update_un_complete_user')->middleware('authorizeclient');

            Route::group(['prefix' => 'clients'], function () {
                Route::post('register','ClientController@register_client');
                Route::post('activate/{client}','ClientController@activate_client');
                Route::post('login','ClientController@login');
                Route::get('profile','ClientController@profile')->middleware('authorizeclient');
                Route::get('notifications','ClientController@notifications')->middleware('authorizeclient');;
                Route::post('update_profile','ClientController@update_profile')->middleware('authorizeclient');;
                Route::post('update_fcm_token','ClientController@update_fcm_token')->middleware('authorizeclient');;
                Route::post('change_password','ClientController@change_password')->middleware('authorizeclient');;
                Route::post('forget_password','ClientController@forget_password');
                Route::post('check_forget_code','ClientController@check_forget_code');
                Route::post('renew_password','ClientController@renew_password');

                // Route::get('search','ProductController@index');
                // Route::get('bycountry/{id}','ProductController@get_all_by_city_id');
                // Route::get('byuserselection','ProductController@get_all_by_user_selection')->middleware('authorizeclient');
                // Route::get('/{product}','ProductController@get_one');
            });


            Route::resource('special_orders','SpecialOrderController')->middleware('authorizeclient');;


            Route::group(['prefix' => 'rate'], function () {
                Route::post('' , 'RateController@rate')->middleware('authorizeclient');
            });

            Route::get('banks' , 'BankController@index');

            Route::get('categories' , 'CategoryController@index');
            Route::get('categories/{category}' , 'CategoryController@products');


            Route::group(['prefix' => 'cities'], function () {
                Route::get('','CityController@all_cities')->name('all_cities');
                Route::get('/{city}','CityController@get_districts_by_city_id')->name('district_by_city');
            });

            Route::get('about','AboutController@index');
            Route::get('terms','TermController@index');

            Route::group(['prefix' => 'products'], function () {
                Route::get('','ProductController@get_all');
                Route::get('latest','ProductController@get_latest_products');
                Route::get('most_ordered','ProductController@get_most_ordered_products');
                Route::get('search','ProductController@index');
                
                Route::get('test','ProductController@test');
                
                Route::get('bycountry/{id}','ProductController@get_all_by_city_id');
                Route::get('byuserselection','ProductController@get_all_by_user_selection')->middleware('authorizeclient');
                Route::get('/{product}','ProductController@get_one');
                Route::get('/{product}/page','ProductController@product_page')->middleware('authorizeclient');;
            });
            
            

            Route::group(['prefix' => 'orders'], function () {
                Route::get('order_page' , 'OrderController@order_page')->middleware('authorizeclient');
                Route::post('add_to_cart','OrderController@add_to_cart');
                Route::get('myorders','OrderController@get_client_orders')->middleware('authorizeclient');
                Route::get('myorders/{order}','OrderController@get_client_order_by_id')->middleware('authorizeclient');
                Route::get('carts','OrderController@carts')->middleware('authorizeclient');
                Route::post('checkout','OrderController@checkout')->middleware('authorizeclient');
                Route::post('testcheckout','OrderController@checkout')->middleware('authorizeclient');
                Route::get('check_coupon','OrderController@check_coupon')->middleware('authorizeclient');
                Route::delete('delete/{cart}','OrderController@delete_from_cart')->middleware('authorizeclient');
            });
            
            Route::get('delivery_times' , 'OrderController@delivery_times');

            Route::group(['prefix' => 'client', 'middleware' => ['authorizeclient']], function () {
                Route::put('update_fcm_token' , 'ClientController@update_token');
                Route::put('update_locale' , 'ClientController@update_locale');
            });


            Route::group(['prefix' => 'admin'], function () {
                Route::post('login','AdminController@login');

                Route::get('cc','AdminController@cc')->middleware('authorizedadmin');

                Route::get('orders','AdminController@get_client_orders')->middleware('authorizedadmin');

                Route::get('orders/tabs','AdminController@get_client_orders_by_status')->middleware('authorizedadmin');

                Route::get('orders/{order}','AdminController@get_client_order_by_id')->middleware('authorizedadmin');

                Route::post('orders/{order}','AdminController@change_status')->middleware('authorizedadmin');

                Route::put('update_fcm_token' , 'AdminController@update_token')->middleware('authorizedadmin');

            });

            Route::get('contact_details','ServiceNumberController@service_number');

            Route::get('download',function(){
                return \App\Download::first();
            });

        });//end of api routes
});