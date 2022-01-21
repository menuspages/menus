<?php

use App\Constants\AppSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('clear-cache', function() {
 
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    
    return 'DONE'; //Return anything
});


Route::get('run-mig' , function () {
    
    if($_GET["password"] == 'HamaD@7788')
    {
        return Artisan::call('migrate', ["--force" => true ]);
    }
       
} );

Route::get('create-mig' , function () {
   
    if($_GET["password"] == 'HamaD@7788')
    {
        $mig_name = $_GET["name"];
        return Artisan::call('make:migration '.$mig_name);
    }
   
});

Route::get('reset-password' , 'ResetPasswordController@sendMail')->name('sendMail');
Route::post('reset-password' , 'ResetPasswordController@sendMail')->name('postSendMail');

$domain = config('app.host') ?? 'localhost';
Route::get('/run-migrations', function () {
    return Artisan::call('migrate', ["--force" => true ]);
});
Route::domain(AppSettings::ADMIN_SUBDOMAIN . "." . $domain)->group(function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin-login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin-logout');
    Route::group(['middleware' => ['auth', 'isAdmin']], function () {
        Route::get('/', function () {
            return redirect('restaurants');
        });
// todo change update requests to patch

        Route::group(['prefix' => 'cities'], function () {

            Route::get('' , 'RestaurantController@cities')->name('cities');
            Route::get('add-cities' , 'RestaurantController@add_cities')->name('add-cities');
            Route::post('add-cities-post' , 'RestaurantController@add_cities_post')->name('add-cities-post');
            Route::get('delete-cities' , 'RestaurantController@delete_cities')->name('delete-cities');

         });

         Route::group(['prefix' => 'category'], function () {

            Route::get('' , 'City\CategoryController@index')->name('category-index');
            Route::get('add-category' , 'City\CategoryController@add_category')->name('add-category');
            Route::post('add-category-post' , 'City\CategoryController@add_category_post')->name('add-category-post');
            Route::get('delete-category' , 'City\CategoryController@delete_category')->name('category-delete-category');

         });


         Route::group(['prefix' => 'city-restaurants'], function () {

            Route::get('' , 'City\RestaurantController@index')->name('city-restaurants-index');
            Route::get('add-city-restaurants' , 'City\RestaurantController@add')->name('add-city-restaurants');
            Route::post('add-city-restaurants-post' , 'City\RestaurantController@add_post')->name('add-city-restaurants-post');
            Route::get('delete-city-restaurants' , 'City\RestaurantController@delete')->name('delete-city-restaurants');

         });

        Route::group(['prefix' => 'restaurants'], function () {
            Route::get('', 'RestaurantController@index')->name('restaurants');
            // Route::get('cities' , function () {
            //     return Artisan::call('migrate', ["--force" => true ]);
            // } );

            Route::get('/create', 'RestaurantController@create')->name('create-restaurant');
            Route::post('/store', 'RestaurantController@store')->name('store-restaurant');
            Route::get('/{subdomain}', 'RestaurantController@show')->name('show-restaurant');
            Route::get('/{subdomain}/edit', 'RestaurantController@edit')->name('edit-restaurant');
            Route::post('/{subdomain}/update', 'RestaurantController@update')->name('update-restaurant');
            Route::delete('/{subdomain}/delete', 'RestaurantController@destroy')->name('delete-restaurant');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/create', 'UserController@create')->name('create-user');
            Route::post('/store', 'UserController@store')->name('store-user');
            Route::get('/{id}', 'UserController@show')->name('show-user');
            Route::get('/{id}/edit', 'UserController@edit')->name('edit-user');
            Route::post('/{id}/update', 'UserController@update')->name('update-user');
            Route::delete('/{id}/delete', 'UserController@destroy')->name('delete-user');
            Route::get('', 'UserController@index')->name('users');

        });
        Route::group(['prefix' => 'menu-requests'], function () {
            Route::get('', 'MenuRequestController@index')->name('menu-requests');
            Route::get('/{id}', 'MenuRequestController@show')->name('menu-requests-details');
            Route::patch('/{id}/add-note', 'MenuRequestController@addNote')->name('menu-requests-add-note');
            Route::patch('/{id}/see-menu-request', 'MenuRequestController@markAsSeen')->name('menu-requests-see');
        });
    });
});

Route::domain("www.$domain")->group(function () use ($domain) {
    Route::get('/', function () use ($domain) {
        return redirect(config('app.url'));
    });
});

Route::group(['prefix' => 'api'],  function () {
    Route::post('login', 'Api\LoginController@login');
});

