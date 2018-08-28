<?php

namespace Stanislavz\CurrentCategory\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\Category;

class Helper  extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $layerResolver;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * Helper constructor.
     * @param Context $context
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Customer\Model\Session $customerSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->layerResolver = $layerResolver;
    }

    /**
     * @return Category
     */
    public function getCurrentCategory(): Category
    {
        return $this->layerResolver->get()->getCurrentCategory();
    }

    /**
     * @return bool
     */
    public function isCustomerLoggedIn(): bool
    {
        return $this->customerSession->isLoggedIn();
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        $session = $this->customerSession;
        return $this->isCustomerLoggedIn() ? (int) $session->getCustomer()->getId() : 0;
    }
}
