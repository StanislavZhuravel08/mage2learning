<?php

namespace Stanislavz\CurrentCategory;

use \Magento\Customer\Model\Session;

class LogginedUserCheck
{
    /**
     * @var Session
     */
    private $session;

    private $loggedFlag;

    /**
     * LogginedUserCheck constructor.
     * @param Session $session
     */
    public function __construct(
        Session $session
    ) {
        $this->session = $session;
    }

    /**
     * @return bool
     */
    public function checkUser(): bool
    {
        if ($this->session->isLoggedIn()) {
            return $this->loggedFlag = true;
        }
        return $this->loggedFlag = false;
    }

    /**
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->session->getCustomerData()->getId();
    }
}
