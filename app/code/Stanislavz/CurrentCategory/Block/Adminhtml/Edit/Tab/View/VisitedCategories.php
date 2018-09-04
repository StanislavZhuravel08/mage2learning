<?php


namespace Stanislavz\CurrentCategory\Block\Adminhtml\Edit\Tab\View;

use Magento\Customer\Controller\RegistryConstants;
use Stanislavz\CurrentCategory\Model\ResourceModel\VisitedCategories\Grid\CollectionFactory;
use Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory\Collection as RecentCategoryCollection;

class VisitedCategories extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Stanislavz\CurrentCategory\Model\ResourceModel\VisitedCategories\Grid\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Stanislavz\CurrentCategory\Model\ResourceModel\VisitedCategories\Grid\CollectionFactory
     *          $collectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Stanislavz\CurrentCategory\Model\ResourceModel\VisitedCategories\Grid\CollectionFactory $collectionFactory,
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
     * @inheritdoc
     */
    protected function _prepareCollection(): self
    {
        /** @var RecentCategoryCollection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(
            'customer_id',
            $this->getRequest()->getParams('id')
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
            'value',
            [
                'header' => __('Category Name'),
                'index' => 'value',
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
            'test',
            [
                'header' => __('test'),
                'index' => 'test',
                'renderer' => \Stanislavz\CurrentCategory\Block\Adminhtml\Edit\Tab\View\Grid\Renderer\Item::class
            ]
        );

        return parent::_prepareColumns();
    }
}
