<?php
namespace angels\application\auth;

/**
 * Class CommandMapper
 */
class CommandMapper extends \util\daemon\CommandMapper
{
    /**
     * @var array
     */
    public static $map = [
        manager\auth\command\Login::NAME => manager\auth\command\Login::class,
    ];
}
