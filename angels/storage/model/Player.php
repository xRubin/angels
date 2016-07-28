<?php
namespace angels\storage\model;

use angels\storage\db\Primary;
use util\db\Model;

/**
 * Class Player
 * @property string $email
 * @property string $password
 * @property string $dt
 */
class Player extends Model
{
    /**
     * @return Primary
     */
    public function getConnection()
    {
        return Application::getInstance()->get('db.primary');
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'player';
    }
}