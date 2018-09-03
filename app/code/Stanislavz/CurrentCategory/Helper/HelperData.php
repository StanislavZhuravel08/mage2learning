<?php

namespace Stanislavz\CurrentCategory\Helper;

use Magento\Framework\Url\Helper\Data as UrlHelper;
use Stanislavz\CurrentCategory\Helper\Helper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Stanislavz\CurrentCategory\Model\ResourceModel\Category\Collection as NonCacheableCategoryCollection;

class HelperData extends \Stanislavz\CurrentCategory\Helper\Helper
{
    const XML_PATH_CATEGORY_QUANTITY = 'customer/recent_category/recent_category_quantity';

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var \Stanislavz\CurrentCategory\Model\ResourceModel\Category\CollectionFactory
     */
    private $nonCacheableCategoryCollectionFactory;

    /**
     * HelperData constructor.
     * @param Context $context
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param UrlHelper $urlHelper
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Stanislavz\CurrentCategory\Model\ResourceModel\Category\CollectionFactory $nonCacheableCategoryCollectionFactory,
        UrlHelper $urlHelper
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->nonCacheableCategoryCollectionFactory = $nonCacheableCategoryCollectionFactory;
        $this->_storeManager = $storeManager;
        parent::__construct(
            $context,
            $layerResolver,
            $customerSession,
            $urlHelper
        );
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        $limit = $this->scopeConfig->getValue(self::XML_PATH_CATEGORY_QUANTITY, ScopeInterface::SCOPE_STORES);
        return (int) $limit;
    }

    /**
     * @return CategoryCollection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRecentlyVisitedCategories(): CategoryCollection
    {
        /** @var NonCacheableCategoryCollection $categoriesCollection */
        $categoriesCollection = $this->nonCacheableCategoryCollectionFactory->create();
        $categoriesCollection->addCustomerFilter($this->getCustomerId())
            ->addNameToResult()
            ->getSelect()
            ->limit($this->getLimit());

        $parentCategories = [];

        /** @var Category $category */
        foreach ($categoriesCollection as $category) {
            $parentCategories = array_merge($parentCategories, $category->getParentIds());
        }

        $parentCategories = array_unique($parentCategories);
        // optimize cache usage
        asort($parentCategories);

        /** @var CategoryCollection $parentCategoriesCollection */
        $parentCategoriesCollection = $this->categoryCollectionFactory->create();
        $parentCategoriesCollection
            ->addFieldToFilter('entity_id', ['in' => $parentCategories])
            ->setStore($this->_storeManager->getStore())
            ->addNameToResult()
            ->addFieldToFilter('level', ['gt' => 1]);

        foreach ($categoriesCollection as $category) {

            // empty array which will be added to each category
            $parentCategories = [];

            foreach ($category->getParentIds() as $parentCategoryId) {
                if ($parentCategory = $parentCategoriesCollection->getItemById($parentCategoryId)) {
                    // if parentCategoryCollection has item with the same id as the current
                    // CategoryParent it will be added to $parentCategories
                    $parentCategories[] = $parentCategory;
                }
            }
            // magic method saves $parentCategory array with Category object
            // to each Category in $noncacheableCollection
            $category->setParentCategoriesList($parentCategories);
        }
        return $categoriesCollection;
    }
}
