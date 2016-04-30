<?php
namespace angels\item\material\Coal;

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
        return false;
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
        return false;
    }
}
