<?php

namespace Stanislavz\CurrentCategory\Model;

use Magento\Framework\Stdlib\DateTime\DateTimeFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

class RecentCategory extends \Magento\Framework\Model\AbstractModel
{
    private $dateFactory;

    const MAIN_TABLE = 'recently_visited_categories';

    /**
     * RecentCategory constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param DateTimeFactory $dateFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->dateFactory = $dateFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function beforeSave()
    {
        $this->setUpdatedAt($this->dateFactory->create()->gmtDate());
        return parent::beforeSave();
    }

    protected function _construct()
    {
        $this->_init(\Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory::class);
    }
}
