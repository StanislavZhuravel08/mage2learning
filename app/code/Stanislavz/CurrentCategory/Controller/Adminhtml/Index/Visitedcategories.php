<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

class Visitedcategories extends \Magento\Backend\App\Action
{
    public function execute()
    {
//        $customerId = $this->initCurrentCustomer();
//        $itemId = (int)$this->getRequest()->getParam('delete');
//        if ($customerId && $itemId) {
//            try {
//                $this->_objectManager->create(\Magento\Wishlist\Model\Item::class)->load($itemId)->delete();
//            } catch (\Exception $exception) {
//                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($exception);
//            }
//        }

        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}