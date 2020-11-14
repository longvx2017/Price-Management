<?php

namespace Shopstack\PriceManagement\Block\Adminhtml;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\BlockInterface;
use Shopstack\PriceManagement\Block\Adminhtml\Tab\Product;

class AssignProducts extends AbstractAssign
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'Shopstack_PriceManagement::price/assign_products.phtml';

    /**
     * @var Product
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
                Product::class,
                'price.product.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * @return string
     */
    public function getProductJson()
    {
        $schedulePrice = $this->getSchedulePrice();

        if (empty($schedulePrice)) {
            return '{}';
        }

        return $schedulePrice->getProductId();
    }
}
