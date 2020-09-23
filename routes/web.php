<?php

use App\Domain\Transaction\TransactionService;
use App\Domain\Transaction\TransactionStoreRequest;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;

$router->group(['prefix' => 'user'], function() use ($router) {
    $router->get('/', 'UserController@index');
});

$router->group(['prefix' => 'transaction'], function() use ($router) {
    $router->post('/', 'TransactionController@create');
});


