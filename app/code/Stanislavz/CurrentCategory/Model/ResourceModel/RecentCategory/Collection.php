<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 01.08.18
 * Time: 16:26
 */

namespace Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    private $idFieldName = 'visit_id';
    private $eventPrefix = 'recently_visited_categories';
    private $eventObject = 'recentCategory_collection';

    protected function _construct()
    {
        $this->_init(
            '\Stanislavz\CurrentCategory\Model\ResentCategory',
            '\Stanislavz\CurrentCategory\Model\ResourceModel\ResentCategory'
        );
    }
}
