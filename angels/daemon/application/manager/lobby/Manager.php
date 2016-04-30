<?php
namespace angels\daemon\application\manager\lobby;

use angels\daemon\application\manager\Common;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;
use angels\daemon\application\Broker;

use angels\lobby;

/**
 * Class Manager
 */
class Manager extends Common
{

    /** @var lobby\Common[] */
    protected $lobbies = [];

    const LOBBY_PLANETARY = 'none';
    const LOBBY_NOVICE = 'novice';

    /**
     * @param Broker $broker
     */
    public function __construct(Broker $broker)
    {
        parent::__construct($broker);

        $this->lobbies[self::LOBBY_PLANETARY] = new lobby\Planetary($this);
        $this->lobbies[self::LOBBY_NOVICE] = new lobby\Novice($this);

        $this->on('lobby.command.changeLobby', [command\ChangeLobby::class, 'process']);

        $this->on('lobby.event.addUnit', [event\addUnit::class, 'process']);
        $this->on('lobby.event.removeUnit', [event\removeUnit::class, 'process']);
    }

    /**
     * @return lobby\Common[]
     */
    public function getLobbies()
    {
        return $this->lobbies;
    }

    /**
     * @param Connection $connection
     * @param Message $message
     */
    public function onMessage(Connection $connection, Message $message)
    {
        if (array_key_exists($message->lobbyId, $this->getLobbies())) {
            $lobby = $this->getManager()->getLobbies()[$message->lobbyId];
        } else {
            // todo: создание каналов?
            $lobby = null;
        }

        if ($message->getCommand() === 'ChangeLobby') {
            $this->emit('lobby.command.changeLobby', [$lobby, $connection->getUnit()]);
        } else
            $lobby->onMessage($connection, $message);
    }
}
