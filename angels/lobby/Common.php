<?php
namespace angels\lobby;

use angels\daemon\application\manager\lobby\Manager;
use angels\daemon\application\Connection;
use angels\daemon\application\Message;

use angels\Battle;
use angels\exception;
use angels\unit\Common as Unit;

use angels\daemon\application\manager\lobby\event;
use angels\daemon\application\manager\lobby\command;

/**
 * Class Common
 */
abstract class Common
{
    /** @var Manager */
    protected $manager;

    /** @var \SplObjectStorage  */
    protected $data;

    /**
     * @param Manager $manager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;

        $this->data = new \SplObjectStorage();

        $this->on('lobby.event.addUnit', [event\AddUnit::class, 'process']);
        $this->on('lobby.event.removeUnit', [event\RemoveUnit::class, 'process']);
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param Connection $connection
     * @param Message $message
     */
    public function onMessage(Connection $connection, Message $message) {
        // ?
    }

    /**
     * @param Unit $unit
     * @return bool
     */
    abstract public function checkAccess(Unit $unit);

    /**
     * @return Battle|null
     */
    abstract public function formBattle();

    /**
     * @return \SplObjectStorage
     */
    public function getUnits() {
        return $this->data;
    }
}