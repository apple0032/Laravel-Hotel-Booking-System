<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    // Authentication Routes
    Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

    // Registration Routes
    Route::get('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('auth/register', 'Auth\AuthController@postRegister');

    // Password Reset Routes
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    //Account
    Route::get('account/edit', ['uses' => 'AccountController@AccountCenter', 'as' => 'account']);
    Route::post('account/update', ['uses' => 'AccountController@AccountUpdate', 'as' => 'update']);

    // Categories
    Route::resource('categories', 'CategoryController', ['except' => ['create']]);
    Route::resource('tags', 'TagController', ['except' => ['create']]);

    // Comments
    Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
    Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
    Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
    Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
    Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);

    // Static pages
    Route::get('contact', 'PagesController@getContact');
    Route::post('contact', 'PagesController@postContact');
    Route::get('about', 'PagesController@getAbout');
    Route::get('error', ['uses' => 'PagesController@getError', 'as' => 'pages.error']);
    
    // Index routes
    Route::get('/', 'PagesController@getIndex'); //PROJECT INDEX
    Route::post('search', ['uses' => 'PagesController@search', 'as' => 'pages.search']); //INDEX SEARCH FORM
    Route::get('search', 'PagesController@getsearch');  //SEARCH QUERY
    Route::resource('posts', 'PostController');

    // Flight
    Route::get('/flight', ['uses' => 'PagesController@flightIndex', 'as' => 'flight.index']);
    Route::post('/flightsearch', ['uses' => 'FlightController@search', 'as' => 'flight.search']);
    Route::get('/flight-result', ['uses' => 'FlightController@getSearchFlightPage', 'as' => 'flight.result']);
    Route::post('/flight-book', ['uses' => 'FlightController@booking', 'as' => 'flight.book']);
    Route::get('/flight-seat/{id}', ['uses' => 'FlightController@flightSeat', 'as' => 'flight.seat']);
    Route::get('/flight-summary', ['uses' => 'FlightController@flightSummary', 'as' => 'flight.summary']);
    Route::post('/flight-seat', ['uses' => 'FlightController@seat', 'as' => 'flight.seat_save']);

    //Image
    Route::post('/images-save', 'UploadImagesController@store');
    Route::post('/images-delete', 'UploadImagesController@destroy');
    Route::get('/images-show', 'UploadImagesController@index');
    Route::post('admin/hotel/{id}/deleteimg','UploadImagesController@deleteimg');
    Route::post('/fb-images-save', 'FacebookController@store');
    
    //Ajax
    Route::get('ajax', function(){ return view('ajax'); });
    Route::post('/searchbyajax','PagesController@searchbyajax');
    Route::post('/searchname','PagesController@searchname');
    Route::post('/searchcountry','FlightController@searchcountry');
    Route::post('/searchairport','FlightController@searchairport');
    Route::post('hotel/searchbyajax','PagesController@searchbyajax');
    Route::post('book/checkvalidation','PagesController@checkvalidation');
    
    //Hotel
    Route::resource('hotel', 'HotelController');
    Route::get('allhotels', ['uses' => 'HotelController@allhotels', 'as' => 'hotel.allhotels']);
    Route::post('comment/{id}', ['uses' => 'HotelController@comment', 'as' => 'hotel.comment']);

    //Hotel Booking
    Route::get('book/hotel/{id}/{roomid}', ['uses' => 'BookingController@book', 'as' => 'hotel.book']);
    Route::post('book/hotel/{id}/{roomid}', ['uses' => 'BookingController@booking', 'as' => 'hotel.booking']);
    Route::get('book/booklist', ['uses' => 'BookingController@booklist', 'as' => 'hotel.booklist']);
    Route::get('book/payment', ['uses' => 'BookingController@payment', 'as' => 'hotel.payment']);

    //Backend Admin
    Route::get('admin/user', ['uses' => 'AdminController@user', 'as' => 'admin.user']);
    Route::get('admin/hotel', ['uses' => 'AdminController@hotel', 'as' => 'admin.hotel']);
    Route::get('admin/hotel/create', ['uses' => 'AdminController@create', 'as' => 'hotel.create']);
    Route::post('admin/hotel', ['uses' => 'AdminController@store', 'as' => 'hotel.store']);
    Route::get('admin/hotel/{id}', ['uses' => 'AdminController@edit', 'as' => 'hotel.edit']);
    Route::post('admin/hotel/{id}', ['uses' => 'AdminController@update', 'as' => 'hotel.update']);
    Route::get('admin/hotel/{id}/delete', ['uses' => 'AdminController@delete', 'as' => 'hotel.delete']);
    
    //Hotel Room
    Route::get('admin/hotel/{id}/room', ['uses' => 'AdminController@room', 'as' => 'hotel.room']);
    Route::get('admin/hotel/{id}/room/create', ['uses' => 'AdminController@roomcreate', 'as' => 'hotel.roomcreate']);
    Route::post('admin/hotel/{id}/room', ['uses' => 'AdminController@roomstore', 'as' => 'hotel.roomstore']);
    Route::get('admin/hotel/{id}/room/{roomid}/edit', ['uses' => 'AdminController@roomedit', 'as' => 'hotel.roomedit']);
    Route::put('admin/hotel/{id}/room/{roomid}', ['uses' => 'AdminController@roomupdate', 'as' => 'hotel.roomupdate']);
    Route::get('admin/hotel/{id}/room/{roomid}/delete', ['uses' => 'AdminController@roomdelete', 'as' => 'hotel.roomdelete']);

    //Documentation
    Route::get('article', 'PagesController@getArticle');

    //Facebook
    Route::get('facebook', ['uses' => 'FacebookController@getRedirect', 'as' => 'facebook']);
    Route::get('facebook/{user_id}', 'FacebookController@getFacebook');
    Route::post('facebook', ['uses' => 'FacebookController@post', 'as' => 'facebook.post']);
    Route::post('facebook/banner', ['uses' => 'FacebookController@banner', 'as' => 'facebook.banner']);
    Route::post('facebook/profiledesc','FacebookController@profiledesc');
});
