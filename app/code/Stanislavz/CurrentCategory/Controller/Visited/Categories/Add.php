<?php

namespace Stanislavz\CurrentCategory\Controller\Visited\Categories;

class Add extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * Add visited category id to visited categories list
     *
     */
    public function execute()
    {
        $requestData = $this->getRequest()->getParams();
        return $requestData;
    }
}