<?php

/** @var Laravel/Lumen/Routing/Router $router */


$router->group(['prefix' => '/reservas'], function () use ($router) {
    $router->get('', 'ReservasController@listarReservasPorEquipamento');
    $router->post('', 'ReservasController@criarReserva');
    $router->delete('/{reservaId}', 'ReservasController@deletarReserva');
});
