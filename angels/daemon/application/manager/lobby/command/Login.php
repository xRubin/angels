<?php
namespace angels\daemon\application\manager\lobby\command;

use angels\daemon\application\Connection;
use angels\daemon\application\Message;

/**
 * Class Login
 */
class Login extends Common
{
    /**
     * @param Connection $connection
     * @param Message $message
     */
    public static function process(Connection $connection, Message $message)
    {
        $message->login;
        $message->password;
    }
}