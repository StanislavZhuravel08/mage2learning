<?php

namespace Stanislavz\CurrentCategory\CustomerData;

use Stanislavz\CurrentCategory\Helper\Helper;
use Magento\Customer\CustomerData\SectionSourceInterface;

class VisitedCategoriesSection implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Stanislavz\CurrentCategory\Helper\Helper
     */
    private $helper;

    /**
     * @var \Stanislavz\CurrentCategory\Block\RecentlyVisitedCategories
     */
    private $recentlyVisitedCategories;

    /**
     * VisitedCategoriesSection constructor.
     * @param Helper $helper
     * @param \Stanislavz\CurrentCategory\Block\RecentlyVisitedCategories $recentlyVisitedCategories
     */
    public function __construct(
        \Stanislavz\CurrentCategory\Helper\Helper $helper,
        \Stanislavz\CurrentCategory\Block\RecentlyVisitedCategories $recentlyVisitedCategories
    ) {
        $this->helper = $helper;
        $this->recentlyVisitedCategories = $recentlyVisitedCategories;
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $result = [];

        /**
         * Get data from database for authorized customer
         */
        if ($this->helper->isCustomerLoggedIn()) {
            $result = [
                'items' => $this->getCustomerVisitedCategoriesIds()
            ];
        }

        return $result;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCustomerVisitedCategoriesIds()
    {
        $items = [];
        $item  = [];
        $categoriesCollection = $this->recentlyVisitedCategories->getRecentlyVisitedCategories();

        foreach ($categoriesCollection as $index => $category) {
            $item['category_id']       = $index;
            $item['category_name']     = $category->getName();
            $item['category_url']      = $category->getUrl();
            $item['parent_categories'] = [];

            foreach ($category->getParentCategoriesList() as $counter => $parentCategory) {
                $item['parent_categories'][$counter]['parent_categories_url'] = $parentCategory->getUrl();
                $item['parent_categories'][$counter]['parent_categories_name'] = $parentCategory->getName();
            }
            $items[] = $item;
        }
        return $items;
    }
}
