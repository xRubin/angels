<?php
namespace angels\daemon\application\manager\lobby\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class Subscriber
 */
class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            PlayerAdd::class => 'onPlayerAdd',
            PlayerRemove::class => 'onPlayerRemove',
            ChatMessage::class => 'onChatMessage',
            \angels\daemon\application\event\Interval1Sec::class => 'onInterval1Sec',
        ];
    }

    /**
     * @param PlayerAdd $event
     */
    public function onPlayerAdd(PlayerAdd $event)
    {
        if (!$event->getLobby() instanceof \angels\lobby\Planetary)
            $event->getLobby()->formBattle();

        //todo: inform other users

    }

    /**
     * @param PlayerRemove $event
     */
    public function onPlayerRemove(PlayerRemove $event)
    {

        //todo: inform other users

    }

    /**
     * @param ChatMessage $event
     */
    public function onChatMessage(ChatMessage $event)
    {

    }

    /**
     * @param \angels\daemon\application\event\Interval1Sec $event
     */
    public function onInterval1Sec(\angels\daemon\application\event\Interval1Sec $event)
    {

    }
}