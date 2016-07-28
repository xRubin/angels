<?php
namespace angels\daemon\application\manager\lobby;

use angels\daemon\application\manager\Common;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;
use angels\daemon\application\Application;

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
     * Manager constructor.
     */
    public function __construct()
    {
        $this->lobbies[self::LOBBY_PLANETARY] = Application::getInstance()->getContainer()->get(lobby\Planetary::class);
        $this->lobbies[self::LOBBY_NOVICE] = Application::getInstance()->getContainer()->get(lobby\Novice::class);

        $this->on('lobby.command.login', [command\Login::class, 'process']);
        $this->on('lobby.command.changeLobby', [command\ChangeLobby::class, 'process']);
        $this->on('lobby.command.craft', [command\Craft::class, 'process']);

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

            $lobby->onMessage($connection, $message);
        } else {
            // todo: создание каналов?
        }

    }
}
