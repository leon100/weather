<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Leon\Weather\Model\ResourceModel\Weather;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'weather_id';

    protected function _construct()
    {
        $this->_init(
            \Leon\Weather\Model\Weather::class,
            \Leon\Weather\Model\ResourceModel\Weather::class
        );
    }
}

