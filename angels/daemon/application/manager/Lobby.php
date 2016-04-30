<?php
namespace angels\daemon\application\manager;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use angels\daemon\application\manager\lobbies;

/**
 * Class LobbyManager
 */
class Lobby extends Common
{
    /** @var array */
    protected $lobbies = [];

    /**
     * @param MessageComponentInterface $broker
     */
    public function __construct(MessageComponentInterface $broker)
    {
        parent::__construct($broker);

        $this->lobbies['none'] = new lobbies\Planetary($this);
        $this->lobbies['novice'] = new lobbies\Queue($this);
    }

    /**
     * @param MessageComponentInterface $server
     * @param ConnectionInterface $connection
     * @param $message
     */
    public function onMessage(MessageComponentInterface $server, ConnectionInterface $connection, $message)
    {
        $lobbyId  = (string)$message->chatId;
        if (!array_key_exists($lobbyId, $this->lobbies))
            return;

        $this->lobbies->onMessage($server, $connection, $message);
    }
}