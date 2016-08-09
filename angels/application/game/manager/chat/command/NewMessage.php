<?php
namespace angels\daemon\application\manager\chat\command;

use angels\daemon\application\Connection;
use angels\daemon\application\Message;

/**
 * Class NewMessage
 */
class NewMessage extends Common
{
    /**
     * @param Connection $connection
     * @param Message $message
     */
    public static function process(Connection $connection, Message $message)
    {
    }
}