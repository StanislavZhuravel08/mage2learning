<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 01.08.18
 * Time: 15:41
 */

namespace Stanislavz\CurrentCategory\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

class RecentCategory extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'recently_visited_categories';

    /**
     * @var string
     */
    private $cacheTag = 'recently_visited_categories';

    /**
     * @var string
     */
    private $eventPrefix = 'recently_visited_categories';

    protected function _construct()
    {
        $this->_init('\Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory::class');
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}