<?php
namespace angels;

use angels\exception;
use angels\helper\Object;
use angels\map\Common as Map;
use angels\lobby\Common as Lobby;

/**
 * Class Battle
 */
class Battle
{
    /** @var \SplObjectStorage */
    protected $teams;

    /** @var Team */
    protected $currentTeam;

    /** @var integer */
    protected $turnBeginsTimestamp;

    /** @var Map */
    protected $map;

    /**
     * @param Lobby $lobby
     * @param \SplObjectStorage $units
     * @param Map $map
     * @param array $config
     * @throws exception\NoTeamsException
     */
    public function __construct(Lobby $lobby, $units, Map $map, $config = [])
    {
        $this->teams = $map->formTeams($lobby, $units);

        if (!$this->teams->count())
            throw new exception\NoTeamsException();

        $this->map = $map;

        parent::__construct($config);
    }

    /**
     * @return Map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @return void
     */
    public function nextTurn()
    {
        foreach ($this->teams as $team) {
            if ($team === $this->currentTeam) {
                $this->teams->next();
                if ($this->teams->valid()) {
                    $this->currentTeam = $this->teams->current();
                    $this->emit('beginTeamTurn', [$this->currentTeam]);
                    return;
                }
            }
        }
        $this->teams->rewind();
        $this->currentTeam = $this->teams->current();
        $this->emit('beginTeamTurn', [$this->currentTeam]);
    }

    /**
     * @return void
     */
    public function endBattle()
    {
        // todo: раздать плюшки

        foreach ($this->getTeams() as $team) {
            /** @var Team $team */
            $team->drop();
        }
    }

    /**
     * @return bool
     */
    public function isTeamPointsSpended()
    {
        return $this->currentTeam->isTeamPointsSpended();
    }

    /**
     * @return bool
     */
    public function checkComplete()
    {
        return $this->getMap()->checkComplete();
    }

}