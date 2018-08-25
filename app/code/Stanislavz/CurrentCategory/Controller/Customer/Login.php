<?php

namespace Stanislavz\CurrentCategory\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;

class Login extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Login constructor.
     * @param Session $session
     * @param Context $context
     */
    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->session = $session;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->session->isLoggedIn()) {
            return 'ok';
        }
        return 'not ok';
    }
}
