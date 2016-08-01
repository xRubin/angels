<?php
namespace angels\daemon\application\manager\battle;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CommandSubscriber
 */
class CommandSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
        ];
    }
}