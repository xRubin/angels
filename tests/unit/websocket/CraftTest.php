<?php

class CraftTest extends WebsocketTestCase
{
    public function testExceptionIfNotEnoughItems()
    {
        $this->connector('ws://127.0.0.1:8030')
            ->then(function (Ratchet\Client\WebSocket $conn) {
                return $this->authorize($conn);
            }, function (\Exception $e) {
                $this->fail("Could not connect: {$e->getMessage()}");
            })->then(function (Ratchet\Client\WebSocket $conn) {
                $test = new React\Promise\Deferred();

                $conn->on('message', function (\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn, $test) {
                    $this->assertEquals('Exception', $msg);
                    $test->resolve($conn);
                });

                $conn->send(json_encode([
                    'command' => 'lobby:craft',
                    'recipe' => 'weapon\melee\BoltPistol',
                    'count' => 1,
                ]));

                return $test->promise();
            })->done(function (Ratchet\Client\WebSocket $conn) {
                $conn->close();
            });
        
        $this->loop->run();
    }
}