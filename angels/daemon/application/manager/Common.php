<?php
namespace angels\daemon\application\manager;

use angels\daemon\application\Message;
use angels\daemon\application\Connection;
use Evenement;

/**
 * Class Common
 */
abstract class Common
{
    use Evenement\EventEmitterTrait;
    
    /**
     * @param Connection $connection
     * @param Message $message
     */
    abstract public function onMessage(Connection $connection, Message $message);
}