<?php
namespace angels\daemon\application\manager\lobby\event;

use angels\lobby\Planetary;
use angels\unit\Common as Unit;
use angels\lobby\Common as Lobby;

class AddUnit extends Common
{
    public static function process(Lobby $lobby, Unit $unit)
    {
        //todo: inform other users

        if (!$lobby instanceof Planetary)
            $lobby->formBattle();
    }
}