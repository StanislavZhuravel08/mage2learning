<?php

namespace Stanislavz\CurrentCategory\Block\Visited\Categories;

use Magento\Framework\View\Element\Template;
use Stanislavz\CurrentCategory\Helper\Helper;

class Sidebar extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Helper
     */
    public $helper;

    /**
     * Sidebar constructor.
     * @param Template\Context $context
     * @param Helper $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Stanislavz\CurrentCategory\Helper\Helper $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }
}
