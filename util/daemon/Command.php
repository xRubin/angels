<?php
namespace util\daemon;

/**
 * Class Command
 */
abstract class Command extends \Symfony\Component\EventDispatcher\Event
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * Command constructor.
     * @param Message|null $message
     */
    public function __construct(Message $message = null)
    {
        $this->message = $message;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \ErrorException
     */
    public function __get($name)
    {
        if ((null !== $this->message) && isset($this->message->$name)) {
            return $this->message->$name;
        }

        throw new \ErrorException(sprintf('Message has not field "%s"', $name));
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Вызов обработчика
     * @void
     */
    abstract public function process();
}
