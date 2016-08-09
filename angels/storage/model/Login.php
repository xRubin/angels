<?php
namespace angels\storage\model;

use angels\daemon\application\Application;
use angels\storage\db\Primary;
use util\db\model\Hash;

/**
 * Class Login
 * @property string $playerId
 * @property string $password
 * @property string $dt
 */
class Login extends Hash
{
    /**
     * @return Primary
     */
    public function getConnection()
    {
        return Application::getInstance()->getContainer()->get('db.primary');
    }

    /**
     * @param string $key
     * @return string
     */
    public function getTableName($key = null)
    {
        return sprintf('login:%s', (string)$key);
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return new Player($this->playerId);
    }
}