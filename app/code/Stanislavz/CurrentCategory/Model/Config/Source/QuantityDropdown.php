<?php

namespace Stanislavz\CurrentCategory\Model\Config\Source;

class QuantityDropdown implements \Magento\Framework\Option\ArrayInterface
{
    const MIN_VALUE = 3;
    const MAX_VALUE = 25;

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $result = [];

        for ($i = self::MIN_VALUE, $j = 0; $i <= self::MAX_VALUE; $i++, $j++) {
            $result[$j]['value'] = $i;
            $result[$j]['label'] = $i;
        }

        return $result;
    }
}
