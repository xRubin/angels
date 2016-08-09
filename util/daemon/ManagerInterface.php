<?php
namespace util\daemon;

/**
 * Interface ManagerInterface
 */
interface ManagerInterface
{
    /**
     * @param DaemonInterface $daemon
     */
    public function setOwner(DaemonInterface $daemon);
}