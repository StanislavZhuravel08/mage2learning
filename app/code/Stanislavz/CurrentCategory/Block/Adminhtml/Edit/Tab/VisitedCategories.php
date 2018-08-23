<?php

namespace Stanislavz\CurrentCategory\Block\Adminhtml\Edit\Tab;

use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;
use Magento\Ui\Component\Layout\Tabs\TabWrapper;
use Magento\Ui\Component\Layout\Tabs\TabInterface;
use Magento\Customer\Controller\RegistryConstants;

class VisitedCategories extends TabWrapper implements TabInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * Recent constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->coreRegistry->registry(\Magento\Customer\Controller\RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabLabel()
    {
        return __('Recent Categories');
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabTitle()
    {
        return __('Visited Categories');
    }

    /**
     * @return bool
     */
    public function canShowTab(): bool
    {
        return $this->getCustomerId() ? true : false;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->getCustomerId() ? true : false;
    }

    /**
     * @return string
     */
    public function getTabClass(): string
    {
        return 'recent';
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl(): string
    {
        $this->getRequest()->getFullActionName();
        return $this->getUrl('current_category/index/visitedCategories', ['_current' => true]);
//        return '';
    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded(): bool
    {
        return true;
    }
}
