<?php
namespace angels\item\weapon;

/**
 * Class Common
 */
class Common extends \angels\item\Common {

    /**
     * @return array
     */
    public function getProperties() {
        return [
            self::PROPERTY_DESTRUCTIBLE,
            self::PROPERTY_DISPOSABLE,
            self::PROPERTY_EQUIP,
        ];
    }

    /**
     * @return int
     */
    public function getMaxDurability() {
        return 0;
    }

}