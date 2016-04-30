<?php
namespace angels\daemon\application\manager\lobby\command;

use angels\unit\Common as Unit;
use angels\lobby\Common as Lobby;

/**
 * Class ChangeLobby
 */
class ChangeLobby extends Common
{
    /**
     * @param Lobby $lobby
     * @param Unit $unit
     */
    public static function process(Lobby $lobby, Unit $unit)
    {
        if ($lobby->checkAccess($unit) && !$lobby->getUnits()->contains($unit)) {

            $unit->getLobby()->getUnits()->detach($unit);
            $lobby->emit('lobby.event.removeUnit', [$unit->getLobby(), $unit]);

            $lobby->getUnits()->attach($unit);
            $lobby->emit('lobby.event.addUnit', [$lobby, $unit]);

            $unit->setLobby($lobby);
        }
    }
}