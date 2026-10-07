<?php

/** @var Laravel/Lumen/Routing/Router $router */


$router->group(['prefix' => '/livros'], function () use ($router) {
    $router->get('', 'LivroController@listarLivros');
    $router->get('/{livroId}', 'LivroController@listarLivroPorId');
});