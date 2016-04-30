<?php
namespace angels\unit;

use angels\exception;
use angels\helper\Object;
use angels\map\Point;
use angels\Team;
use angels\skill\Common as Skill;
use angels\director\Common as Director;
use angels\helper\Translate;
use angels\lobby\Common as Lobby;

/**
 * Class Common
 * @property string $name
 */
class Common extends Object
{
    const UNIT_CLASS_DEFAULT = 'angels\unit\Novice';

    protected $locked = true;
    /** @var Point */
    protected $point;
    /** @var Director */
    protected $director;
    /** @var Lobby */
    protected $lobby;

    public $isAlive = true;
    public $points = 0;

    /**
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->buffs = new \SplObjectStorage();

        $this->on('endTurn', function () {
            $this->decreaseBuffsDuration();
            $this->restorePoints();
        });
        $this->on('beginTurn', function () {
            $this->decreaseBuffsDuration();
            $this->restorePoints();

            $this->getDirector()->emit('beginTurn');
        });
        $this->on('applyBuff', function (Common $target, Skill $skill) {
            if ($this->isAlive && $this->rangeTo($target))
                $this->applyBuff($skill);
        });
    }

    // ====== lobby ==============

    /**
     * @return Lobby
     */
    public function getLobby()
    {
        return $this->lobby;
    }

    /**
     * @param Lobby $lobby
     */
    public function setLobby(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    // ====== director ===========

    /**
     * @return Director
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param Director $director
     */
    public function setDirector(Director $director)
    {
        $this->director = $director;
    }

    // ======= game logic ==============

    // ======== points ================

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param Point $point
     * @return void
     */
    public function setPoint(Point $point)
    {
        $this->point = $point;
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function moveTo(Point $point)
    {
        if (($this->getPoint()->getX() === $point->getX()) && ($this->getPoint()->getY() === $point->getY()))
            return false;

        if ((abs($this->getPoint()->getX() - $point->getX()) <= 1) && (abs($this->getPoint()->getY() - $point->getY()) <= 1)) {
            // todo: decrease energy
            $this->setPoint($point);
            return true;
        }

        return false;
    }

    /**
     * @param Common $target
     * @return float
     */
    public function rangeTo(Common $target)
    {
        return sqrt(pow($target->getPoint()->getX() - $this->getPoint()->getX(), 2) + pow($target->getPoint()->getY() - $this->getPoint()->getY(), 2));
    }

    // ====== buff ===============

    /** @var \SplObjectStorage */
    protected $buffs;

    /**
     * @return array
     * @throws exception\BadCodeException
     */
    public static function availableSkills()
    {
        throw new exception\BadCodeException(Translate::t('Available skills not implemented'));
    }

    /**
     * @return \SplObjectStorage
     */
    public function getBuffs()
    {
        return $this->buffs;
    }

    /**
     * @param Skill $skill
     * @return bool
     */
    public function applyBuff(Skill $skill)
    {
        if (!$skill->getFlags() & Skill::IS_BUFF)
            return false;

        foreach ($this->buffs as $duration => $buff) {
            if ($buff instanceof $skill) {
                // новый баф сильнее или такой же
                $this->buffs->detach($buff);
                $this->buffs->attach($skill, $skill->getBuffDuration());
                return true;
            }
        }

        return false;
    }

    /**
     * @return void
     */
    public function decreaseBuffsDuration()
    {
        foreach ($this->buffs as $duration => $buff) {
            if ($duration === 1) {
                $this->buffs->detach($buff);
                continue;
            }
            $this->buffs->offsetSet($buff, $duration - 1);
        }
    }

    /**
     * @return void
     */
    public function restorePoints()
    {
        $this->points = $this->getDefaultPoints(); // todo: +bonus
    }

    /**
     * @return int
     * @throws exception\BadCodeException
     */
    public function getDefaultPoints()
    {
        throw new exception\BadCodeException(Translate::t('Default points not implemented'));
    }

    // ====== team =============

    /** @var Team */
    protected $team;

    /**
     * @param Team $team
     * @return void
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @return void
     */
    public function removeTeam()
    {
        $this->team = null;
    }

    // ========= lock ================

    /**
     * @return bool
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @return void
     */
    public function lockActions()
    {
        $this->locked = true;
    }

    /**
     * @return void
     */
    public function unlockActions()
    {
        $this->locked = false;
    }
}