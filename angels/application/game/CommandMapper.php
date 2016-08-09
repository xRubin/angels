<?php
namespace angels\application\game;

/**
 * Class CommandMapper
 */
class CommandMapper extends \angels\application\auth\CommandMapper
{
    /**
     * @var array
     */
    public static $map = [
        manager\battle\command\Go::NAME => manager\battle\command\Go::class,
        manager\chat\command\Message::NAME => manager\chat\command\Message::class,
    ];
}
