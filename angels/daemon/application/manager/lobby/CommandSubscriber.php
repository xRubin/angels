<?php
namespace angels\daemon\application\manager\lobby;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CommandSubscriber
 */
class CommandSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            command\ChangeLobby::class => 'onChangeLobby',
            command\Craft::class => 'onCraft',
            command\Login::class => 'onLogin',
        ];
    }

    /**
     * @param command\ChangeLobby $command
     */
    public function onChangeLobby(command\ChangeLobby $command, $eventName, EventDispatcherInterface $dispatcher)
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