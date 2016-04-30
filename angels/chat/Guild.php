<?php
namespace angels\chat;

use angels\daemon\application\manager\chat\Manager;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;
use angels\exception;

/**
 * Class Guild
 * Гильдийский чат
 */
class Guild extends Common
{
    /** @var Guild */
    protected $guild;

    /**
     * @param Manager $manager
     * @param Guild $guild
     */
    public function __construct($manager, Guild $guild)
    {
        parent::__construct($manager);

        $this->guild = $guild;
    }

    /**
     * @param Connection $connection
     * @param $message
     * @throws exception\IncorrectCommandException
     */
    public function onMessage(Connection $connection, Message $message)
    {
        if ($connection->getUser()->getGuild() === $this->guild)
            $this->publishMessage($connection, $message);

        throw new exception\IncorrectCommandException('User not in selected guild');
    }
}