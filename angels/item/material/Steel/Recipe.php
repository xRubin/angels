<?php
namespace angels\item\material\Steel;

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
                'item' => material\Coal\Item::class,
                'count' => 1,
            ],
            [
                'item' => material\IronOre\Item::class,
                'count' => 5,
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

    /**
     * @return int
     */
    public static function getResultCount()
    {
        return 5;
    }
}
