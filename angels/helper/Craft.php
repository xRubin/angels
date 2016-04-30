<?php
namespace angels\helper;

use angels\unit\Common as Unit;
use angels\craft\Recipe;
use angels\exception;

/**
 * Class Craft
 */
class Craft
{
    /**
     * @param Unit $unit
     * @param Recipe $recipe
     * @throws exception\game\craft\NotEnoughItems
     */
    public static function produce(Unit $unit, Recipe $recipe)
    {
        foreach ($recipe::getCompounds() as $option) {
            if (!$unit->inventory->hasItem($option['item'], (int)$option['count']))
                throw new exception\game\craft\NotEnoughItems();
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