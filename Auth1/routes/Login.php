<?php

/** @var Laravel/Lumen/Routing/Router $router */


$router->group(['prefix' => '/login'], function () use ($router) {
    $router->get('', 'LoginController@enviarCredencial');
    $router->post('/{numero}', 'LoginController@loginPorCredencial');
});

$router->get('/painel', 'LoginController@painel');