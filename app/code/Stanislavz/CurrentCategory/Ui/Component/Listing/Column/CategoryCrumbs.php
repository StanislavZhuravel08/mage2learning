<?php

namespace Stanislavz\CurrentCategory\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class CategoryCrumbs extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['path'] = 'some';
            }
        }
        return $dataSource;
    }
}
