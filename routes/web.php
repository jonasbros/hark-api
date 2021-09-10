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

$router->group(['prefix' => 'api', 'middleware' => 'cors'], function () use ($router) {
    $router->get('/artists', 'ArtistController@index');
    $router->get('/getposts/{url}/{perpage}', 'UserPostController@get');
    
    
    $router->post('/me', 'UserController@me');
    $router->get('/user', 'UserController@user');

    $router->post('/register', 'AuthController@store');
    $router->post('/login', 'AuthController@login');
    $router->post('/loginWithGoogle', 'AuthController@storeGoogle');

    $router->get('/logout', 'AuthController@logout');

});
