<?php
namespace util\daemon;

/**
 * Class Manager
 */
abstract class Manager implements ManagerInterface
{
    /**
     * @var DaemonInterface
     */
    protected $owner;

    /**
     * @param DaemonInterface $owner
     */
    public function setOwner(DaemonInterface $owner)
    {
        $this->owner = $owner;
        $this->init();
    }

    /**
     * 
     */
    public function init()
    {

    }

    /**
     * @return DaemonInterface
     */
    public function getOwner()
    {
        return $this->owner;
    }
}