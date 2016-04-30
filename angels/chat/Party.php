<?php
namespace angels\chat;

use angels\Team;

use angels\daemon\application\manager\chat\Manager;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;
use angels\exception;

/**
 * Class Party
 * Групповой чат (командный)
 */
class Party extends Common
{
    /** @var Team */
    protected $team;

    /**
     * @param Manager $manager
     * @param Team $team
     */
    public function __construct($manager, Team $team)
    {
        parent::__construct($manager);

        $this->team = $team;
    }

    /**
     * @param Connection $connection
     * @param Message $message
     * @throws exception\IncorrectCommandException
     */
    public function onMessage(Connection $connection, Message $message)
    {
        if ($this->team->getUnits()->contains($connection->getUnit()))
            $this->publishMessage($connection, $message);

        throw new exception\IncorrectCommandException('Wrong user chat');
    }
}