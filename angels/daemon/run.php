<?php

require __DIR__ . '/../vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;

use angels\daemon\helpers\Logger;
use angels\daemon\application\Manager;

$loop = Factory::create();

$application = new \angels\daemon\application\Broker();

$ws = new WsServer(
    new Logger($application)
);
$ws->disableVersion(0); // old, bad, protocol version

$server = IoServer::factory(
    new HttpServer($ws), 8030, "127.0.0.1"
);

$loop->addPeriodicTimer(1, function($timer) use ($application) {
    /** @var \angels\daemon\application\Broker $application */
    $application->onTimer();
});

$loop->run();
