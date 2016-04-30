<?php
namespace angels\lobby;

use angels\unit\Common as Unit;
use angels\unit\Novice;

/**
 * Class Training
 */
class Training extends Queue
{
    /**
     * @param Unit $unit
     * @return bool
     */
    public function checkAccess(Unit $unit)
    {
        return get_class($unit) === Novice::class;
    }

    /**
     * @return \angels\map\Common
     */
    protected function getMapForBattle()
    {
        return new \angels\map\Test();
    }
}