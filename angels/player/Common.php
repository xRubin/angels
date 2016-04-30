<?php
namespace angels\player;

use angels\helper\Model;
use angels\player\Common as Unit;

/**
 * Class Common
 */
class Common extends Model
{
    const UNITS_DEFAULT_LIMIT = 3;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'Player';
    }

    /**
     * @return int
     */
    public function getUnitsLimit()
    {
        return self::UNITS_DEFAULT_LIMIT;
    }
}