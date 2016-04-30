<?php
namespace angels\helper;

use angels\unit\Common as Unit;
use angels\craft\Recipe;
use angels\exceptions;

/**
 * Class Craft
 */
class Craft
{
    /**
     * @param Unit $unit
     * @param Recipe $recipe
     * @throws \angels\exceptions\ImpossibleCraftException
     */
    public static function produce(Unit $unit, Recipe $recipe)
    {
        foreach ($recipe::getCompounds() as $option) {
            if (!$unit->inventory->hasItem($option['item'], (int)$option['count']))
                throw new exceptions\ImpossibleCraftException();
        }
        foreach ($recipe::getCompounds() as $option) {
            $unit->inventory->removeItem($option['item'], (int)$option['count']);
        }
        $unit->inventory->addItem([
            'class' => $recipe::getResultClass(),
            'count' => $recipe::getResultCount()
        ]);
    }
}