<?php
namespace angels\item\relic;

/**
 * Class Common
 */
class Common extends \angels\item\Common {

    /**
     * @return array
     */
    public function getProperties() {
        return [
            self::PROPERTY_DISPOSABLE,
            self::PROPERTY_RELIC,
            self::PROPERTY_STACK,
        ];
    }

    /**
     * @return int
     */
    public function getMaxDurability() {
        return 0;
    }
}