<?php
namespace angels\lobby;

use angels\unit\Common as Unit;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;

/**
 * Class Test
 */
class Test extends Queue
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
     * @return \angels\map\Common
     */
    protected function getMapForBattle() {
        return new \angels\map\Test();
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