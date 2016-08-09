<?php
namespace angels\storage\relation;

use util\db\model\Counter;
use util\db\model\Set;

/**
 * Class PlayerUnits
 * @package angels\storage\relation
 */
class PlayerUnits extends Set
{
    /**
     * @param Counter $counter
     * @return string
     */
    public function getTableName(Counter $counter = null)
    {
        return sprintf('player:%s:units', (string)$counter->getValue());
    }
}