Route::domain("{subdomain}.$domain")->middleware('isValidSubdomain')->group(function () {
    Auth::routes(['login', 'logout']);

    Route::get('/menu-links', 'RestaurantManagerController@LinksExplore')->name('explore');
    Route::get('/', 'MenuController@viewMenu')->name('view-menu');
    Route::get('/items', 'MenuController@getItemsOfCategory')->name('get-items-of-category');
    Route::post('/place-order', 'OrderController@placeOrder')->name('placeOrder')->middleware('isOrderRestaurant');
    Route::get('/set-rating', 'OrderController@setRating')->name('set-rating');
    
    Route::group(['middleware' => ['auth', 'isRestaurantManager']], function () {

            Route::group(['prefix' => 'dashboard'], function () {
           
                Route::group(['prefix' => 'links'], function () {
                    Route::get('/', 'RestaurantManagerController@Links')->name('links');
                    Route::post('/add-feature', 'RestaurantManagerController@AddLinksFeature')->name('add-feature');
                    Route::post('/add-link', 'RestaurantManagerController@AddLinksLink')->name('add-link');
                    
                    Route::get('/delete', 'RestaurantManagerController@delete')->name('delete');
                     
                });
                            
            Route::get('/', 'RestaurantManagerController@index');
            Route::get('/rating', 'RestaurantManagerController@Rating')->name('rating');
            
            Route::post('/add-contacts', 'RestaurantManagerController@AddContacts');
            Route::get('/get-contacts', 'RestaurantManagerController@GetContacts');
            Route::post('/save-icon', 'RestaurantManagerController@saveIcon');

            Route::post('/add-accounts', 'RestaurantManagerController@AddAccounts');
            Route::get('/get-accounts', 'RestaurantManagerController@GetAccounts');

            Route::post('/add-other-accounts', 'RestaurantManagerController@AddOtherAccounts');
            Route::get('/get-other-accounts', 'RestaurantManagerController@GetOtherAccounts');
            


            Route::get('/restaurant', 'RestaurantManagerController@editRestaurant')->name('manager-edit-restaurant');
            Route::patch('/restaurant', 'RestaurantManagerController@updateRestaurant')->name('manager-update-restaurant');
            Route::get('/qrcode', 'RestaurantManagerController@generateQRCode')->name('generate-qr-code');

            Route::group(['prefix' => 'categories'], function () {
                Route::get('', 'CategoryController@index')->name('categories');
                Route::get('/create', 'CategoryController@create')->name('create-category');
                Route::post('/store', 'CategoryController@store')->name('store-category');
                Route::get('/{id}/edit', 'CategoryController@edit')->name('edit-category');
                Route::patch('/{id}/update', 'CategoryController@update')->name('update-category');
                Route::delete('/{id}', 'CategoryController@destroy')->name('categories-delete-category');
                Route::get('/set-priority', 'CategoryController@setPriority')->name('categories-priority');
            
            });

            Route::group(['prefix' => 'items'], function () {

                Route::get('', 'ItemController@index')->name('items');
                Route::get('/create', 'ItemController@create')->name('create-item');
                Route::post('/store', 'ItemController@store')->name('store-item');
                Route::post('/add-sub-details', 'ItemController@AddSubDetails')->name('add-sub-details');
                Route::get('/get-sub-details', 'ItemController@getSubDetails')->name('get-sub-details');
                Route::get('/set-priority', 'ItemController@setPriority')->name('items-priority');
            

                Route::get('/{id}/edit', 'ItemController@edit')->name('edit-item');
                Route::patch('/{id}/update', 'ItemController@update')->name('update-item');
                Route::delete('/{id}', 'ItemController@destroy')->name('delete-item');
            });

            Route::group(['prefix' => 'orders', 'middleware' => 'isOrderRestaurant'], function () {

                Route::get('/save-notifications', 'OrderController@saveNotifications')->name('save_notifications');
                Route::get('/get-unseen-nofitications-count', 'OrderController@getUnseenNotificationsCount')->name('get_notfications_count');
                Route::get('/notifications-list', 'OrderController@notificationsList')->name('notifications_list');
                Route::get('/order-details', 'OrderController@orderDetails')->name('order_details');
                Route::get('/update-order-status', 'OrderController@updateOrderStatus')->name('update-orders-status');
                Route::get('/cancel-order-status', 'OrderController@cancelOrderStatus')->name('cancel-orders-status');
    
                Route::get('/get-new-orders', 'OrderController@getNewOrder');
                Route::get('', 'OrderController@index')->name('get-orders');
                Route::post('', 'OrderController@index')->name('post-orders');
                Route::get('/{id}', 'OrderController@show')->name('show-order');
                Route::patch('/{id}/finish', 'OrderController@finishOrder')->name('finish-order');
                Route::patch('/{id}/notice', 'OrderController@noticeOrder')->name('notice-order');
            
            });

        });
    });
});


Route::get('download' , 'HomeController@download');

Route::get('test-theme', 'HomeController@testTheme')->name('testTheme');
Route::get('/', 'HomeController@index')->name('landing');
Route::post('/menu-request', 'MenuRequestController@store')->name('store-menu-request');

