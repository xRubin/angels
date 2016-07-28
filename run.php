<?php

require __DIR__ . '/vendor/autoload.php';

use DI\ContainerBuilder;

$options = getopt("", [
    "config:"
]);
if (empty($options['config']))
    throw new ErrorException('-config required');

$builder = new ContainerBuilder();
$builder->setDefinitionCache(new Doctrine\Common\Cache\ArrayCache());
$builder->addDefinitions(__DIR__ . '/../config/' . $options['config']. '/config.php');
$builder->addDefinitions(__DIR__ . '/../config/common.php');
$container = $builder->build();

/** @var \angels\daemon\application\Application $application */
$application = $container->get(\angels\daemon\application\Application::class);
$application->setContainer($container);

$server = $container->get('server');
$server->loop->addPeriodicTimer(1, function($timer) use ($application) {
    /** @var \angels\daemon\application\Application $application */
    $application->onTimer();
});

$server->loop->run();












