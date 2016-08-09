<?php
namespace util\db;

/**
 * Class ModelHash
 * @property string $name
 */
abstract class ModelHash extends \ARedisHash
{
    private $_name;

    /**
     * @param string|null $counter
     * @throws DatabaseException
     */
    public function __construct($counter = null)
    {
        if (null === $counter) {
            $this->_name = $this->getKeyName(
                (new Counter(
                    $this->getTableName(),
                    $this->getConnection()
                ))->increment()
            );
        } else {
            $this->_name = $this->getKeyName($counter);

            /** @var \Redis $client */
            if (!$this->getConnection()->getClient()->exists($this->_name))
                throw new DatabaseException('Record "' . $this->_name . '"" not exists');
        }

        parent::__construct($this->_name, $this->getConnection());
    }

    /**
     * @param mixed $counter
     * @return string
     */
    private function getKeyName($counter) {
        return sprintf('%s:%s', $this->getTableName(), (string)$counter);
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

    /**
     * @return array
     */
    public function relations()
    {
        return [];
    }

    /**
     * @param string $name
     * @return ModelSet|ModelSortedSet
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