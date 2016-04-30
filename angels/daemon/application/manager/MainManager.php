<?php
namespace angels\daemon\application\manager;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use angels\daemon\helpers\UserStorage;
use Evenement;

class Manager implements MessageComponentInterface
{
    protected $sessions = [];

    /**
     * @var BattleManager
     */
    protected $battleManager;

    /**
     * @var BattleManager
     */
    protected $chatManager;

    /**
     * @var BattleManager
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

        $this->battleManager = new BattleManager($this);
        $this->chatManager = new ChatManager($this);
        $this->lobbyManager = new LobbyManager($this);
    }

    /**
     * @return BattleManager
     */
    public function getBattleManager()
    {
        return $this->battleManager;
    }

    /**
     * @return ChatManager
     */
    public function getChatManager()
    {
        return $this->chatManager;
    }

    /**
     * @return LobbyManager
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
            $message = json_decode($message, false);
            if (null === $message)
                return;

            if (!isset($message->command))
                return;

            switch(mb_substr((string)$message->command, 0, 2)) {
                case 'b:':
                    $this->getBattleManager()->onMessage($this, $connection, $message);
                    break;
                case 'c:':
                    $this->getChatManager()->onMessage($this, $connection, $message);
                    break;
                case 'l:':
                    $this->getLobbyManager()->onMessage($this, $connection, $message);
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
}
