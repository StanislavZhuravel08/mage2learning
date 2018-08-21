<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

class VisitedCategories extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->getRequest()->getFullActionName();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
