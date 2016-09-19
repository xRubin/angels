<?php
namespace util\db\model;
use util\db\Connection;
use util\db\ModelInterface;

/**
 * Class Set
 * @property string $name
 */
abstract class Set extends \ARedisSet implements ModelInterface
{
    private $_key;

    /**
     * @param string|null $key
     */
    public function __construct($key = null)
    {
        $this->_key = (string)$key;

        parent::__construct($this->getTableName($key), $this->getConnection());
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->_key;
    }
}