<?php

return [
    \angels\storage\db\Primary::class => DI\object()
        ->method('pconnect', DI\get('db.primary.host'), DI\get('db.primary.port')),

    Symfony\Component\EventDispatcher\EventDispatcherInterface::class => DI\object(Symfony\Component\EventDispatcher\EventDispatcher::class),

    \Ratchet\WebSocket\WsServer::class => DI\factory(function (\DI\Container $container) {
        $application = new angels\application\auth\Daemon(
            $container->get(Symfony\Component\EventDispatcher\EventDispatcherInterface::class)
        );
        
        $application->addManager(
            $container->get(angels\application\auth\manager\auth\Manager::class)
        );

        $wsServer = new \Ratchet\WebSocket\WsServer(
            new angels\application\Logger(
                $application
            )
        );

        $wsServer->disableVersion(0);

        return $wsServer;
    }),


    'server' => DI\factory(function (\DI\Container $container) {
        return \Ratchet\Server\IoServer::factory(
            new \Ratchet\Http\HttpServer($container->get(\Ratchet\WebSocket\WsServer::class)),
            $container->get('ws.client.port'),
            $container->get('ws.client.host')
        );
    }),

    angels\application\auth\manager\auth\Manager::class => DI\object()->lazy(),
];

