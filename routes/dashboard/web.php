<?php

use App\SpecialOrder;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
     'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    
    function(){
        Route::prefix('dashboard')->name('dashboard.')->group(function(){
           
            Auth::routes(['register' => false]);

           
            Route::middleware(['auth'])->group(function(){
                Route::get('/','DashboardController@index')->name('index');

                //user routes
                Route::resource('users' , 'UserController');
                Route::resource('/categories','CategoryController');
                Route::resource('/products','ProductController');
                Route::resource('/clients','ClientController');
                Route::resource('orders','OrderController');
               
               
                Route::resource('permissions','PermissionController');
                Route::resource('roles','RoleController');


               
                Route::get('tafsil','OrderController@tafsil');
               
                Route::resource('/times','DeliveryTimeController');
                
                Route::resource('/banks','BankController');
                Route::get('sales','SaleController@index')->name('sales.index');
                
                
                Route::get('special-orders',function(){
                    $special_orders = SpecialOrder::paginate();
                    return view('dashboard.special-orders.index',['orders'=>$special_orders]);
                })->name('special-orders.index');
                
                Route::get('special-orders/{special_order}',function(SpecialOrder $special_order){
                    return view('dashboard.special-orders.show',['order'=>$special_order]);
                })->name('special-orders.show');
                
                Route::get('notifications','NotificationController@index')->name('notifications.index');
                Route::post('notifications','NotificationController@send')->name('notifications.send');
    
                Route::get('tax','TaxController@index')->name('tax');
                Route::put('tax','TaxController@update')->name('tax.update');
                
                Route::prefix('products/{product}/details')->name('products.details.')->group(function(){
                    Route::get('','Product\DetailController@index')->name('index');
                    
                    Route::post('','Product\DetailController@upload_images')->name('upload_images');
                    Route::delete('/{image}','Product\DetailController@delete_images')->name('delete_images');
    
                    Route::post('upload_videos','Product\DetailController@upload_videos')->name('upload_videos');
                    Route::delete('upload_videos/{video}','Product\DetailController@delete_videos')->name('delete_videos');
    
    
                    Route::post('/add_sizes','Product\DetailController@add_sizes')->name('add_sizes');
                    Route::get('/edit_sizes/{size}','Product\DetailController@edit_sizes')->name('edit_sizes');
                    Route::put('/edit_sizes/{size}/update','Product\DetailController@update_sizes')->name('update_sizes');
                    Route::delete('/delete_sizes/{size}','Product\DetailController@delete_sizes')->name('delete_sizes');
    
                    Route::post('/add_special_sizes','Product\DetailController@add_special_sizes')->name('add_special_sizes');
                    Route::get('/edit_special_sizes/{size}','Product\DetailController@edit_special_sizes')->name('edit_special_sizes');
                    Route::put('/edit_special_sizes/{size}/update','Product\DetailController@update_special_sizes')->name('update_special_sizes');
    
                    Route::post('/add_colors','Product\DetailController@add_colors')->name('add_colors');
                    Route::get('/edit_colors/{color}','Product\DetailController@edit_colors')->name('edit_colors');
                    Route::put('/edit_colors/{color}/update','Product\DetailController@update_colors')->name('update_colors');
                    Route::delete('/delete_colors/{color}','Product\DetailController@delete_colors')->name('delete_colors');
               
                    Route::post('/add_details','Product\DetailController@add_details')->name('add_details');
                    Route::get('/edit_details/{detail}','Product\DetailController@edit_details')->name('edit_details');
                    Route::put('/edit_details/{detail}/update','Product\DetailController@update_details')->name('update_details');
                    Route::delete('/delete_details/{detail}','Product\DetailController@delete_details')->name('delete_details');
    
                });
    
                Route::prefix('coupons')->name('coupons.')->group(function(){
                    Route::get('','CouponController@index')->name('index');
                    Route::post('/add_coupons','CouponController@add_coupons')->name('add_coupons');
                    Route::get('/edit_coupons/{coupon}','CouponController@edit_coupons')->name('edit_coupons');
                    Route::put('/edit_coupons/{coupon}/update','CouponController@update_coupons')->name('update_coupons');
                    Route::delete('/delete_coupons/{coupon}','CouponController@delete_coupons')->name('delete_coupons');
    
                });
                
                Route::prefix('currencies')->name('currencies.')->group(function(){
                    Route::get('','CurrencyController@index')->name('index');
                    Route::put('make_defualt/{city}','CurrencyController@make_defualt')->name('make_defualt');
                });
    
                Route::resource('/cities','CityController');
                //Route::resource('products.details.custom_details','Product\DetailController');
                Route::resource('products.details.subdetails','Product\Detail\SubdetailController');
                Route::resource('cities.districts','City\DistrictController');
                
                Route::get('about','AboutController@about_us')->name('abouts');
                Route::put('about','AboutController@update')->name('abouts.update');
    
                Route::get('service_number','ServiceNumberController@service_number')->name('service_number');
                Route::put('service_number','ServiceNumberController@update')->name('service_number.update');
                
                Route::get('terms','TermController@index')->name('terms');
                Route::put('terms','TermController@update')->name('terms.update');
                
                Route::get('download','DownloadController@index')->name('download');
                Route::put('download','DownloadController@update')->name('download.update');
                
    
                Route::get('details','DetailController@index')->name('details');
                Route::post('details','DetailController@store')->name('details.store');
                
                Route::get('profile','ProfileController@edit')->name('profiles.edit');
                Route::put('profile','ProfileController@update')->name('profiles.update');
                
                Route::get('profile/change_password','ProfileController@change_password')->name('profiles.change_password');
                Route::put('profile/change_password','ProfileController@change_password_method')->name('profiles.change_password_method');
    
    
    
                //members
                Route::get('members','MemberController@index')->name('members.index');
                Route::get('members/{client}','MemberController@show')->name('members.show');
                Route::get('members/{client}/edit','MemberController@edit')->name('members.edit');
                Route::put('members/{client}/update','MemberController@update')->name('members.update');
                Route::put('members/{client}/update_password','MemberController@update_password')->name('members.update_password');
                Route::delete('members/{client}','MemberController@delete')->name('members.delete');
    
            });
        });//end of dashboard routes
});

