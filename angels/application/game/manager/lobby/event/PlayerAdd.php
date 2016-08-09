<?php
namespace angels\daemon\application\manager\lobby\event;

use angels\daemon\application\Event;
use angels\unit\Common as Unit;
use angels\lobby\Common as Lobby;


class PlayerAdd extends Event
{
    /**
     * @var Lobby
     */
    protected $lobby;

    /**
     * @var Unit
     */
    protected $unit;

    /**
     * @param Lobby $lobby
     * @param Unit $unit
     */
    public function __construct(Lobby $lobby, Unit $unit)
    {
        $this->unit = $unit;
        $this->lobby = $lobby;
    }

    /**
     * @return Lobby
     */
    public function getLobby()
    {
        return $this->lobby;
    }

    /**
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

}