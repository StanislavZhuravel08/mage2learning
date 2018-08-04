<?php

namespace Stanislavz\CurrentCategory\Block;

use Magento\Catalog\Model\Category;

class CurrentCategoryModule extends \Magento\Framework\View\Element\Template
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
     * CurrentCategoryModule constructor.
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
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
