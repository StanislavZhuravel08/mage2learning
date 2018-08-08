<?php
/**
 * Created by PhpStorm.
 * User: stanislavz
 * Date: 08.08.18
 * Time: 14:14
 */

namespace Stanislavz\CurrentCategory\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [
            self::ENABLED  => __('Enabled'),
            self::DISABLED => __('Disabled')
        ];

        return $options;
    }
}