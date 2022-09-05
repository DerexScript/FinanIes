<?php

use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => '/api/v1/'], function () use ($router) {
    $router->group(['prefix' => 'login', 'namespace' => 'Auth'], function () use ($router) {
        $router->post('/', ['uses' => 'LoginController@verifyLogin', 'as' => 'login']);
    });
    $router->group(['prefix' => 'product'], function () use ($router) {
        $router->get('/', ['uses' => 'ProductController@index', 'as' => 'product']);
    });
});
