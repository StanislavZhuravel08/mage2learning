<?php

namespace Stanislavz\CurrentCategory\Observer;

use Magento\Framework\Event\Observer;
use Stanislavz\CurrentCategory\Model\RecentCategory;

class CheckCategory implements \Magento\Framework\Event\ObserverInterface
{
    private $currentCategory;

    private $recentCategory;

    public function __construct(
        \Stanislavz\CurrentCategory\Block\CurrentCategoryModule $currentCategory,
        \Stanislavz\CurrentCategory\Model\RecentCategoryFactory $recentCategory
    ) {
        $this->currentCategory = $currentCategory;
        $this->recentCategory = $recentCategory;
    }

    /**
     * @return array
     */
    private function getPageData(): array
    {
        $data = [
            'customer_id' => $this->currentCategory->getCustomerId(),
            'category_id' => $this->currentCategory->getCurrentCategory()->getId(),
        ];

        return $data;
    }

    /**
     * @param Observer $observer
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        $conditionCategoryId = $this->currentCategory->getCurrentCategory()->getId();
        $conditionCategoryId = ($conditionCategoryId > 2) ? $conditionCategoryId : 0;
        $conditionCustomerIsLoggedIn = $this->currentCategory->isCustomerLoggedIn();

        if ($conditionCategoryId && $conditionCustomerIsLoggedIn) {
            $data = $this->getPageData();
            /** @var RecentCategory $recentCategory */
            $recentCategory = $this->recentCategory->create();
            $collection = $recentCategory->getCollection();
            $collection->addFieldToFilter('category_id', $conditionCategoryId)
                ->addFieldToFilter('customer_id', $conditionCustomerIsLoggedIn);

            $recentCategory = $collection->getFirstItem();
            $recentCategory->addData($data)
                ->save();
        }
    }
}
