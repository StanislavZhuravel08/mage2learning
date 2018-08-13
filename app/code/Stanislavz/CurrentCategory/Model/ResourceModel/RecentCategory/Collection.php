<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
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
