<?php
namespace angels\item\weapon\melee\AssaultShield;

use angels\item\material;

/**
 * Class Recipe
 */
class Recipe extends \angels\craft\Recipe
{
    /**
     * @return array
     */
    public static function getCompounds()
    {
        return [
            [
                'item' => Fragment::class,
                'count' => 20,
            ],
            [
                'item' => material\Steel\Item::class,
                'count' => 20,
            ],
        ];
    }

    /**
     * @return string
     */
    public static function getResultClass()
    {
        return namespace\Item::class;
    }
}
