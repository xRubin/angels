<?php
namespace angels\application\auth\manager\auth;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CommandSubscriber
 */
class CommandSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            command\Login::NAME => 'process',
        ];
    }

    /**
     * @param \util\daemon\Command $command
     */
    public function process(\util\daemon\Command $command)
    {
        $command->process();
    }
}