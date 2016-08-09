<?php
namespace util\db;

use util\db\model\Counter;

/**
 * Interface AutoIncrementInterface
 * @package util\db
 */
interface AutoIncrementInterface
{
    /**
     * @return Counter
     */
    public function getCounterModel();
}