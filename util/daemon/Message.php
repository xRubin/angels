<?php
namespace util\daemon;

/**
 * Class Message
 * @property-read string $command
 */
class Message
{
    protected $message;

    /**
     * @param string $message
     * @throws \ErrorException
     */
    public function __construct($message)
    {
        $this->message = json_decode($message);

        if (null === $this->message)
            throw new \ErrorException('Message is empty');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->message, JSON_UNESCAPED_UNICODE);
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
}
