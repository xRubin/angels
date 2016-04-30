<?php
namespace angels\daemon\application\manager;

use angels\daemon\application\Broker;
use angels\daemon\application\Message;
use angels\daemon\application\Connection;

/**
 * Class Common
 */
abstract class Common
{
    /** @var Broker */
    protected $broker;

    /**
     * @param Broker $broker
     */
    public function __construct(Broker $broker)
    {
        $this->broker = $broker;
    }

    /**
     * @param Connection $connection
     * @param Message $message
     */
    abstract public function onMessage(Connection $connection, Message $message);
}