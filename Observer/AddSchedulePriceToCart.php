<?php

namespace Shopstack\PriceManagement\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddSchedulePriceToCart implements ObserverInterface
{

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);
        $item->setCustomPrice($item->getPrice());
        $item->setOriginalCustomPrice($item->getPrice());
        $item->getProduct()->setIsSuperMode(true);
    }
}
