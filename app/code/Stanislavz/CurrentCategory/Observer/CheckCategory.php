<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 01.08.18
 * Time: 18:13
 */

namespace Stanislavz\CurrentCategory\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CheckCategory implements ObserverInterface
{
    private $currentCategory;

    private $logginedUserCheck;

    private $recentCategory;

    public function __construct(
        \Stanislavz\CurrentCategory\Block\CurrentCategory $currentCategory,
        \Stanislavz\CurrentCategory\LogginedUserCheck $logginedUserCheck,
        \Stanislavz\CurrentCategory\Model\RecentCategoryFactory $recentCategory
    ) {
        $this->currentCategory = $currentCategory;
        $this->logginedUserCheck = $logginedUserCheck;
        $this->recentCategory = $recentCategory;
    }

    public function execute(Observer $observer)
    {
        // TODO: Implement execute() method.
    }
}