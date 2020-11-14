<?php

namespace Shopstack\PriceManagement\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Shopstack\PriceManagement\Api\Data\SchedulePriceInterface;
use Shopstack\PriceManagement\Api\Data\SchedulePriceSearchResultsInterface;

interface SchedulePriceRepositoryInterface
{
    /**
     * Save page.
     *
     * @param SchedulePriceInterface $page
     * @return SchedulePriceInterface
     * @throws LocalizedException
     */
    public function save(SchedulePriceInterface $page);

    /**
     * Retrieve page.
     *
     * @param int $schedulePriceId
     *
     * @return SchedulePriceInterface
     * @throws LocalizedException
     */
    public function getById(int $schedulePriceId);

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SchedulePriceSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete page.
     *
     * @param SchedulePriceInterface $page
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(SchedulePriceInterface $page);

    /**
     * Delete page by ID.
     *
     * @param int $schedulePriceId
     *
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $schedulePriceId);
}
