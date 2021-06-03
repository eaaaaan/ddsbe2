<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// unsecure routes
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users',['uses' => 'UserController@getUsers']);
});
   
$router->get('/users2', 'UserController@index');
$router->post('/users2', 'UserController@addUser');
$router->get('/users2/{id}', 'UserController@show');
$router->put('/users2/{id}', 'UserController@update');
$router->patch('/users2/{id}', 'UserController@update');
$router->delete('/users2/{id}', 'UserController@delete');

// userjob routes
$router->get('/usersjob','UserJobController@index');
$router->get('/userjob/{id}','UserJobController@show'); // get user by id