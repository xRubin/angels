<?php
namespace angels\storage\model;

use angels\daemon\application\Application;
use angels\storage\db\Primary;
use util\db\model\Counter;

class UnitCounter extends Counter
{
    /**
     * @return Primary
     */
    public function getConnection()
    {
        return Application::getInstance()->getContainer()->get('db.primary');
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'unit:_counter';
    }
}