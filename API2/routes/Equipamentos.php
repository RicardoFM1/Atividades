<?php

/** @var Laravel/Lumen/Routing/Router $router */


$router->group(['prefix' => '/equipamentos'], function () use ($router) {
    $router->get('', 'EquipamentosController@listarEquipamentos');
});
