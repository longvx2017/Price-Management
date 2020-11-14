<?php

namespace Shopstack\PriceManagement\Plugin\Model;

use Magento\Catalog\Model\Product;
use Shopstack\PriceManagement\Helper\Data;

class DisplaySchedulePrice
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * DisplaySchedulePrice constructor.
     *
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Check the schedule price of product for logged customer.
     *
     * @param Product $subject
     * @param         $result
     *
     * @return mixed
     */
    public function afterGetPrice(Product $subject, $result)
    {
        return $this->helper->getPriceProductPerCustomer($subject->getId(), $result);
    }
}
