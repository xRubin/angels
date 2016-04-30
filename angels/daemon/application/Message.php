<?php
namespace angels\daemon\application;

use angels\exception;

/**
 * Class Message
 * @property-read string $command
 *
 * @property-read string $chatId
 * @property-read string $chatMessage
 *
 * @property-read string $battleId
 */
class Message
{
    private $message;

    const COMMAND_TYPE_BATTLE = 'b:';
    const COMMAND_TYPE_CHAT = 'c:';
    const COMMAND_TYPE_LOBBY = 'l:';

    // todo: mapper сокращений

    /**
     * @param string $message
     * @throws exception\connection\IncorrectCommand
     */
    public function __construct($message)
    {
        $this->message = json_decode($message);

        if (null === $this->message)
            throw new exception\connection\IncorrectCommand('Message is empty');
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
     * @throws exception\connection\IncorrectCommand
     */
    public function __get($name)
    {
        if (isset($this->message->$name)) {
            return $this->message->$name;
        }

        throw new exception\connection\IncorrectCommand(sprintf('Message has not field "%s"', $name));
    }

    /**
     * @return string
     */
    public function getCommandType()
    {
        return mb_substr($this->command, 0, 2);
    }
}
