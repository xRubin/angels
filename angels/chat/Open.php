<?php
namespace angels\chat;

use angels\daemon\application\Connection;
use angels\daemon\application\Message;

/**
 * Class Open
 * Общий чат без ограничений
 */
class Open extends Common
{
    /**
     * @param Connection $connection
     * @param Message $message
     */
    public function onMessage(Connection $connection, Message $message)
    {
        $this->publishMessage($connection, $message);
    }
}