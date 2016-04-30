<?php

class WebsocketTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var  React\EventLoop\StreamSelectLoop */
    protected $loop;
    /** @var  Ratchet\Client\Connector */
    protected $connector;

    public function setUp()
    {
        $this->loop = React\EventLoop\Factory::create();
        $this->connector = new Ratchet\Client\Connector($this->loop);
    }

    public function tearDown()
    {
        $this->loop->stop();
    }

    /**
     * @param \Ratchet\Client\WebSocket $conn
     * @return \React\Promise\Promise
     */
    protected function authorize(Ratchet\Client\WebSocket $conn)
    {
        $auth = new React\Promise\Deferred();

        $conn->on('message', function (\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn, $auth) {
            $conn->removeAllListeners('message');
            if ($msg === 'ok')
                $auth->resolve($conn);

            $auth->reject(new \RuntimeException("Received: {$msg}"));
        });

        $conn->send(json_encode([
            'command' => 'l:login',
            'login' => 'test',
            'password' => 'test'
        ]));

        return $auth->promise();
    }
}