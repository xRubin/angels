<?php
namespace angels\application\auth\manager\auth\command;

use util\daemon\Command;

/**
 * Class Login
 *
 * @property-read string $login
 * @property-read string $password
 */
class Login extends Command
{
    const NAME = 'auth:command\login';

    public function process()
    {
        if (($this->login === 'admin') && ($this->password === 'admin')) {
            $this->getConnection()->send([
                'result' => 'success',
                'data' => [
                    'user' => [
                        'id' => 1,
                    ],
                    'session' => md5(uniqid('s', true)),
                ]
            ]);
        }

        if (($this->login === 'test') && ($this->password === 'test')) {
            $this->getConnection()->send([
                'result' => 'success',
                'data' => [
                    'user' => [
                        'id' => 2,
                    ],
                    'session' => md5(uniqid('s', true)),
                ]
            ]);
        }

    }
}