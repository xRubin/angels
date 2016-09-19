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
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->validate($message);
        $this->message = $message;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \ErrorException
     */
    public function __get($name)
    {
        if (isset($this->message->$name)) {
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
     * @param Message $message
     */
    protected function validate(Message $message)
    {
    }
    
    /**
     * Вызов обработчика
     */
    abstract public function process();
}
