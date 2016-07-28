<?php

return [
    \angels\storage\db\Primary::class => DI\object()
        ->method('pconnect', DI\get('db.primary.host'), DI\get('db.primary.port')),
    \angels\storage\db\Game::class => DI\object()
        ->method('pconnect', DI\get('db.game.host'), DI\get('db.game.port')),
    \angels\storage\db\Statistic::class => DI\object()
        ->method('pconnect', DI\get('db.statistic.host'), DI\get('db.statistic.port')),

    angels\daemon\application\Application::class => DI\factory('angels\daemon\application\Application::getInstance'),
    angels\daemon\helpers\Logger::class => DI\object()->constructor(DI\object(angels\daemon\application\Application::class)),
    \Ratchet\WebSocket\WsServer::class => DI\object()
        ->constructor(DI\object(angels\daemon\helpers\Logger::class))
        ->method('disableVersion', 0),
    'server' => DI\factory(function (\DI\Container $container) {
        return \Ratchet\Server\IoServer::factory(
            new \Ratchet\Http\HttpServer($container->get(\Ratchet\WebSocket\WsServer::class)),
            $container->get('ws.client.port'),
            $container->get('ws.client.host')
        );
    }),

    angels\daemon\application\manager\battle\Manager::class => DI\object()->lazy(),
    angels\daemon\application\manager\chat\Manager::class => DI\object()->lazy(),
    angels\daemon\application\manager\lobby\Manager::class => DI\object()->lazy(),
];

