<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Dingo API
 * https://github.com/dingo/api
 */
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    /**
     * Hi there.
     * If you want to check the routes out, do the following command:
     * $ php artisan api:routes
     */
    $api->get('test', function () {
        return 'It is ok';
    });

    $api->group(array('prefix' => 'student'), function($api)
    {
        $controller = \App\Http\Controllers\Student::class;

        $api->get('/', "$controller@getAll");

        $api->get('/get/{id}', "$controller@getById");

        /*
         * I'm not using this route, I don't think it's necessary since the frontend
         * has something to filter in real time!
         */
        $api->post('/filter', "$controller@filterByName");

        $api->post('/', "$controller@save");

        $api->put('/{id}', "$controller@update");

        $api->delete('/{id}', "$controller@delete");
    });

});

// Route::prefix('student')->group(function () {

//     $controller = \App\Http\Controllers\Student::class;

//     Route::get('/', "$controller@getAll");

//     Route::get('/get/{id}', "$controller@getById");

//     Route::get('/filter/{name}', "$controller@getByName");

//     Route::post('/', "$controller@save");

//     Route::put('/{id}', "$controller@update");

//     Route::delete('/{id}', "$controller@delete");
// });