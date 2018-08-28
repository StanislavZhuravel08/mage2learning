<?php

namespace Stanislavz\CurrentCategory\Observer;

use Magento\Framework\Event\Observer;
use Stanislavz\CurrentCategory\Model\RecentCategory;

class CustomerLogIn implements \Magento\Framework\Event\ObserverInterface
{
    private $recentlyVisitedCategories;

    private $recentCategory;

    public function __construct(
        \Stanislavz\CurrentCategory\Block\RecentlyVisitedCategories $recentlyVisitedCategories,
        \Stanislavz\CurrentCategory\Model\RecentCategoryFactory $recentCategory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->recentlyVisitedCategories = $recentlyVisitedCategories;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->recentCategory = $recentCategory;
    }

    public function execute(Observer $observer)
    {
//        $customerPreviouslyVisitedCategories = $this->recentlyVisitedCategories->getRecentlyVisitedCategories();
//        $resultJson = $this->resultJsonFactory->create();
        return 'ok';
//            $resultJson->setData($customerPreviouslyVisitedCategories);
    }
}
