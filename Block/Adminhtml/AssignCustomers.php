<?php

namespace Shopstack\PriceManagement\Block\Adminhtml;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\BlockInterface;
use Shopstack\PriceManagement\Block\Adminhtml\Tab\Customer;

class AssignCustomers extends AbstractAssign
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'Shopstack_PriceManagement::price/assign_customers.phtml';

    /**
     * @var Customer
     */
    protected $blockGrid;

    /**
     * Retrieve instance of grid block
     *
     * @return BlockInterface
     * @throws LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                Customer::class,
                'price.customer.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * @return string
     */
    public function getCustomerJson()
    {
        $schedulePrice = $this->getSchedulePrice();

        if (empty($schedulePrice)) {
            return '{}';
        }

        return $schedulePrice->getCustomerId();
    }
}
