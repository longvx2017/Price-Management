<?php

namespace Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Shopstack\PriceManagement\Model\SchedulePrice;
use Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice as ResourceSchedulePrice;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'schedule_price_customer_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(SchedulePrice::class, ResourceSchedulePrice::class);
    }
}
