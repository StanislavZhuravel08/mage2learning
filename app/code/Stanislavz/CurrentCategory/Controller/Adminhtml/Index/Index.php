<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Stanislavz\CurrentCategory\Model\RecentCategoryFactory;

class Index extends \Magento\Backend\App\Action
{
    private $coreRegistry;

    public $resultPageFactory;

    private $recentCategoryFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Stanislavz\CurrentCategory\Model\RecentCategoryFactory $recentCategoryFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->recentCategoryFactory = $recentCategoryFactory;
    }

    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $this->_forward('grid');
            return;
        }
        return $this->recentCategoryFactory->create();
    }
}
