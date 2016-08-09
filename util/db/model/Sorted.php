<?php
namespace util\db\model;
use util\db\ModelInterface;

/**
 * Class Sorted
 * @property string $name
 */
abstract class Sorted extends \ARedisSortedSet implements ModelInterface
{
    private $_name;

    /**
     * @param string|null $counter
     * @throws DatabaseException
     */
    public function __construct($counter)
    {
        $this->_name = $this->getKeyName($counter);

        /** @var \Redis $client */
        if (!$this->getConnection()->getClient()->exists($this->_name))
            throw new DatabaseException('Record "' . $this->_name . '"" not exists');

        parent::__construct($this->_name, $this->getConnection());
    }

    /**
     * @param mixed $counter
     * @return string
     */
    private function getKeyName($counter)
    {
        return sprintf($this->getTableName(), (string)$counter);
    }

    /**
     * @return Connection
     */
    abstract public function getTableName();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
}