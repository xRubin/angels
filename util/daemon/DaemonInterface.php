<?php
namespace util\daemon;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Interface DaemonInterface
 */
interface DaemonInterface
{
    /**
     * @param ManagerInterface $manager
     */
    public function addManager(ManagerInterface $manager);

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher();

}