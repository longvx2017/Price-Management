<?php

namespace Shopstack\PriceManagement\Block;

use Magento\Framework\View\Element\Template;
use Shopstack\PriceManagement\Helper\Data;

class SchedulePrice extends Template
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * SchedulePrice constructor.
     *
     * @param Template\Context $context
     * @param Data             $helper
     * @param array            $data
     */
    public function __construct(
        Template\Context $context,
        Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    /**
     * Get content of notification on the header when the schedule prices are available for the customer.
     *
     * @return null|string
     */
    public function getNotificationHtml()
    {
        return $this->helper->getNotificationSchedulePrices();
    }
}
