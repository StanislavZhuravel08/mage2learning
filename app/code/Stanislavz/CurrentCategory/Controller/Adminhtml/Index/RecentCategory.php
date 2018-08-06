<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 06.08.18
 * Time: 10:57
 */

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

class RecentCategory extends \Magento\Customer\Controller\Adminhtml\Index
{
    public function execute()
    {
        $this->initCurrentCustomer();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
