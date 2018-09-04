<?php

namespace Stanislavz\CurrentCategory\CustomerData;

use Stanislavz\CurrentCategory\Helper\Helper;
use Stanislavz\CurrentCategory\Helper\HelperData;
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
    private $helperData;

    /**
     * VisitedCategoriesSection constructor.
     * @param Helper $helper
     * @param HelperData $helperData
     */
    public function __construct(
        \Stanislavz\CurrentCategory\Helper\Helper $helper,
        \Stanislavz\CurrentCategory\Helper\HelperData $helperData
    ) {
        $this->helper = $helper;
        $this->helperData = $helperData;
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
        $categoriesCollection = $this->helperData->getRecentlyVisitedCategories(
            $this->helperData->getCurrentCategoriesCollection()
        );

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
