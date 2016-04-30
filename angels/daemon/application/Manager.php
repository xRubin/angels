<?php
namespace angels\daemon\application;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Evenement;

class Manager implements MessageComponentInterface
{
    protected $sessions = [];

    /**
     * @var BattleManager
     */
    protected $battleManager;

    /**
     * @var UserStorage
     */
    protected $connections;

    /**
     * @var Evenement\EventEmitter
     */
    protected $emitter;

    public function __construct()
    {
        $this->connections = new UserManager();
        $this->battleManager = new BattleManager();
        $this->emitter = new Evenement\EventEmitter();

        $this->emitter->on('Battle\UseSkill', [$this->battleManager, 'onUseSkill']);
        $this->emitter->on('Chat\Message', [$this->chatManager, 'onMessage']);
    }

    /**
     * @return UserManager
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     * @param ConnectionInterface $connection
     * @return ChatUser
     */
    public function getUser(ConnectionInterface $connection) {
        return $this->getConnections()[$connection];
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function onOpen(ConnectionInterface $connection)
    {
        try {
            $user = new ChatUser($connection);
            if ($this->getConnections()->findConnectionByUserId($user->id)) {
                throw new \ErrorException('Duplicate connection');
            }

            $this->getConnections()->attach($connection, $user);
            printf("[%s] [INFO] Connected user %s with resourceId %s\n", date("Y-m-d H:i:s"), $user->id, $connection->resourceId);

            \Websocket\Dialog\InformUnread::onMessage($this, $connection, $user->getUser());

        } catch (\Exception $e) {
            $this->onError($connection, $e);
        }
    }

    /**
     * @param ConnectionInterface $connection
     * @param string $message
     * @throws ErrorException
     */
    public function onMessage(ConnectionInterface $connection, $message)
    {
        try {
            $message = json_decode($message, false);
            if (null === $message)
                return;

            if (!isset($message->command))
                return;

            switch(mb_substr((string)$message->command, 0, 2)) {
                case 'b:':
                    $this->battleManager->onMessage($this, $connection, $message);
                    break;
                case 'c:':
                    $this->chatManager->onMessage($this, $connection, $message);
                    break;
                case 'l:':
                    $this->lobbyManager->onMessage($this, $connection, $message);
                    break;
                default:
                    throw new \ErrorException('Unknown command: ' . $message->command);
            }

        } catch (\Exception $e) {
            printf("[%s] [ERROR] %s\n", date("Y-m-d H:i:s"), $e->getMessage());
        }
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function onClose(ConnectionInterface $connection)
    {
        $this->getConnections()->detach($connection);
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
