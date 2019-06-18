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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Users
$router->get('users', 'UserController@index');
$router->post('user/create', 'UserController@store');
$router->post('users/{id}', 'UserController@show');
$router->post('user/update', 'UserController@update');
$router->delete('user/delete', 'UserController@destroy');
$router->post('user/search/by', 'UserController@search');

//Remedies
$router->post('remedie/create', 'RemedieController@store');
$router->post('remedie/update', 'RemedieController@update'); 
$router->delete('remedie/delete', 'RemedieController@destroy');
$router->get('remedies/type', 'RemedieController@show');
$router->get('remedies', 'RemedieController@index');
$router->post('remedie/search/by', 'RemedieController@search');

//Reviews
$router->get('reviews', 'ReviewController@index');
$router->post('review/create', 'ReviewController@store');
$router->post('review/update', 'ReviewController@update'); 
$router->delete('review/delete', 'ReviewController@destroy');
$router->get('reviews/{id}', 'ReviewController@show');
$router->post('review/search/by', 'ReviewController@search');

//Fvorites
$router->post('favorite/create', 'FavoriteController@store');
$router->post('favorites/update', 'FavoriteController@update'); 
$router->delete('favorite/delete', 'FavoriteController@destroy');
$router->get('favorites/{id}', 'FavoriteController@show');
$router->get('favorites', 'FavoriteController@index');
$router->post('favorites/search/by', 'FavoriteController@search');

//Fvorites
$router->post('tip/create', 'TipController@store');
$router->post('tip/update', 'TipController@update'); 
$router->delete('tip/delete', 'TipController@destroy');
$router->get('tip/{id}', 'TipController@show');
$router->get('tips', 'TipController@index');
$router->post('tip/search/by', 'TipController@search');


//Auth
$router->post('user/login','AuthController@login');
