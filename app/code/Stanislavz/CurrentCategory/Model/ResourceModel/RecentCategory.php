<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RecentCategory extends AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }
    protected function _construct()
    {
        $this->_init('recently_visited_categories', 'visit_id');
    }
}
