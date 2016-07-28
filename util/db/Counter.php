<?php
namespace util\db;

class Counter extends ARedisCounter
{
    /**
     * Constructor
     * @param string $name the name of the entity
     * @param ARedisConnection|string $connection the redis connection to use with this entity
     */
    public function __construct($name = null, $connection = null) {
        $name .= ':_counter';
        parent::__construct($name, $connection);
    }

}