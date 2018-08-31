<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class VisitedCategories extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->getRequest()->getFullActionName();
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        return $resultLayout;
    }
}
