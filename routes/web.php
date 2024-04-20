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

//Stuff
$router->get('/stuffs','StuffControler@index'); 

$router->group(['prefix' => 'stuff','middeware' => 'auth'], function() use ($router){
    //Static Routes
    $router->get('/data', 'StuffControler@index');
    $router->post('/', 'StuffControler@store');
    $router->get('/trash', 'StuffControler@trash');

    //Dynamic routes
    $router->get('{id}', 'StuffControler@show');
    $router->patch('/{id}', 'StuffControler@update');
    $router->delete('/{id}', 'StuffControler@delete');
    $router->get('/restore{id}', 'StuffControler@restore');
    $router->delete('/permanent{id}', 'StuffControler@deletPermanent');
});

$router->post('/login', 'UserController@login');
$router->get('/logout', 'UserController@logout');

$router->group(['prefix' => 'user'], function() use ($router) {
    // static routes : tetap
    // $router->post('store', 'UserController@index');
    // $router->get('detail/{id}', 'UserController@index');
    // $router->patch('update/{id}', 'UserController@index');
    // $router->get('delet/{id}', 'UserController@index');
    $router->post('/store', 'UserController@store');
    $router->get('/trash', 'UserController@trash');

    //dunamic routes : berubah - rubah
    $router->get('{id}', 'UserController@show');
    $router->patch('/{id}', 'UserController@update');
    $router->delete('/{id}','UserController@destroy');
    $router->get('/restore/{id}', 'UserController@restore');
    $router->delete('/permanent/{id}', 'UserController@deletePermanent');
});
//inbound

$router->group(['prefix' => 'inbound-stuff/', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'InboundStuffController@index');
    $router->post('store', 'InboundStuffController@store');
    $router->get('detail/{id}', 'InboundStuffController@show');
    $router->patch('update/{id}', 'InboundStuffController@update');
    $router->delete('delete/{id}', 'InboundStuffController@destroy');
    $router->get('recycle-bin', 'InboundStuffController@recycle-bin');
    $router->get('restore/{id}', 'InboundStuffController@restore');
    $router->get('force-delete/{id}', 'InboundStuffController@forceDestroy');
});
//Stuff-Stock
$router->group(['prefix' => 'stuff-stock', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'InboundStuffControler@index');
    $router->post('store', 'StuffStockController@store');
    $router->get('detail/{id}', 'StuffStockController@show');
    $router->patch('update/{id}', 'StuffStockController@update');
    $router->delete('delete/{id}', 'StuffStockController@destroy');
    $router->get('recycle-bin', 'StuffStockController@recycle-bin');
    $router->get('restore/{id}', 'StuffStockController@restore');
    $router->post('addstock/{id}', 'StuffStockController@addStock');
    $router->post('subStock/{id}', 'StuffStockController@subStock');
});