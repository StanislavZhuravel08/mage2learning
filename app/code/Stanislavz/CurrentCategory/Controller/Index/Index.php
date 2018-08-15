<?php

namespace Stanislavz\CurrentCategory\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Stanislavz\CurrentCategory\Block\CurrentCategoryModule;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Registry;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var CurrentCategoryModule
     */
    private $currentCategoryModule;

    private $coreRegistry;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Stanislavz\CurrentCategory\Block\CurrentCategoryModule $currentCategoryModule
    ) {
        parent::__construct($context);
        $this->currentCategoryModule = $currentCategoryModule;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $this->_request;
        $currentCategoryId = $this->currentCategoryModule->getCurrentCategory()->getId();
        $catId = $this->coreRegistry->registry('current_category');
        $responseData['category_id'] = $currentCategoryId;
        $responseData['cat_id'] = $catId;

        /** @var Json $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $response->setData($responseData);
    }
}
