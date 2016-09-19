<?php

class AuthTest extends WebsocketTestCase
{
    public function testLogin()
    {
        $this->connector('ws://127.0.0.1:8030')
            ->then(function (Ratchet\Client\WebSocket $conn) {
                return $this->authorize($conn);
            }, function (\Exception $e) {
                $this->fail("Could not connect: {$e->getMessage()}");
            })->done(function (Ratchet\Client\WebSocket $conn) {
                $conn->close();
            });
        
        $this->loop->run();
    }
}