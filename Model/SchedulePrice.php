<?php

namespace Shopstack\PriceManagement\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Shopstack\PriceManagement\Api\Data\SchedulePriceInterface;

class SchedulePrice extends AbstractModel implements SchedulePriceInterface, IdentityInterface
{
    const CACHE_TAG = 'schedule_p';

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'schedule_price_customer';

    /**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\SchedulePrice::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Get product id
     *
     * @return int|null
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Get price
     *
     * @return float|null
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get start date
     *
     * @return string|null
     */
    public function getStartDate()
    {
        return $this->getData(self::START_DATE);
    }

    /**
     * Get end date
     *
     * @return string|null
     */
    public function getEndDate()
    {
        return $this->getData(self::END_DATE);
    }

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set customer Id
     *
     * @param int $customerId
     *
     * @return SchedulePriceInterface
     */
    public function setCustomerId(int $customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Set product Id
     *
     * @param int $productId
     *
     * @return SchedulePriceInterface
     */
    public function setProductId(int $productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return SchedulePriceInterface
     */
    public function setPrice(float $price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return SchedulePriceInterface
     */
    public function setStatus(int $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set start date
     *
     * @param string $startDate
     *
     * @return SchedulePriceInterface
     */
    public function setStartDate(string $startDate)
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * Set end date
     *
     * @param string $endDate
     *
     * @return SchedulePriceInterface
     */
    public function setEndDate(string $endDate)
    {
        return $this->setData(self::END_DATE, $endDate);
    }

    /**
     * Set created at
     *
     * @param string $createdAt
     *
     * @return SchedulePriceInterface
     */
    public function setCreatedAt(string $createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set updated at
     *
     * @param string $updatedAt
     *
     * @return SchedulePriceInterface
     */
    public function setUpdatedAt(string $updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
