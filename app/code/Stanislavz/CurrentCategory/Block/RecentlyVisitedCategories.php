<?php

namespace Stanislavz\CurrentCategory\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Stanislavz\CurrentCategory\Model\ResourceModel\Category\Collection as NonCacheableCategoryCollection;

class RecentlyVisitedCategories extends \Magento\Framework\View\Element\Template
{
    const XML_PATH_CATEGORY_QUANTITY = 'customer/recent_category/recent_category_quantity';

    /**
     * @var CurrentCategoryModule
     */
    public $helper;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var \Stanislavz\CurrentCategory\Model\ResourceModel\Category\CollectionFactory
     */
    private $nonCacheableCategoryCollectionFactory;

    /**
     * RecentlyVisitedCategories constructor.
     * @param \Stanislavz\CurrentCategory\Helper\Helper $helper
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Stanislavz\CurrentCategory\Model\ResourceModel\Category\CollectionFactory
     *                                                                 $nonCacheableCategoryCollectionFactory
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Stanislavz\CurrentCategory\Helper\Helper $helper,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Stanislavz\CurrentCategory\Model\ResourceModel\Category\CollectionFactory $nonCacheableCategoryCollectionFactory,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->nonCacheableCategoryCollectionFactory = $nonCacheableCategoryCollectionFactory;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        $limit = $this->_scopeConfig->getValue(self::XML_PATH_CATEGORY_QUANTITY, ScopeInterface::SCOPE_STORES);
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
        $categoriesCollection->addCustomerFilter($this->helper->getCustomerId())
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
            $parentCategories = [];

            foreach ($category->getParentIds() as $parentCategoryId) {
                if ($parentCategory = $parentCategoriesCollection->getItemById($parentCategoryId)) {
                    $parentCategories[] = $parentCategory;
                }
            }
            $category->setParentCategoriesList($parentCategories);
        }
        return $categoriesCollection;
    }
}
