<?php
namespace angels\application\game\manager;

use util\daemon\ManagerInterface\ManagerInterface;

/**
 * Class Common
 */
abstract class Common implements ManagerInterface
{
    /**
     * @var DaemonInterface
     */
    protected $owner;

    public function __construct(DaemonInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return DaemonInterface
     */
    public function getOwner()
    {
        return $this->owner;
    }
}