<?php
namespace Shopstack\PriceManagement\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SchedulePriceSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return SchedulePriceInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param SchedulePriceInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
