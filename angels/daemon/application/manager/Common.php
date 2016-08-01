<?php
namespace angels\daemon\application\manager;

use angels\daemon\application\Application;
use angels\daemon\application\Message;
use angels\daemon\application\Connection;

/**
 * Class Common
 */
abstract class Common
{
    /**
     * @param Connection $connection
     * @param Message $message
     */
    abstract public function onMessage(Connection $connection, Message $message);

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getDispatcher()
    {
        return Application::getInstance()->getDispatcher();
    }
}