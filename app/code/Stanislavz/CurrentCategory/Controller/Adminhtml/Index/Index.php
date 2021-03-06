<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

/**
 * This Action loads 'Visited Categories' tab in 'Customer' menu tab
 */

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Stanislavz_CurrentCategory::current_category';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Stanislavz_CurrentCategory::current_category');
        $resultPage->addBreadcrumb(__('Visited Categories'), __('Visited Categories'));
        $resultPage->addBreadcrumb(__('Manage Visited Categories'), __('Manage Visited Categories'));
        $resultPage->getConfig()->getTitle()->prepend(__('Visited Categories'));

        $dataPersistor = $this->_objectManager->get(\Magento\Framework\App\Request\DataPersistorInterface::class);
        $dataPersistor->clear('current_category');
        $this->getRequest()->getFullActionName();
        return $resultPage;
    }
}
