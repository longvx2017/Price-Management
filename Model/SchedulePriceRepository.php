<?php

namespace Shopstack\PriceManagement\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Shopstack\PriceManagement\Api\Data;
use Shopstack\PriceManagement\Api\Data\SchedulePriceInterface;
use Shopstack\PriceManagement\Api\Data\SchedulePriceInterfaceFactory;
use Shopstack\PriceManagement\Api\Data\SchedulePriceSearchResultsInterface;
use Shopstack\PriceManagement\Api\SchedulePriceRepositoryInterface;
use Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice as ResourceSchedulePrice;
use Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice\CollectionFactory as SchedulePriceCollectionFactory;

class SchedulePriceRepository implements SchedulePriceRepositoryInterface
{
    /**
     * @var ResourceSchedulePrice
     */
    protected $resource;

    /**
     * @var SchedulePriceFactory
     */
    protected $schedulePriceFactory;

    /**
     * @var SchedulePriceCollectionFactory
     */
    protected $schedulePriceCollectionFactory;

    /**
     * @var Data\SchedulePriceSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var SchedulePriceInterfaceFactory
     */
    protected $dataSchedulePriceFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * SchedulePriceRepository constructor.
     *
     * @param ResourceSchedulePrice                           $resource
     * @param SchedulePriceFactory                            $schedulePriceFactory
     * @param SchedulePriceInterfaceFactory                   $dataSchedulePriceFactory
     * @param SchedulePriceCollectionFactory                  $schedulePriceCollectionFactory
     * @param Data\SchedulePriceSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                                $dataObjectHelper
     * @param DataObjectProcessor                             $dataObjectProcessor
     * @param StoreManagerInterface                           $storeManager
     */
    public function __construct(
        ResourceSchedulePrice $resource,
        SchedulePriceFactory $schedulePriceFactory,
        SchedulePriceInterfaceFactory $dataSchedulePriceFactory,
        SchedulePriceCollectionFactory $schedulePriceCollectionFactory,
        Data\SchedulePriceSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->schedulePriceFactory = $schedulePriceFactory;
        $this->schedulePriceCollectionFactory = $schedulePriceCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSchedulePriceFactory = $dataSchedulePriceFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save SchedulePrice data
     *
     * @param SchedulePriceInterface $schedulePrice
     *
     * @return SchedulePrice
     * @throws CouldNotSaveException|NoSuchEntityException
     */
    public function save(SchedulePriceInterface $schedulePrice)
    {
        if (empty($schedulePrice->getStoreId())) {
            $schedulePrice->setStoreId($this->storeManager->getStore()->getId());
        }

        try {
            $this->resource->save($schedulePrice);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $schedulePrice;
    }

    /**
     * Load SchedulePrice data by given SchedulePrice Identity
     *
     * @param int $schedulePriceId
     *
     * @return SchedulePrice
     * @throws NoSuchEntityException
     */
    public function getById(int $schedulePriceId)
    {
        $schedulePrice = $this->schedulePriceFactory->create();
        $this->resource->load($schedulePrice, $schedulePriceId);
        if (!$schedulePrice->getId()) {
            throw new NoSuchEntityException(
                __(
                    'The Schedule Price with the "%1" ID doesn\'t exist.',
                    $schedulePriceId
                )
            );
        }
        return $schedulePrice;
    }

    /**
     * Load SchedulePrice data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return SchedulePriceSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->schedulePriceCollectionFactory->create();

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete SchedulePrice
     *
     * @param SchedulePriceInterface $schedulePrice
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(SchedulePriceInterface $schedulePrice)
    {
        try {
            $this->resource->delete($schedulePrice);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete SchedulePrice by given SchedulePrice Identity
     *
     * @param int $schedulePriceId
     *
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $schedulePriceId)
    {
        return $this->delete($this->getById($schedulePriceId));
    }
}
