<?php

namespace Stanislavz\CurrentCategory\Block;

use Magento\Catalog\Model\Category;

class CurrentCategoryModule extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $layerResolver;

    private $categoryRepository;

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * CurrentCategoryModule constructor.
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->categoryRepository = $categoryRepository;
        $this->layerResolver = $layerResolver;
    }

    /**
     * @return Category
     */
    public function getCurrentCategory(): Category
    {
        return $this->layerResolver->get()->getCurrentCategory();
    }

//    /**
//     * @return \Magento\Catalog\Api\Data\CategoryInterface
//     * @throws \Magento\Framework\Exception\NoSuchEntityException
//     */
//    public function getCategoryRepository()
//    {
//        return $this->categoryRepository->get(21);
//    }

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
        return $this->isCustomerLoggedIn() ? (int) $this->customerSession->getCustomer()->getId() : 0;
    }
}
