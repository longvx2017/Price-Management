<?php

namespace Shopstack\PriceManagement\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Registry;
use Shopstack\PriceManagement\Helper\Data;
use Shopstack\PriceManagement\Model\SchedulePrice;
use Shopstack\PriceManagement\Model\SchedulePriceRepository;

abstract class AbstractAssign extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * AbstractAssign constructor.
     *
     * @param Context          $context
     * @param Registry         $registry
     * @param EncoderInterface $jsonEncoder
     * @param Data             $helper
     * @param array            $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        EncoderInterface $jsonEncoder,
        Data $helper,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->jsonEncoder = $jsonEncoder;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    abstract public function getBlockGrid();

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * @return null|SchedulePrice|SchedulePriceRepository
     */
    public function getSchedulePrice()
    {
        return $this->helper->getSchedulePrice();
    }
}
