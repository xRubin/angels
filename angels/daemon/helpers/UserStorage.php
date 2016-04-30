<?php
namespace angels\daemon\helpers;

use Ratchet\ConnectionInterface;

/**
 * Class UserStorage
 */
class UserStorage extends \SplObjectStorage
{
    /**
     * @param string $resourceId
     * @return ConnectionInterface
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
     * @return ConnectionInterface
     */
    public function findConnectionByUserId($userId)
    {
        foreach ($this as $connection) {
            if ($this[$connection]->id === $userId)
                return $connection;
        }
    }
}