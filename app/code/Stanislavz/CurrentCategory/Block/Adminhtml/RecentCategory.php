<?php

namespace Stanislavz\CurrentCategory\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class RecentCategory extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_index_index';
        $this->_blockGroup = 'Stanislavz_CurrentCategory';
        parent::_construct();
    }
}
