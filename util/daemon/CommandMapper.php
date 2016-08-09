<?php
namespace util\daemon;

/**
 * Class CommandMapper
 */
class CommandMapper
{
    /**
     * @var array
     */
    public static $map = [];

    /**
     * @param Message $message
     * @return Command
     * @throws \ErrorException
     */
    public static function getObject(Message $message)
    {
        if (array_key_exists($message->command, static::$map)) {
            $commandClass = static::$map[$message->command];
            return new $commandClass($message);
        }

        throw new \ErrorException('Unrecognized command');
    }
}
