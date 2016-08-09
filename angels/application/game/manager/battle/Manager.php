<?php
namespace angels\application\game\manager\battle;

use angels\Battle;

/**
 * Class Manager
 */
class Manager extends \util\daemon\Manager
{
    /** @var Battle[] */
    protected $battles = [];

    /**
     * Manager constructor.
     */
    public function init()
    {
        $this->getOwner()->getDispatcher()->addSubscriber(new EventSubscriber());
        $this->getOwner()->getDispatcher()->addSubscriber(new CommandSubscriber());
    }
}
