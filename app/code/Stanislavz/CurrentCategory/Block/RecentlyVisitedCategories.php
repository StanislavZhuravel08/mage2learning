<?php

namespace Stanislavz\CurrentCategory\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;

class RecentlyVisitedCategories extends \Magento\Framework\View\Element\Template
{
    const XML_PATH_CATEGORY_QUANTITY = 'customer/recent_category/recent_category_quantity';

    /**
     * @var CurrentCategoryModule
     */
    private $pagePreloader;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $collectionFactory;

    /**
     * RecentlyVisitedCategories constructor.
     * @param CurrentCategoryModule $pagePreloader
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        CurrentCategoryModule $pagePreloader,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->pagePreloader = $pagePreloader;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return int
     */
    private function getCustomerId(): int
    {
        return $this->pagePreloader->getCustomerId();
    }

    /**
     * @return int
     */
    private function getLimit(): int
    {
        $limit = $this->_scopeConfig->getValue(self::XML_PATH_CATEGORY_QUANTITY, ScopeInterface::SCOPE_STORES);
        return (int) $limit;
    }

    /**
     * @return CategoryCollection
     */
    public function getRecentlyVisitedCategories(): CategoryCollection
    {
        /** @var CategoryCollection $categoriesCollection */
        $categoriesCollection = $this->collectionFactory->create();
        $categoriesCollection->getSelect()
            ->join(
                ['rvc' => $categoriesCollection->getTable('recently_visited_categories')],
                'e.entity_id=rvc.category_id',
                []
            )
            ->where(
                'rvc.customer_id=?', $this->getCustomerId()
            );
        $categoriesCollection->setPageSize($this->getLimit())
            ->addNameToResult()
            ->addOrder('rvc.created_at');

        $parentCategories = [];

        /** @var Category $category */
        foreach ($categoriesCollection as $category) {
            $parentCategories = array_merge($parentCategories, $category->getParentIds());
        }

        /** @var CategoryCollection $parentCategoriesCollection */
        $parentCategoriesCollection = $this->collectionFactory->create();
        $parentCategoriesCollection->addFieldToFilter('entity_id', ['in' => array_unique($parentCategories)])
            ->addNameToResult()
            ->addFieldToFilter('level', ['qt' => 2]);

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
