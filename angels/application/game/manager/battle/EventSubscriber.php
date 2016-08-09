<?php
namespace angels\application\game\manager\battle;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EventSubscriber
 */
class EventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            event\BattleBegin::NAME => 'onBattleBegin',
            event\BattleEnd::NAME => 'onBattleEnd',
            event\TurnBegin::NAME => 'onTurnBegin',
            event\TurnEnd::NAME => 'onTurnEnd',
            
            \angels\daemon\application\event\Interval1Sec::class => 'onInterval1Sec',
        ];
    }

    /**
     * @param event\BattleBegin $event
     */
    public function onBattleBegin(event\BattleBegin $event)
    {
        //todo: inform all
    }

    /**
     * @param event\BattleEnd $event
     */
    public function onBattleEnd(event\BattleEnd $event)
    {
        //todo: inform all
    }

    /**
     * @param event\TurnBegin $event
     */
    public function onTurnBegin(event\TurnBegin $event)
    {
        //todo: inform all
    }

    /**
     * @param event\TurnEnd $event
     */
    public function onTurnEnd(event\TurnEnd $event)
    {
        //todo: inform all
    }

    /**
     * @param \angels\daemon\application\event\Interval1Sec $event
     */
    public function onInterval1Sec(\angels\daemon\application\event\Interval1Sec $event)
    {

    }
}