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

$api = app('Dingo\Api\Routing\Router');
//
$api->version('v1', function ($api) {

    $api->post('/login', 'App\Http\Controllers\API\AuthController@login');
    $api->group(['middleware' => 'auth:api'], function ($api) {
        $api->get('/logout', 'App\Http\Controllers\API\AuthController@logout');

        //Teachers role route
        $api->get('/teachers/{school_code}', 'App\Http\Controllers\API\TeachersController@index');
        $api->post('/teachers', 'App\Http\Controllers\API\TeachersController@store');
        $api->get('/teachers/details/{id}', 'App\Http\Controllers\API\TeachersController@show');
        $api->patch('/teachers/{id}', 'App\Http\Controllers\API\TeachersController@update');
        $api->post('/teachers/deactivate/{id}', 'App\Http\Controllers\API\TeachersController@deactivateUser');
        $api->post('/teachers/activate/{id}', 'App\Http\Controllers\API\TeachersController@activateUser');


    });
});

