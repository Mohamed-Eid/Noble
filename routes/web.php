<?php
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

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
                // use Activity;



                
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
     'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    
    function(){
        Route::name('web.')->group(function(){
            Route::get('/', 'Web\HomeController@index')->name('index');
            Route::get('/login', 'Web\ClientController@login_form')->name('login');
            Route::post('/login', 'Web\ClientController@login_post')->name('client_login');
          
            Route::get('/register', 'Web\ClientController@register_form')->name('register');
            Route::post('/register', 'Web\ClientController@register_post')->name('register');
            Route::get('/forget_password', function () {
                return view('web.auth.forget_password');
            })->name('forget_password');

            Route::get('/logout', function(){
                auth('client')->logout();
                return redirect()->route('web.login');
            })->name('logout');

 
            Route::get('test',function(){
                
                
                // Find latest users
               // $activities = Activity::users()->get();
                $data = [];
                $active_users = Activity::guestsByMinutes(5)->get();
                foreach($active_users as $user)
                {
                    $ipdat = @json_decode(file_get_contents( 
                        "https://api.ipdata.co/" . $user->ip_address."?api-key=".env('IP_DATA_KEY'))); 
                    dd($ipdat);
                    $data[] = [
                            'ip' => $user->ip_address,
                            'country' =>  $ipdat->country_name,
                            'contenet_name' =>  $ipdat->country_name,
                            'city'           => $ipdat->city,
                        ]; 
                }
                
                return $data;

            });


            Route::get('/categories/{category}', 'Web\CategoryController@get_products')->name('get_products_by_category');

            Route::get('/products/{product}', 'Web\ProductController@get_product')->name('get_product');

            Route::post('/products/{product}/{order}', 'Web\ProductController@rate_product')->middleware('AuthClient:client')->name('rate_product');


            Route::post('/add_to_cart','Web\OrderController@add_to_cart')->middleware('AuthClient:client')->name('add_to_cart');
            Route::delete('/delete_from_cart/{cart}','Web\OrderController@delete_from_cart')->middleware('AuthClient:client')->name('delete_from_cart');
            Route::get('/myorders','Web\OrderController@my_orders')->middleware('AuthClient:client')->name('my_orders');
            Route::get('/myorders/{order}','Web\OrderController@get_order')->middleware('AuthClient:client')->name('get_order');


            Route::get('/notifications','Web\NotificationController@index')->middleware('AuthClient:client')->name('notifications');


            Route::get('special_order','Web\SpecialOrderController@index')->name('special_order');           
            Route::post('special_order','Web\SpecialOrderController@store')->name('special_order.store');           

            Route::get('cart','Web\OrderController@carts')->name('cart')->middleware('AuthClient:client');           
            Route::post('checkout','Web\OrderController@checkout')->name('checkout')->middleware('AuthClient:client');           
            Route::post('charge','Web\OrderController@charge')->name('charge')->middleware('AuthClient:client');           
            Route::get('redirect_after_payment','Web\OrderController@redirecturl')->name('redirect_after_payment');           

            Route::get('checkout_form',function(){
                return view('web.orders.checkout');
            });

            Route::get('about_us','Web\PagesController@about_us')->name('about_us');           
            Route::get('terms','Web\PagesController@terms')->name('terms');           


        });//end of dashboard routes
});
