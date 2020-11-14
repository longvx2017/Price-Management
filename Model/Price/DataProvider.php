<?php

namespace Shopstack\PriceManagement\Model\Price;

use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice\Collection;
use Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice\CollectionFactory;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string             $name
     * @param string             $primaryFieldName
     * @param string             $requestFieldName
     * @param CollectionFactory  $collectionFactory
     * @param array              $meta
     * @param array              $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $schedulePrice) {
            $this->loadedData[$schedulePrice->getId()] = $schedulePrice->getData();
        }

        return $this->loadedData;
    }
}
