<?php
namespace angels\daemon\application\manager\lobby;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EventSubscriber
 */
class EventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            event\PlayerAdd::class => 'onPlayerAdd',
            event\PlayerRemove::class => 'onPlayerRemove',
            event\ChatMessage::class => 'onChatMessage',
            \angels\daemon\application\event\Interval1Sec::class => 'onInterval1Sec',
        ];
    }

    /**
     * @param event\PlayerAdd $event
     */
    public function onPlayerAdd(event\PlayerAdd $event)
    {
        if (!$event->getLobby() instanceof \angels\lobby\Planetary)
            $event->getLobby()->formBattle();

        //todo: inform other users

    }

    /**
     * @param event\PlayerRemove $event
     */
    public function onPlayerRemove(event\PlayerRemove $event)
    {

        //todo: inform other users

    }

    /**
     * @param event\ChatMessage $event
     */
    public function onChatMessage(event\ChatMessage $event)
    {

    }

    /**
     * @param \angels\daemon\application\event\Interval1Sec $event
     */
    public function onInterval1Sec(\angels\daemon\application\event\Interval1Sec $event)
    {

    }
}