<?php

return [
    \angels\storage\db\Primary::class => DI\object()
        ->method('pconnect', DI\get('db.primary.host'), DI\get('db.primary.port')),
    \angels\storage\db\Game::class => DI\object()
        ->method('pconnect', DI\get('db.game.host'), DI\get('db.game.port')),
    \angels\storage\db\Statistic::class => DI\object()
        ->method('pconnect', DI\get('db.statistic.host'), DI\get('db.statistic.port')),

    Symfony\Component\EventDispatcher\EventDispatcherInterface::class => DI\object(Symfony\Component\EventDispatcher\EventDispatcher::class),

    \Ratchet\WebSocket\WsServer::class => DI\factory(function (\DI\Container $container) {
        $application = new angels\application\game\Daemon(
            $container->get(Symfony\Component\EventDispatcher\EventDispatcherInterface::class)
        );

        $application->addManager(
            $container->get(angels\application\game\manager\battle\Manager::class)
        );
        $application->addManager(
            $container->get(angels\application\game\manager\chat\Manager::class)
        );
        $application->addManager(
            $container->get(angels\application\game\manager\lobby\Manager::class)
        );

        $wsServer = new \Ratchet\WebSocket\WsServer(
            new angels\application\Logger(
                $application
            )
        );

        $wsServer->disableVersion(0);

        return $wsServer;
    }),

    angels\application\game\manager\battle\Manager::class => DI\object()->lazy(),
    angels\application\game\manager\chat\Manager::class => DI\object()->lazy(),
    angels\application\game\manager\lobby\Manager::class => DI\object()->lazy(),
];

