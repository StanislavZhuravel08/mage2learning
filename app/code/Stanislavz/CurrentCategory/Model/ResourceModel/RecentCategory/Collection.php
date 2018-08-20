<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'visited_categories_grid_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visited_categories_grid_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            \Stanislavz\CurrentCategory\Model\RecentCategory::class,
            \Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory::class
        );
    }
}
