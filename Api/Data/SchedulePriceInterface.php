<?php

namespace Shopstack\PriceManagement\Api\Data;

interface SchedulePriceInterface
{
    const SCHEDULE_PRICE_ID = 'schedule_price_customer_id';
    const TITLE             = 'title';
    const CUSTOMER_ID       = 'customer_id';
    const PRODUCT_ID        = 'product_id';
    const PRICE             = 'price';
    const STATUS            = 'status';
    const START_DATE        = 'start_date';
    const END_DATE          = 'end_date';
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Get product id
     *
     * @return int|null
     */
    public function getProductId();

    /**
     * Get price
     *
     * @return float|null
     */
    public function getPrice();

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Get start date
     *
     * @return string|null
     */
    public function getStartDate();

    /**
     * Get end date
     *
     * @return string|null
     */
    public function getEndDate();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return SchedulePriceInterface
     */
    public function setId(int $id);

    /**
     * Set customer Id
     *
     * @param int $customerId
     *
     * @return SchedulePriceInterface
     */
    public function setCustomerId(int $customerId);

    /**
     * Set product Id
     *
     * @param int $productId
     *
     * @return SchedulePriceInterface
     */
    public function setProductId(int $productId);

    /**
     * Set price
     *
     * @param float $price
     *
     * @return SchedulePriceInterface
     */
    public function setPrice(float $price);

    /**
     * Set status
     *
     * @param int $status
     *
     * @return SchedulePriceInterface
     */
    public function setStatus(int $status);

    /**
     * Set start date
     *
     * @param string $startDate
     *
     * @return SchedulePriceInterface
     */
    public function setStartDate(string $startDate);

    /**
     * Set end date
     *
     * @param string $endDate
     *
     * @return SchedulePriceInterface
     */
    public function setEndDate(string $endDate);

    /**
     * Set created at
     *
     * @param string $createdAt
     *
     * @return SchedulePriceInterface
     */
    public function setCreatedAt(string $createdAt);

    /**
     * Set updated at
     *
     * @param string $updatedAt
     *
     * @return SchedulePriceInterface
     */
    public function setUpdatedAt(string $updatedAt);
}
