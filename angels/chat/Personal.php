<?php
namespace angels\chat;

use angels\daemon\application\manager\chat\Manager;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;
use angels\exception\IncorrectCommandException;

/**
 * Class Personal
 * Приватный чат
 */
class Personal extends Common
{
    /** @var array */
    protected $members;

    /**
     * @param Manager $manager
     * @param Unit $unit1
     * @param Unit $unit2
     */
    public function __construct($manager, Unit $unit1, Unit $unit2)
    {
        parent::__construct($manager);

        $this->members = [
            $unit1->getId(),
            $unit2->getId()
        ];
    }

    /**
     * @param Connection $connection
     * @param $message
     * @throws IncorrectCommandException
     */
    public function onMessage(Connection $connection, Message $message)
    {
        if (in_array($connection->getUnit()->getId(), $this->members))
            $this->publishMessage($connection, $message);

        throw new IncorrectCommandException('Wrong user chat');
    }
}