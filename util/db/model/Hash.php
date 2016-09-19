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
    final public function __construct($key = null, $checkExists = true)
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

        $this->init();
    }

    /**
     * Initialize
     */
    public function init()
    {

    }

    /**
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes)
    {
        $model = new static(null, false);
        $model->fill($attributes);
        return $model;
    }

    /**
     * @param  string $key
     * @return static
     */
    public static function find($key)
    {
        try {
            return new static($key);
        } catch (\OutOfBoundsException $e) {
            return null;
        }
    }

    /**
     * @param  array  $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
        return $this;
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

        $modelClass = $this->relations()[$name];
        if (! $modelClass instanceof Set)
            throw new \ErrorException('Incorrect class for relation "' . $name . '"');

        return new $modelClass;
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

    /**
     * @throws \CException
     */
    public function delete()
    {
        $this->getConnection()->getClient()->delete($this->getKey());
    }
}