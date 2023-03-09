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

// $router->get('/books', function() {
//     $books = ['ini adalah contoh data','ini adalah contoh data kedua'];
//     return response()->json($books, 200);
// });
$router->get('books', 'BookController@index');
$router->get('book/{id}', 'BookController@show');
$router->post('book', 'BookController@store');
$router->put('book/{id}', 'BookController@update');
$router->delete('book/{id}', 'BookController@destroy');