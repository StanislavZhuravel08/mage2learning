<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel;

class RecentCategory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('recently_visited_categories', 'visit_id');
    }
}
