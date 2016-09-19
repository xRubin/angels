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

            $data = json_decode($msg, true);
            
            assertArrayHasKey('result', $data);
            assertArrayHasKey('data', $data);
            assertArrayHasKey('id', $data['data']);
            assertEquals(2, (int)$data['data']['id']);

            $auth->resolve($conn);
        });

        $conn->send(json_encode([
            'command' => 'auth:command\login',
            'login' => 'test',
            'password' => 'test'
        ]));

        return $auth->promise();
    }
}