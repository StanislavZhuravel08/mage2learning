<?php

namespace Stanislavz\CurrentCategory\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

class CustomSection implements SectionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        return [
            'msg' =>'Data from section',
        ];
    }
}
