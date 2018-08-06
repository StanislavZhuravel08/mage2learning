<?php

namespace Stanislavz\CurrentCategory\Block\Adminhtml\Edit\Tab;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\View\Element\Template;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

class RecentCategoriesLinks
    extends \Magento\Framework\View\Element\Template
    implements \Magento\Ui\Component\Layout\Tabs\TabInterface
{
    private $coreRegistry;

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
        return __('Recent Categories');
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
        return '';
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl(): string
    {
        return $this->getUrl('recent_categories', ['_current' => true]);
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
