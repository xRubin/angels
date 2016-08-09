<?php
namespace angels\application\auth;

use Ratchet\ConnectionInterface;
use util\daemon\Connection;
use util\daemon\Message;

/**
 * Class Daemon
 */
class Daemon extends \util\daemon\Daemon
{

    /**
     * @param ConnectionInterface $connection
     */
    public function onOpen(ConnectionInterface $connection)
    {
        printf("[%s] [INFO] Connected with resourceId %s\n", date("Y-m-d H:i:s"), $connection->resourceId);
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
}
