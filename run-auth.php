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
$builder->addDefinitions(__DIR__ . '/config/auth/' . $options['config']. '/config.php');
$builder->addDefinitions(__DIR__ . '/config/auth/common.php');
$container = $builder->build();

/** @var \angels\application\auth\Daemon $application */
$application = $container->get(\angels\application\auth\Daemon::class);

$server = $container->get('server');
$server->loop->run();












