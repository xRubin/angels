<?php
namespace angels\application\game;

use angels\daemon\application\event\Interval1Sec;
use Ratchet\ConnectionInterface;
use angels\application\UserStorage;
use util\daemon\Connection;
use util\daemon\Message;

/**
 * Class Daemon
 */
class Daemon extends \util\daemon\Daemon
{
    protected $userStorage;

    public function init()
    {
        $this->userStorage = new UserStorage();
    }

    /**
     * @return UserStorage
     */
    public function getUserStorage()
    {
        return $this->userStorage;
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function onOpen(ConnectionInterface $connection)
    {
        try {
            $user = new ChatUser($connection);
            if ($this->getUserStorage()->findConnectionByUserId($user->id)) {
                throw new \ErrorException('Duplicate connection');
            }

            $this->getUserStorage()->attach($connection, $user);
            printf("[%s] [INFO] Connected user %s with resourceId %s\n", date("Y-m-d H:i:s"), $user->id, $connection->resourceId);

        } catch (\Exception $e) {
            $this->onError($connection, $e);
        }
    }

    /**
     * @param ConnectionInterface $connection
     * @param string $message
     */
    public function onMessage(ConnectionInterface $connection, $message)
    {
        try {
            $command = CommandMapper::getObject($message = new Message($message));
            $command->setConnection(new Connection($connection));
            $this->getDispatcher()->dispatch($command::NAME, $command);
        } catch (\Exception $e) {
            $this->onError($connection, $e);
        }
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function onClose(ConnectionInterface $connection)
    {
        $this->getUserStorage()->detach($connection);
    }

    /**
     * @param ConnectionInterface $connection
     * @param \Exception $exception
     */
    public function onError(ConnectionInterface $connection, \Exception $exception)
    {
        printf("[%s] [ERROR] %s [%s:%s]\n", date('Y-m-d H:i:s'), $exception->getMessage(), $exception->getFile(), $exception->getLine());

        $connection->close();
    }

    /**
     * Дергается раз в секунду
     */
    public function onTimer()
    {
        $this->getDispatcher()->dispatch(Interval1Sec::class, new Interval1Sec());
    }
}
