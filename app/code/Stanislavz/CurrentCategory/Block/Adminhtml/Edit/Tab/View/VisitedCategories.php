<?php


namespace Stanislavz\CurrentCategory\Block\Adminhtml\Edit\Tab\View;

use Magento\Customer\Controller\RegistryConstants;
use Stanislavz\CurrentCategory\Model\ResourceModel\VisitedCategories\Grid\CollectionFactory;

class VisitedCategories extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Initial settings.
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('visited_categories_grid');
        $this->setSortable(false);
        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);
        $this->setEmptyText(__('There are no visits in customer\'s session.'));
    }

    /**
     * Prepare collection.
     *
     * @return $this
     */
    protected function _prepareCollection(): self
    {
        $collection = $this->collectionFactory->create()->addCustomerIdFilter(
            $this->coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID)
        )->addDaysInWishlist()->addStoreData()->setInStockFilter(
            true
        );

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     * @throws \Exception
     */
    protected function _prepareColumns(): \Magento\Backend\Block\Widget\Grid\Extended
    {
        $this->addColumn(
            'visit_id',
            ['header' => __('Visit ID'), 'index' => 'visit_id', 'type' => 'number', 'width' => '100px']
        );
        $this->addColumn(
            'category_id',
            [
                'header' => __('Category ID'),
                'index' => 'category_id',
            ]
        );
        $this->addColumn(
            'created_at',
            ['header' => __('Add Date'), 'index' => 'created_at', 'type' => 'date', 'width' => '140px']
        );
        $this->addColumn(
            'updated_at',
            ['header' => __('Modified Date'), 'index' => 'updated_at', 'type' => 'date', 'width' => '140px']
        );
        $this->addColumn(
            'customer_id',
            ['header' => __('Customer ID'), 'index' => 'customer_id', 'type' => 'number']
        );

        return parent::_prepareColumns();
    }

    /**
     * @return bool
     */
    public function getHeadersVisibility():bool
    {
        return $this->getCollection()->getSize() >= 0;
    }

    /**
     * @return string
     */
    public function getGridUrl(): string
    {
        return $this->getUrl('customer/*/view_visited_categories', ['_current' => true]);
    }
}
