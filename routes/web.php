<?php

$router->group(['prefix' => 'user'], function() use ($router) {
    $router->get('/', 'UserController@index');
});

$router->group(['prefix' => 'transaction'], function() use ($router) {
    $router->post('/', 'TransactionController@create');
});
