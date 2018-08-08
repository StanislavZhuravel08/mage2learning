<?php

namespace Stanislavz\CurrentCategory\Controller\Adminhtml\Index;

use Index;

class Grid extends Stanislavz\CurrentCategory\Controller\Adminhtml\Index\Index
{
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
