<?php
namespace angels\helper;

use angels\item\Common as Item;
use angels\exceptions;

/**
 * Class Inventory
 */
class Inventory
{

    protected $storage;

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->storage = new \SplObjectStorage();

        foreach ($items as $item) {
            $this->storage->attach(self::createItemFromArray($item));
        }
    }

    /**
     * @param string $class
     * @param int $count
     * @return bool
     */
    public function hasItem($class, $count = 1)
    {
        foreach ($this->storage as $item) {
            /** @var Item $item */
            if ((get_class($item) === $class) && ((int)$item->count >= (int)$count))
                return true;
        }
        return false;
    }

    /**
     * @param string $class
     * @return bool|Item
     */
    public function getItem($class)
    {
        foreach ($this->storage as $item) {
            /** @var Item $item */
            if (get_class($item) === $class)
                return $item;
        }
        return false;
    }

    /**
     * @param string $class
     * @param int $count
     * @return bool
     */
    public function removeItem($class, $count = 1)
    {
        foreach ($this->storage as $item) {
            /** @var Item $item */
            if (get_class($item) === $class) {
                if ((int)$item->count === (int)$count) {
                    $this->storage->detach($item);
                    return true;
                } elseif ((int)$item->count > (int)$count) {
                    $item->count -= $count;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param array $config
     */
    public function addItem(array $config = [])
    {
        $item = self::createItemFromArray($config);
        if (in_array(Item::PROPERTY_STACK, $item->getProperties()) && $this->hasItem($config['class'])) {
            $this->getItem($config['class'])->count += (int)$config['count'];
        } else {
            $this->storage->attach($item);
        }
    }

    /**
     * @param array $item
     * @return Item
     * @throws \angels\exceptions\InvalidConfigException
     */
    public static function createItemFromArray(array $item = [])
    {
        if (!array_key_exists('class', $item))
            throw new exceptions\InvalidConfigException();

        $result = new $item['class'];
        unset($item['class']);

        foreach ($item as $property => $value) {
            $result->$property = $value;
        }

        return $result;
    }
}