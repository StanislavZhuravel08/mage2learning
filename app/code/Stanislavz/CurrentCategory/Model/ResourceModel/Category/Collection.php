<?php

namespace Stanislavz\CurrentCategory\Model\ResourceModel\Category;

class Collection extends \Magento\Catalog\Model\ResourceModel\Category\Collection
{
    /**
     * @param int $customerId
     * @return $this
     */
    public function addCustomerFilter($customerId): self
    {
        $this->getSelect()
            ->where('rvc.customer_id=?', $customerId);
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()
            ->join(
                ['rvc' => $this->getTable('recently_visited_categories')],
                'e.entity_id = rvc.category_id',
                []
            )
            ->order('rvc.updated_at');

        return $this;
    }
}
