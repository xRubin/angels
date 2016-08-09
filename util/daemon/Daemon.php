<?php
namespace util\daemon;

use Interop\Container\ContainerInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Daemon
 */
abstract class Daemon implements DaemonInterface, MessageComponentInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;


    /**
     * @var ManagerInterface[]
     */
    protected $managers = [];

    /**
     * Daemon constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        $this->init();
    }

    /**
     * Customize
     */
    public function init()
    {

    }

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param ManagerInterface $manager
     */
    public function addManager(ManagerInterface $manager)
    {
        $this->managers[] = $manager;
        $manager->setOwner($this);
    }
}
