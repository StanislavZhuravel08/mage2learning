<?php

namespace Stanislavz\CurrentCategory\Model;

class RecentCategory extends \Magento\Framework\Model\AbstractModel
{

    const MAIN_TABLE = 'recently_visited_categories';

    protected function _construct()
    {
        $this->_init(\Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory::class);
    }
}
