<?php
namespace angels\application;

/**
 * Class UserStorage
 */
class UserStorage extends \SplObjectStorage
{
    /**
     * @param string $resourceId
     * @return Connection
     */
    public function findConnectionByResourceId($resourceId)
    {
        foreach ($this as $connection) {
            if ($connection->resourceId === $resourceId)
                return $connection;
        }
    }

    /**
     * @param string $userId
     * @return Connection
     */
    public function findConnectionByUserId($userId)
    {
        foreach ($this as $connection) {
            if ($this[$connection]->id === $userId)
                return $connection;
        }
    }
}