<?php

namespace Shopstack\PriceManagement\Helper;

use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice\Collection;
use Shopstack\PriceManagement\Model\ResourceModel\SchedulePrice\CollectionFactory;
use Shopstack\PriceManagement\Model\SchedulePriceRepository;
use Shopstack\PriceManagement\Model\SchedulePrice;

class Data extends AbstractHelper
{
    /**
     * @var SchedulePriceRepository
     */
    protected $schedulePriceRepository;

    /**
     * @var CustomerSessionFactory
     */
    protected $customerSessionFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var null | SchedulePriceRepository
     */
    protected $schedulePrice = null;

    /**
     * Data constructor.
     *
     * @param Context                 $context
     * @param SchedulePriceRepository $schedulePriceRepository
     * @param CollectionFactory       $collectionFactory
     * @param ProductRepository       $productRepository
     * @param CustomerSessionFactory  $customerSessionFactory
     */
    public function __construct(
        Context $context,
        SchedulePriceRepository $schedulePriceRepository,
        CollectionFactory $collectionFactory,
        ProductRepository $productRepository,
        CustomerSessionFactory $customerSessionFactory
    ) {
        parent::__construct($context);
        $this->schedulePriceRepository = $schedulePriceRepository;
        $this->customerSessionFactory  = $customerSessionFactory;
        $this->collectionFactory       = $collectionFactory;
        $this->productRepository       = $productRepository;
    }

    /**
     * @return null|SchedulePrice|SchedulePriceRepository
     */
    public function getSchedulePrice()
    {
        if ($this->schedulePrice === null) {
            $id = $this->_getRequest()->getParam('schedule_price_customer_id', null);

            if (empty($id)) {
                return null;
            }

            try {
                $schedulePrice = $this->schedulePriceRepository->getById($id);

                if (!$schedulePrice->getId()) {
                    return null;
                }

                $this->schedulePrice = $schedulePrice;
            } catch (\Exception $exception) {
                return null;
            }
        }

        return $this->schedulePrice;
    }

    /**
     * @return Session
     */
    public function getCurrentCustomer()
    {
        return $customerSession = $this->customerSessionFactory->create();
    }

    /**
     * @return null|Collection
     */
    public function getSchedulePricesOfCustomer()
    {
        $customerSession = $this->getCurrentCustomer();
        if (!$customerSession->isLoggedIn()) {
            return null;
        }

        $customerId = $customerSession->getCustomerId();

        if (empty($customerId)) {
            return null;
        }

        $schedulePrices = $this->collectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('status', SchedulePrice::STATUS_ENABLED)
            ->addFieldToFilter('start_date', ['lteq' => date('Y-m-d 00:00:00', time())])
            ->addFieldToFilter('end_date', ['gteq' => date('Y-m-d 00:00:00', time())])
            ->setOrder('schedule_price_customer_id', 'desc');

        if (count($schedulePrices) <= 0) {
            return null;
        }

        return $schedulePrices;
    }

    /**
     * @return null|string
     */
    public function getNotificationSchedulePrices()
    {
        $schedulePrices = $this->getSchedulePricesOfCustomer();
        if (empty($schedulePrices)) {
            return null;
        }

        $html = '';
        $html .= __('You have some discount products as: <br />');
        foreach ($schedulePrices as $schedulePrice) {
            try {
                $product = $this->productRepository->getById($schedulePrice->getProductId());
            } catch (\Exception $exception) {
                continue;
            }

            $html .= __('- <a href="%1">%2</a> <br />', $product->getProductUrl(), $product->getName());
        }

        return $html;
    }

    /**
     * @param $productId
     * @param $productPrice
     *
     * @return mixed
     */
    public function getPriceProductPerCustomer($productId, $productPrice)
    {
        $customerSession = $this->getCurrentCustomer();
        if (!$customerSession->isLoggedIn()) {
            return $productPrice;
        }

        $customerId = $customerSession->getCustomerId();

        if (empty($customerId)) {
            return $productPrice;
        }

        try {
            $schedulePrice = $this->collectionFactory->create()
                ->addFieldToFilter('customer_id', $customerId)
                ->addFieldToFilter('status', SchedulePrice::STATUS_ENABLED)
                ->addFieldToFilter('product_id', $productId)
                ->addFieldToFilter('start_date', ['lteq' => date('Y-m-d 00:00:00', time())])
                ->addFieldToFilter('end_date', ['gteq' => date('Y-m-d 00:00:00', time())])
                ->setOrder('schedule_price_customer_id', 'desc')
                ->getFirstItem();

            if (empty($schedulePrice) || !$schedulePrice->getId()) {
                return $productPrice;
            }

            return $schedulePrice->getPrice();
        } catch (\Exception $exception) {
            return $productPrice;
        }
    }
}
