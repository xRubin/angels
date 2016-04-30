<?php
namespace angels\daemon\application\manager;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Class ChatManager
 */
class ChatManager extends CommonManager
{
    /** @var array */
    protected $chats = [];

    /**
     * @param MessageComponentInterface $broker
     */
    public function __construct(MessageComponentInterface $broker)
    {
        parent::__construct($broker);

        $this->chats['common'] = new ChatCommon($this);
        $this->chats['trade'] = new ChatCommon($this);
    }

    /**
     * @param MessageComponentInterface $server
     * @param ConnectionInterface $connection
     * @param $message
     */
    public function onMessage(MessageComponentInterface $server, ConnectionInterface $connection, $message)
    {
        $chatId  = (string)$message->chatId;
        if (!array_key_exists($chatId, $this->chats))
            return;

        $this->chats->onMessage($server, $connection, $message);
    }
}
