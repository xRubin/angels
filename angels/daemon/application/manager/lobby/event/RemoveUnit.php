<?php
namespace angels\daemon\application\manager\lobby\event;

use angels\unit\Common as Unit;
use angels\lobby\Common as Lobby;

class RemoveUnit extends Common
{
    public static function process(Lobby $lobby, Unit $unit)
    {
        //todo: inform other users
    }
}