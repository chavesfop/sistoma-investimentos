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

$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/quote/{symbol}', 'QuoteController@search');
$router->get('/quote/dividend/{symbol}', 'DividendController@search');

$router->group(
    ['middleware' => 'auth'],
    function ($router) {
        $router->post('/logout', 'AuthController@logout');
        $router->get('/me', 'AuthController@me');

        $router->get('/wallets', 'WalletController@list');
        $router->post('/wallet', 'WalletController@add');
        $router->post('/wallet/{walletId}', 'WalletController@update');
        $router->delete('/wallet/{walletId}', 'WalletController@remove');

        $router->post('/wallet/{walletId}/transaction', 'TransactionController@add');
    }
);
