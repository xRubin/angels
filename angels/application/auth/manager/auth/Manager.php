<?php
namespace angels\application\auth\manager\auth;

/**
 * Class Manager
 */
class Manager extends \util\daemon\Manager
{
    /**
     * Manager constructor.
     */
    public function init()
    {
        $this->getOwner()->getDispatcher()->addSubscriber(new CommandSubscriber());
    }
}
