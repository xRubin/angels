<?php
namespace angels\lobby;

use angels\Battle;

/**
 * Class Queue
 */
abstract class Queue extends Common
{
    /**
     * @return Battle|null
     */
    public function formBattle()
    {
        $map = $this->getMapForBattle();

        if (!$map->checkStartConditions($this->units))
            return null;

        return new Battle($this, $this->units, $map);
    }

    /**
     * @return \angels\map\Common
     */
    abstract protected function getMapForBattle();

}