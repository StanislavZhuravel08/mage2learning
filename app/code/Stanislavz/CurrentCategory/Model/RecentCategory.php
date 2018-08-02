<?php

namespace Stanislavz\CurrentCategory\Model;

class RecentCategory extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{

    const MAIN_TABLE = 'recently_visited_categories';
    const CACHE_TAG = 'recently_visited_categories';

    protected function _construct()
    {
        $this->_init(\Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
