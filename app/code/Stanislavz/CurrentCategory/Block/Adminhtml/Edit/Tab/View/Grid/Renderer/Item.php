<?php

namespace Stanislavz\CurrentCategory\Block\Adminhtml\Edit\Tab\View\Grid\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Framework\DataObject;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class Item extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var Column
     */
    protected $_column;

    /**
     * @return Column
     */
    public function getColumn()
    {
        return $this->_column;
    }

    /**
     * @param Column $column
     * @return $this
     */
    public function setColumn($column)
    {
        $this->_column = $column;
        return $this;
    }

    private function getItemParents()
    {
        $item = $this->getItem();
        //$parentIds = explode('/', $item->getPath());

        return $item;
    }

    /**
     * @param DataObject $item
     * @return string
     */
    public function render(\Magento\Framework\DataObject $item)
    {
        $this->setItem($item);
        $this->getItemParents();
        return 'gfsg';
    }
}
