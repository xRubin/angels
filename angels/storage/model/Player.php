<?php
namespace angels\storage\model;

use angels\daemon\application\Application;
use angels\storage\db\Primary;
use angels\storage\relation\PlayerUnits;
use util\db\AutoIncrementInterface;
use util\db\model\Hash;

/**
 * Class Player
 * @property string $email
 * @property string $password
 * @property string $dt
 */
class Player extends Hash implements AutoIncrementInterface
{
    /**
     * @return Primary
     */
    public function getConnection()
    {
        return Application::getInstance()->getContainer()->get('db.primary');
    }

    /**
     * @return PlayerCounter
     */
    public function getCounterModel()
    {
        return new PlayerCounter();
    }

    /**
     * @param string $key
     * @return string
     */
    public function getTableName($key = null)
    {
        return sprintf('player:%09s', (string)$key);
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'units' => PlayerUnits::class
        ];
    }

    /**
     * @return Unit[]
     */
    public function getUnits()
    {
        return array_map(function($unitName) {
            return new Unit(
                new UnitCounter($unitName)
            );
        }, $this->getRelation('units')->getData());
    }

    /**
     * @param Unit $model
     * @throws \ErrorException
     */
    public function addUnit(Unit $model) {
        $model->ownerId = $this->name;
        $this->getRelation('units')->add($model->name);
    }
}