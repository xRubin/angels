<?php
namespace angels\map;

use angels\Battle;
use angels\exception;
use angels\helper\Object;
use angels\Team;
use angels\unit\Common as Unit;
use angels\lobby\Common as Lobby;
use angels\map\distribution\Common as Distribution;
use angels\helper\Translate;

/**
 * Class Common
 */
class Common extends Object
{
    /** @var Battle */
    protected $battle;

    /** @var Distribution */
    public $distribution;

    /**
     * @return void
     */
    public function init()
    {
        parent::init();
        if (is_array($this->distribution))
            $this->distribution = Object::createObject($this->distribution);
    }

    /**
     * @param Team $team
     * @return array
     * @throws exception\BadCodeException
     */
    public function getRespawnPoints(Team $team)
    {
        throw new exception\BadCodeException(Translate::t('Respawn points not implemented'));
    }

    /**
     * @param Point $point1
     * @param Point $point2
     * @return float
     */
    public function range(Point $point1, Point $point2)
    {
        return sqrt(pow($point1->getX() - $point2->getX(), 2) + pow($point1->getY() - $point2->getY(), 2));
    }

    /**
     * @param Unit $unit
     * @return void
     * @throws exception\BadCodeException
     */
    public function respawnUnit(Unit $unit)
    {
        foreach ($this->getRespawnPoints($unit->getTeam()) as $point) {
            if (null === $this->unitAt($point)) {
                $unit->setPoint($point);
                return;
            }
        }
        throw new exception\BadCodeException(Translate::t('Not enough respawn points'));
    }

    /**
     * @param Point $point
     * @return Unit|null
     */
    public function unitAt(Point $point)
    {
        foreach ($this->getBattle()->getTeams() as $team) {
            /** @var Team $team */
            foreach ($team->getUnits() as $unit) {
                /** @var Unit $unit */
                if ($unit->getPoint() == $point)
                    return $unit;
            }
        }
    }

    /**
     * @return Battle
     */
    public function getBattle()
    {
        return $this->battle;
    }

    /**
     * @param Battle $battle
     */
    public function setBattle($battle)
    {
        $this->battle = $battle;
    }

    /**
     * @return Distribution
     */
    public function getDistribution()
    {
        return $this->distribution;
    }

    /**
     * @param Distribution $distribution
     */
    public function setDistribution($distribution)
    {
        $this->distribution = $distribution;
    }

    /**
     * @param \SplObjectStorage $units
     * @return bool
     * @throws exception\BadCodeException
     */
    public function checkStartConditions($units)
    {
        throw new exception\BadCodeException(Translate::t('Start conditions not defined'));
    }

    /**
     * @param Lobby $lobby
     * @param \SplObjectStorage $units
     * @return \SplObjectStorage
     * @throws exception\BadCodeException
     */
    public function formTeams($lobby, $units)
    {
        throw new exception\BadCodeException(Translate::t('Form teams algorithm not defined'));
    }
}