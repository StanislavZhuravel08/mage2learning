<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

class Recent extends \Magento\Customer\Controller\Adminhtml\Index
{

    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
