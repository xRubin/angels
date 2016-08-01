<?php
namespace angels\daemon\application\manager\battle;

use angels\daemon\application\manager\Common;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;

use angels\Battle;

/**
 * Class Manager
 */
class Manager extends Common
{
    /** @var Battle[] */
    protected $battles = [];

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->getDispatcher()->addSubscriber(new EventSubscriber());
        $this->getDispatcher()->addSubscriber(new CommandSubscriber());
    }

    /**
     * @param Connection $connection
     * @param Message $message
     */
    public function onMessage(Connection $connection, Message $message)
    {
        $battleId  = (string)$message->battleId;
        if (!array_key_exists($battleId, $this->battles)) {
            // ничего не делаем
            return;
        }

        $this->battles[$battleId]->onMessage($connection, $message);
    }
}
