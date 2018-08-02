<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel\Collection;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    private $idFieldName = 'visit_id';
    private $eventPrefix = 'recently_visited_categories';
    private $eventObject = 'recentCategory_collection';

    protected function _construct()
    {
        $this->_init(
            \Stanislavz\CurrentCategory\Model\RecentCategory::class,
            \Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory::class
        );
    }
}
