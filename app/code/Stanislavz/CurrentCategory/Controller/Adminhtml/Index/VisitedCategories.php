<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class VisitedCategories extends \Magento\Backend\App\Action
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
    }
}
