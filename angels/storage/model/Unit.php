<?php
namespace angels\storage\model;

use angels\daemon\application\Application;
use angels\storage\db\Game;
use util\db\AutoIncrementInterface;
use util\db\model\Hash;

/**
 * Class Unit
 * @property mixed $owner
 * @property string $ownerId
 * @property string $dt
 */
class Unit extends Hash implements AutoIncrementInterface
{
    /**
     * @return Game
     */
    public function getConnection()
    {
        return Application::getInstance()->getContainer()->get('db.game');
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return 'unit';
    }

    /**
     * @param Player $model
     */
    public function setOwner(Player $model)
    {
        $model->addUnit($this);
    }

    /**
     * @return Player
     */
    public function getOwner()
    {
        return new Player(
            new PlayerCounter($this->ownerId)
        );
    }
}