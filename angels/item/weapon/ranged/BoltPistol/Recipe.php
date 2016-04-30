<?php
namespace angels\item\weapon\melee\BoltPistol;

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
                'count' => 5,
            ],
            [
                'item' => material\IronOre\Item::class,
                'count' => 2,
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
