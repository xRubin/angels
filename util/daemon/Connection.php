<?php
namespace util\daemon;

use Ratchet\ConnectionInterface;

/**
 * Class Connection
 * Прокси к объекту соединения для хранения в объекте собранных данных
 */
class Connection implements ConnectionInterface
{
    protected $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Send data to the connection
     * @param  string $data
     * @return ConnectionInterface
     */
    public function send($data)
    {
        return $this->connection->send(
            json_encode($data, JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * Close the connection
     */
    function close()
    {
        $this->connection->close();
    }
}