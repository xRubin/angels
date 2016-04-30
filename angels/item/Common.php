<?php

namespace angels\item;

/**
 * Class Common
 */
abstract class Common {

    const PROPERTY_EQUIP = 1; // можно надеть
    const PROPERTY_DESTRUCTIBLE = 2; // ломается
    const PROPERTY_DISPOSABLE = 3; // можно выбросить
    const PROPERTY_RELIC = 4; // реликвия. в слоты
    const PROPERTY_STACK = 5; // складывается в кучки

    /** @var int */
    public $count = 1;

    /** @var bool */
    public $equipped = false;

    /**
     * @return array
     */
    abstract public function getProperties();

    /**
     * @return int
     */
    abstract public function getMaxDurability();

}