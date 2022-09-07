<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompanieController;

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
    $router->group(['prefix' => 'role', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'RoleController@index', 'as' => 'role.index']);
        $router->post('/', ['uses' => 'RoleController@store', 'as' => 'role.store']);
        $router->put('/{role}', ['uses' => 'RoleController@update', 'as' => 'role.update']);
        $router->delete('/{role}', ['uses' => 'RoleController@destroy', 'as' => 'role.destroy']);
    });
    $router->group(['prefix' => 'companie', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'CompanieController@index', 'as' => 'companie.index']);
        $router->post('/', ['uses' => 'CompanieController@store', 'as' => 'companie.store']);
        $router->put('/{companie}', ['uses' => 'CompanieController@update', 'as' => 'companie.update']);
        $router->delete('/{companie}', ['uses' => 'CompanieController@destroy', 'as' => 'companie.destroy']);
    });
});
