<?php
namespace angels\lobby;

use angels\Battle;
use angels\unit\Common as Unit;

use angels\daemon\application\Connection;
use angels\daemon\application\Message;

class Planetary extends Common
{
    /**
     * @param Unit $unit
     * @return bool
     */
    public function checkAccess(Unit $unit)
    {
        return true;
    }

    /**
     * @return Battle|null
     */
    public function formBattle()
    {
        return null;
    }

    /**
     * @param Connection $connection
     * @param Message $message
     */
    public function onMessage(Connection $connection, Message $message)
    {
        $this->publishMessage($connection, $message);
    }
}