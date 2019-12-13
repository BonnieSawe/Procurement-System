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

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => '/'], function() {
        Route::get('', 'MainController@index');   
        Route::get('comments', 'MainController@showComments');   
        Route::post('approve', 'MainController@activate');       
        Route::post('disapprove', 'MainController@deactivate');    
        Route::post('delete', 'MainController@destroy');     
        Route::post('upload-image', 'MainController@storeImage')->name('uploadImage');     

    //Events
        Route::group(['prefix' => 'quotes'], function () {
            //Add
            Route::resource('/', 'QuoteController');     
            Route::post('create', 'QuoteController@create');     
            Route::post('edit', 'QuoteController@edit');            
            Route::post('approve', 'QuoteController@approve');       
            Route::post('decline', 'QuoteController@decline');    
            Route::post('delete', 'QuoteController@destroy');     
        });
        Route::group(['prefix' => 'bids'], function () {
            //Add
            Route::resource('/', 'BidController');     
            Route::post('create', 'BidController@create');     
            Route::post('edit', 'BidController@edit');            
            Route::post('award', 'BidController@award');       
            Route::post('deny', 'BidController@deny');    
            Route::post('delete', 'BidController@destroy');     
        });
        Route::group(['prefix' => 'departments'], function () {
            //Add
            Route::resource('/', 'DepartmentController');     
            Route::post('create', 'DepartmentController@create');     
            Route::post('edit', 'DepartmentController@edit');            
            Route::post('activate', 'DepartmentController@activate');       
            Route::post('deactivate', 'DepartmentController@deactivate');    
            Route::post('delete', 'DepartmentController@destroy');     
        });
        Route::group(['prefix' => 'posts'], function () {
            //Add
            Route::resource('/', 'PostController');     
            Route::post('create', 'PostController@create');     
            Route::post('edit', 'PostController@edit');            
            Route::post('activate', 'PostController@activate');       
            Route::post('deactivate', 'PostController@deactivate');    
            Route::post('delete', 'PostController@destroy');     
        });
        Route::group(['prefix' => 'categories'], function () {
            //Add
            Route::resource('/', 'CategoryController');     
            Route::post('create', 'CategoryController@create');     
            Route::post('edit', 'CategoryController@edit');            
            Route::post('activate', 'CategoryController@activate');       
            Route::post('deactivate', 'CategoryController@deactivate');    
            Route::post('delete', 'CategoryController@destroy');     
        });
        Route::group(['prefix' => 'testimonials'], function () {
            //Add
            Route::resource('/', 'TestimonialController');     
            Route::post('create', 'TestimonialController@create');     
            Route::post('edit', 'TestimonialController@edit');            
            Route::post('activate', 'TestimonialController@activate');       
            Route::post('deactivate', 'TestimonialController@deactivate');    
            Route::post('delete', 'TestimonialController@destroy');     
        });
        Route::group(['prefix' => 'celebrations'], function () {
            //Add
            Route::resource('/', 'CelebrationController');     
            Route::post('create', 'CelebrationController@create');     
            Route::post('edit', 'CelebrationController@edit');            
            Route::post('activate', 'CelebrationController@activate');       
            Route::post('deactivate', 'CelebrationController@deactivate');    
            Route::post('delete', 'CelebrationController@destroy');     
        });
        Route::group(['prefix' => 'authors'], function () {
            //Add
            Route::resource('/', 'AuthorController');     
            Route::post('create', 'AuthorController@create');     
            Route::post('edit', 'AuthorController@edit');            
            Route::post('activate', 'AuthorController@activate');       
            Route::post('deactivate', 'AuthorController@deactivate');    
            Route::post('delete', 'AuthorController@destroy');     
        });
        Route::group (['prefix' => 'users'], function () {
            Route::get ('', 'UserController@index');
            Route::post('edit', 'UserController@editUser');            
            Route::post('activate', 'UserController@activate');       
            Route::post('deactivate', 'UserController@deactivate');
            Route::get ('settings', 'UserController@show');
            Route::post ('delete', 'UserController@delete');
            Route::resource ('user-details', 'UserController');    
        });
    });

});
