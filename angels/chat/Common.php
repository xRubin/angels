<?php
namespace angels\chat;

use angels\daemon\application\manager\chat\Manager;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;

/**
 * Class Common
 */
abstract class Common
{
    /** @var Manager  */
    protected $manager;

    /** @var \SplStack  */
    protected $data;

    /**
     * @param Manager $manager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;

        $this->data = new \SplStack();
    }

    /**
     * @param Connection $connection
     * @param Message $message
     */
    abstract public function onMessage(Connection $connection, Message $message);


    /**
     * @param Connection $connection
     * @param $message
     */
    protected function publishMessage(Connection $connection, Message $message)
    {
        $this->data->push(
            new Record($connection, $message)
        );
    }
}

/**
 * Class Record
 * Единичная запись в чате
 * @package angels\daemon\application\manager\chat\entity
 */
class Record implements \JsonSerializable
{

    protected $userId;
    protected $signature;
    protected $message;

    public function __construct(Connection $connection, Message $message)
    {
        $this->userId = $connection->getUserId();
        $this->signature = $connection->getUserSignature();
        $this->message = $message->chatMessage;
    }

    public function jsonSerialize() {
        return [
            'userId' => $this->userId,
            'signature' => $this->signature,
            'message' => $this->message,
        ];
    }
}