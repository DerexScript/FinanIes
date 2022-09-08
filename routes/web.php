<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompanyController;

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
    $router->group(['prefix' => 'company', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'CompanyController@index', 'as' => 'company.index']);
        $router->post('/', ['uses' => 'CompanyController@store', 'as' => 'company.store']);
        $router->put('/{company}', ['uses' => 'CompanyController@update', 'as' => 'company.update']);
        $router->delete('/{company}', ['uses' => 'CompanyController@destroy', 'as' => 'company.destroy']);
    });
});
