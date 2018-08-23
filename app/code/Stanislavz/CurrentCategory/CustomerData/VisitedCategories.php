<?php

namespace Stanislavz\CurrentCategory\CustomerData;

class VisitedCategories implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSectionData(): array
    {
        return [];
    }
}
