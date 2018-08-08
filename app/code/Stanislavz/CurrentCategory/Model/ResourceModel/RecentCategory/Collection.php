<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected $_eventPrefix = 'recently_visited_categories';

    /**
     * @inheritdoc
     */
    protected $_eventObject = 'collection';

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
