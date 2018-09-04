<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel\RecentCategory;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'recently_visited_categories';

    /**
     * @var string
     */
    protected $_idFieldName = 'visit_id';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'visit_collection';

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

    /**
     * Returns pairs identifier - title for unique identifiers
     * and pairs identifier|visit_id - title for non-unique after first
     *
     * @return array
     */
    public function toOptionIdArray()
    {
        $res = [];
        $existingIdentifiers = [];
        foreach ($this as $item) {
            $identifier = $item->getData('identifier');

            $data['value'] = $identifier;
            $data['label'] = $item->getData('title');

            if (in_array($identifier, $existingIdentifiers)) {
                $data['value'] .= '|' . $item->getData('visit_id');
            } else {
                $existingIdentifiers[] = $identifier;
            }

            $res[] = $data;
        }

        return $res;
    }
}
