<?php

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
    $router->group(['prefix' => 'helpers'], function () use ($router) {
        $router->get('/version', ['uses' => 'HelperController@version']);
        $router->get('/routes', ['uses' => 'HelperController@getRoutes']);
    });
    $router->group(['prefix' => 'login', 'namespace' => 'Auth'], function () use ($router) {
        $router->post('/', ['uses' => 'LoginController@verifyLogin', 'as' => 'login']);
    });
    $router->group(['prefix' => 'role', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'RoleController@index', 'as' => 'role.index']);
        $router->post('/', ['uses' => 'RoleController@store', 'as' => 'role.store']);
        $router->put('/{role}', ['uses' => 'RoleController@update', 'as' => 'role.update']);
        $router->delete('/{role}', ['uses' => 'RoleController@destroy', 'as' => 'role.destroy']);

        $router->post('/{role}/associate', ['uses' => 'RoleController@permissionAssociate', 'as' => 'role.associate']);
        $router->post('/{role}/dissociate', ['uses' => 'RoleController@permissionDisassociate', 'as' => 'role.dissociate']);
    });
    $router->group(['prefix' => 'company', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'CompanyController@index', 'as' => 'company.index']);
        $router->post('/', ['uses' => 'CompanyController@store', 'as' => 'company.store']);
        $router->put('/{company}', ['uses' => 'CompanyController@update', 'as' => 'company.update']);
        $router->delete('/{company}', ['uses' => 'CompanyController@destroy', 'as' => 'company.destroy']);
        $router->post('/{company}/attach', ['uses' => 'CompanyController@companyRules', 'as' => 'company.attach']);
    });
    $router->group(['prefix' => 'release', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'ReleaseController@index', 'as' => 'release.index']);
        $router->post('/', ['uses' => 'ReleaseController@store', 'as' => 'release.store']);
        $router->put('/{release}', ['uses' => 'ReleaseController@update', 'as' => 'release.update']);
        $router->delete('/{release}', ['uses' => 'ReleaseController@destroy', 'as' => 'release.destroy']);
        $router->post('/{release}/attach', ['uses' => 'ReleaseController@releaseRules', 'as' => 'release.attach']);
    });
    $router->group(['prefix' => 'category', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'CategoryController@index', 'as' => 'category.index']);
        $router->post('/', ['uses' => 'CategoryController@store', 'as' => 'category.store']);
        $router->put('/{category}', ['uses' => 'CategoryController@update', 'as' => 'category.update']);
        $router->delete('/{category}', ['uses' => 'CategoryController@destroy', 'as' => 'category.destroy']);
        $router->post('/{category}/attach', ['uses' => 'CategoryController@categoryRules', 'as' => 'category.attach']);
    });
    $router->group(['prefix' => 'permission', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'PermissionController@index', 'as' => 'permission.index']);
        $router->post('/', ['uses' => 'PermissionController@store', 'as' => 'permission.store']);
        $router->put('/{permission}', ['uses' => 'PermissionController@update', 'as' => 'permission.update']);
        $router->delete('/{permission}', ['uses' => 'PermissionController@destroy', 'as' => 'permission.destroy']);
    });
    $router->group(['prefix' => 'user', 'middleware' => 'auth:api'], function () use ($router) {
        $router->get('/', ['uses' => 'UserController@index', 'as' => 'user.index']);
        $router->post('/', ['uses' => 'UserController@store', 'as' => 'user.store']);
        $router->put('/{user}', ['uses' => 'UserController@update', 'as' => 'user.update']);
        $router->delete('/{user}', ['uses' => 'UserController@destroy', 'as' => 'user.destroy']);
        $router->post('/{user}/associate', ['uses' => 'UserController@roleAssociated', 'as' => 'user.associate']);
        $router->post('/{user}/dissociate', ['uses' => 'UserController@roleDisassociate', 'as' => 'user.dissociate']);
    });
});
