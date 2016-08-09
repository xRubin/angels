<?php
namespace util\db;

/**
 * Interface ModelInterface
 * @package util\db
 */
interface ModelInterface
{
    /**
     * @param string $key
     * @return string
     */
    public function getTableName($key);

    /**
     * @return Connection
     */
    public function getConnection();
}