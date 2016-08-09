<?php
namespace util\db\model;

use util\db\AutoIncrementInterface;
use util\db\ModelInterface;

/**
 * Class Hash
 */
abstract class Hash extends \ARedisHash implements ModelInterface
{
    private $_key;

    /**
     * @param string $key
     * @param bool $checkExists
     * @throws \OutOfBoundsException
     * @throws \ErrorException
     */
    public function __construct($key = null, $checkExists = true)
    {
        if (null === $key) {
            if ($this instanceof AutoIncrementInterface) {
                /** @var Counter $counter */
                $counter = $this->getCounterModel();
                $key = $counter->increment();
            } else
                throw new \ErrorException('For model "' . get_called_class() . '" key required');
        } elseif ($checkExists) {
            if (!$this->getConnection()->getClient()->exists((string)$key))
                throw new \OutOfBoundsException('Record "' . (string)$key . '"" not exists');
        }

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

    /**
     * @return array
     */
    public function relations()
    {
        return [];
    }

    /**
     * @param string $name
     * @return Set|Sorted
     * @throws \ErrorException
     */
    public function getRelation($name)
    {
        if (!array_key_exists($name, $this->relations()))
            throw new \ErrorException('Unknown relation "' . $name . '"');

        $model = $this->relations()[$name];
        return new $model;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \ErrorException
     */
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);

        if (method_exists($this, $getter))
            return $this->$getter();

        if (isset($this[$name]))
            return $this[$name];

        throw new \ErrorException('Unknown property "' . $name . '"');
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     * @throws \ErrorException
     */
    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);

        if (method_exists($this, $setter))
            return $this->$setter($value);

        if (isset($this[$name]))
            return $this[$name] = $value; // set

        throw new \ErrorException('Unknown property "' . $name . '"');
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        $getter = 'get' . ucfirst($name);

        if (method_exists($this, $getter))
            return $this->$getter() !== null;

        if (isset($this[$name]))
            return true;

        return false;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __unset($name)
    {
        $setter = 'set' . ucfirst($name);

        if (method_exists($this, $setter))
            return $this->$setter(null);
        else
            unset($this[$name]);
    }
}