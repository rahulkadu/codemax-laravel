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

Route::post('user/register', 'UserController@register');
Route::post('user/login', 'UserController@login');

Route::post('admin/register', 'AdminUserController@register');
Route::post('admin/login', 'AdminUserController@login');

Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});

Route::middleware('auth:api_admin')->get('admin/me', function () {
	// dd('asd');
    return auth('api_admin')->user();
});


// Route::get('userfff', 'UserController@sss');

Route::middleware(['auth:api_admin'])->group(function () {
    
	Route::post('admin/add-product', 'ProductController@add');
	Route::get('admin/list-product', 'ProductController@listProduct');
});

Route::middleware(['jwt.auth'])->group(function () {

	Route::get('user/list-product', 'ProductController@listProduct');
	Route::post('user/submit-contact-us', 'ContactUsController@submitContactUs');
});




// php artisan storage:link