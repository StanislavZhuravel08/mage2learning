<?php

namespace Stanislavz\CurrentCategory\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

class VisitedCategoriesSection implements SectionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        /**
         * returns visited categories data in format:
         *  items=>[
         *      [
         *          itemData
         *      ]
         *  ]
         */
        return [
                'items' => [
                    [
                        'foo' => 25,
                        'parentCategoryIds' => [18,19,20],
                        'currentCategoryId' => 12
                    ],
                    [
                        'foo' => 28,
                        'parentCategoryIds' => [21],
                        'currentCategoryId' => 12
                    ],
                    [
                        'foo' => 'bar',
                        'parentCategoryIds' => [22,23,24,25],
                        'currentCategoryId' => 12
                    ]
                ]
        ];
    }
}
