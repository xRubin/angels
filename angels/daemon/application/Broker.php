<?php
namespace angels\daemon\application;

use angels\exception;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use angels\daemon\helpers\UserStorage;
use Evenement;

/**
 * Class Broker
 */
class Broker implements MessageComponentInterface
{
    protected $sessions = [];

    /**
     * @var manager\battle\Manager
     */
    protected $battleManager;

    /**
     * @var manager\chat\Manager
     */
    protected $chatManager;

    /**
     * @var manager\lobby\Manager
     */
    protected $lobbyManager;

    /**
     * @var UserStorage
     */
    protected $userStorage;

    /**
     * @void
     */
    public function __construct()
    {
        $this->userStorage = new UserStorage();

        $this->battleManager = new manager\battle\Manager($this);
        $this->chatManager = new manager\chat\Manager($this);
        $this->lobbyManager = new manager\lobby\Manager($this);
    }

    /**
     * @return manager\battle\Manager
     */
    public function getBattleManager()
    {
        return $this->battleManager;
    }

    /**
     * @return manager\chat\Manager
     */
    public function getChatManager()
    {
        return $this->chatManager;
    }

    /**
     * @return manager\lobby\Manager
     */
    public function getLobbyManager()
    {
        return $this->lobbyManager;
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
                throw new exception\connection\DuplicateConnection();
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
     * @throws exception\IncorrectCommandException
     */
    public function onMessage(ConnectionInterface $connection, $message)
    {
        try {
            $message = new Message($message);

            switch($message->getCommandType()) {
                case Message::COMMAND_TYPE_BATTLE:
                    $this->getBattleManager()->onMessage(new Connection($connection), $message);
                    break;
                case Message::COMMAND_TYPE_CHAT:
                    $this->getChatManager()->onMessage(new Connection($connection), $message);
                    break;
                case Message::COMMAND_TYPE_LOBBY:
                    $this->getLobbyManager()->onMessage(new Connection($connection), $message);
                    break;
                default:
                    throw new exception\IncorrectCommandException(sprintf('Unknown command type "%s"', $message->command));
            }

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
        $this->battleManager->emit('timer.1sec', [$this->battleManager]);
        $this->chatManager->emit('timer.1sec', [$this->chatManager]);
        $this->lobbyManager->emit('timer.1sec', [$this->lobbyManager]);
    }
}
