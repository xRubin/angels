<?php
namespace angels\daemon\helpers;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Class Logger
 */
class Logger implements MessageComponentInterface
{
    /** @var MessageComponentInterface */
    protected $app;

    /**
     * @param MessageComponentInterface $app
     */
    public function __construct(MessageComponentInterface $app) {
        $this->app = $app;
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    public function onOpen(ConnectionInterface $conn)
    {
        printf("[%s] [INFO] Connected user with resourceId %s\n", date("Y-m-d H:i:s"), $conn->resourceId);

        $this->app->onOpen($conn);
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        printf("[%s] [INFO] Disconnected user with resourceId %s\n", date("Y-m-d H:i:s"), $conn->resourceId);

        $this->app->onClose($conn);
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception          $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        var_dump($e);
        $this->app->onError($conn, $e);
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string                       $msg  The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        var_dump($msg);
        $this->app->onMessage($from, $msg);
    }
}