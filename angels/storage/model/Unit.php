<?php
namespace angels\storage\model;

use angels\storage\db\Game;
use util\db\Model;

/**
 * Class Unit
 * @property mixed $owner
 * @property string $ownerId
 * @property string $dt
 */
class Unit extends Model
{
    /**
     * @return Game
     */
    public function getConnection()
    {
        return Application::getInstance()->get('db.game');
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
        $this->ownerId = $model->name;
    }

    /**
     * @return Player
     */
    public function getOwner()
    {
        return new Player($this->ownerId);
    }
}