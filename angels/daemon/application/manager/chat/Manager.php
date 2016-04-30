<?php
namespace angels\daemon\application\manager\chat;

use angels\daemon\application\manager\Common;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;
use angels\daemon\application\Broker;

use angels\chat;

/**
 * Class Manager
 */
class Manager extends Common
{
    /** @var chat\Common[] */
    protected $chats = [];

    /**
     * @param Broker $broker
     */
    public function __construct(Broker $broker)
    {
        parent::__construct($broker);

        $this->chats['common'] = new chat\Open($this);
        $this->chats['trade'] = new chat\Open($this);
    }

    /**
     * @param Connection $connection
     * @param Message $message
     */
    public function onMessage(Connection $connection, Message $message)
    {
        $chatId  = (string)$message->chatId;
        if (!array_key_exists($chatId, $this->chats)) {
            //todo: создание каналов
            return;
        }

        $this->chats[$chatId]->onMessage($connection, $message);
    }
}
