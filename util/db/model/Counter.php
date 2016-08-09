<?php
namespace util\db\model;

use util\db\ModelInterface;

/**
 * Class Counter
 */
abstract class Counter extends \ARedisCounter implements ModelInterface
{
    public function __construct()
    {
        parent::__construct($this->getTableName(null), $this->getConnection());
    }
}