<?php

namespace Stanislavz\CurrentCategory\Observer;

use \Magento\Framework\Event\Observer;

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
            'customer_id'        => $this->currentCategory->getCustomerId(),
            'category_id'        => $this->currentCategory->getCurrentCategory()->getId(),
            'category_url'       => $this->currentCategory->getCurrentCategory()->getUrl(),
            'category_full_path' => $this->currentCategory->getCurrentCategory()->getPath()
        ];

        return $data;
    }

    public function execute(Observer $observer)
    {
        $conditionCategory = $this->currentCategory->getCurrentCategory()->getId();
        $conditionCategory = ($conditionCategory > 2) ? $conditionCategory : 0;
        $conditionCustomer = $this->currentCategory->isCustomerLoggedIn();

        if ($conditionCategory && $conditionCustomer) {
            $data = $this->getPageData();
            $recentCategory = $this->recentCategory->create();
            $connection = $recentCategory->getResource()->getConnection();
            $tableName = $recentCategory->getResource()->getTable('recently_visited_categories');
            $connection->insert($tableName, $data);
        }
    }
}
