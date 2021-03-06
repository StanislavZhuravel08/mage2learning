<?php

namespace Stanislavz\CurrentCategory\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Stanislavz\CurrentCategory\Block\CurrentCategoryModule;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Registry;
use Magento\Catalog\Model\CategoryFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    private $categoryFactory;

    /**
     * @var CurrentCategoryModule
     */
    private $currentCategoryModule;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * Index constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param CategoryFactory $categoryFactory
     * @param CurrentCategoryModule $currentCategoryModule
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Stanislavz\CurrentCategory\Block\CurrentCategoryModule $currentCategoryModule
    ) {
        parent::__construct($context);
        $this->currentCategoryModule = $currentCategoryModule;
        $this->coreRegistry = $coreRegistry;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $requestData = $this->getRequest()->getParam('sendData');

        /** @var Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $response->setData($requestData);
    }
}
