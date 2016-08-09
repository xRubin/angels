<?php
namespace angels\storage\model;

use angels\daemon\application\Application;
use angels\storage\db\Primary;
use util\db\model\Counter;

class PlayerCounter extends Counter
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
        return 'player:_counter';
    }
}