<?php
namespace Shopstack\PriceManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SchedulePrice extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('schedule_price_customer', 'schedule_price_customer_id');
    }
}
