<?php

class Craft extends WebsocketTestCase
{
    public function testExceptionIfNotEnoughItems()
    {
        $this->connector('ws://127.0.0.1:8030')
            ->then(function (Ratchet\Client\WebSocket $conn) {
                return $this->authorize($conn);
            })->then(function (Ratchet\Client\WebSocket $conn) {
                    $conn->on('message', function (\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn) {
                        $conn->close();
                        $this->assertContains('Exception', $msg);
                    });

                    $conn->on('close', function ($code = null, $reason = null) {
                        $this->fail("Connection closed ({$code} - {$reason})");
                    });

                    $conn->send(json_encode([
                        'command' => 'lobby:craft',
                        'recipe' => 'weapon\melee\BoltPistol',
                        'count' => 1,
                    ]));
                }, function (\Exception $e) {
                    $this->fail("Could not connect: {$e->getMessage()}");
                }
            );
        $this->loop->run();
    }
}