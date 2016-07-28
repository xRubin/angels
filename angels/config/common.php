<?php

use DI\Container;

return [
    \angels\storage\db\Primary::class => DI\object()
        ->method('pconnect', DI\get('db.primary.host'), DI\get('db.primary.port'))
    ,
    \angels\storage\db\Game::class => DI\object()
        ->method('pconnect', DI\get('db.game.host'), DI\get('db.game.port'))
    ,
    \angels\storage\db\Statistic::class => DI\object()
        ->method('pconnect', DI\get('db.statistic.host'), DI\get('db.statistic.port'))
    ,

    angels\daemon\application\Application::class => \DI\object()->method('getInstance'),
    angels\daemon\application\manager\battle\Manager::class => \DI\object()->lazy(),
    angels\daemon\application\manager\chat\Manager::class => \DI\object()->lazy(),
    angels\daemon\application\manager\lobby\Manager::class => \DI\object()->lazy(),
];

