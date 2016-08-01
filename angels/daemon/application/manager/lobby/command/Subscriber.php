<?php
namespace angels\daemon\application\manager\lobby\command;

use angels\daemon\application\manager\lobby\event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Subscriber
 */
class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ChangeLobby::class => 'onChangeLobby',
            Craft::class => 'onCraft',
            Login::class => 'onLogin',
        ];
    }

    /**
     * @param ChangeLobby $command
     */
    public function onChangeLobby(ChangeLobby $command, $eventName, EventDispatcherInterface $dispatcher)
    {
        if ($command->getLobby()->checkAccess($command->getUnit())) {

            $oldLobby = $command->getUnit()->getLobby();
            if ($oldLobby->getUnits()->contains($command->getUnit())) {
                $oldLobby->getUnits()->detach($command->getUnit());
                $dispatcher->dispatch(event\PlayerRemove::class, new event\PlayerRemove($oldLobby, $command->getUnit()));

                $command->getLobby()->getUnits()->attach($command->getUnit());
                $dispatcher->dispatch(event\PlayerAdd::class, new event\PlayerAdd($command->getLobby(), $command->getUnit()));

                $command->getUnit()->setLobby($command->getLobby());
            }
        }
    }
}