<?php

/** @var Laravel/Lumen/Routing/Router $router */


$router->group(['prefix' => '/login'], function () use ($router) {
    $router->get('', 'LoginController@retornarCredencial');
});
