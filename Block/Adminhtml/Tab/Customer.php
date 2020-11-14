<?php

namespace Shopstack\PriceManagement\Block\Adminhtml\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Shopstack\PriceManagement\Helper\Data;

class Customer extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Context                      $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param CollectionFactory            $collectionFactory
     * @param Data                         $helper
     * @param array                        $data
     */
    public function __construct(
        Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $collectionFactory,
        Data $helper,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->helper = $helper;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @throws FileSystemException
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('price_management_customers');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    /**
     * @param Column $column
     *
     * @return $this|Customer
     * @throws LocalizedException
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_customer') {
            $customerIds = $this->getSelectedCustomers();
            if (empty($customerIds)) {
                $customerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $customerIds]);
            } elseif (!empty($customerIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $customerIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @return Customer
     */
    protected function _prepareCollection()
    {
        $this->setDefaultFilter(['in_customer' => 1]);

        $collection = $this->collectionFactory->create()->addNameToSelect();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return Customer
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_customer',
            [
                'type' => 'radio',
                'name' => 'in_customer',
                'html_name' => 'in_customer[]',
                'values' => $this->getSelectedCustomers(),
                'index' => 'entity_id',
                'header_css_class' => 'col-select col-massaction',
                'column_css_class' => 'col-select col-massaction'
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'type' => 'text',
                'index' => 'name',
            ]
        );

        $this->addColumn(
            'email',
            [
                'header' => __('Email'),
                'type' => 'text',
                'index' => 'email',
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Customer Since'),
                'type' => 'date',
                'index' => 'created_at',
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get Grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/customer/grid', ['_current' => true]);
    }

    /**
     * Get selected customers
     *
     * @return array|null
     */
    protected function getSelectedCustomers()
    {
        $customers = $this->getRequest()->getPost('selected_customers');
        if ($customers === null) {
            $schedulePrice = $this->helper->getSchedulePrice();
            if (empty($schedulePrice)) {
                return null;
            }

            return [$schedulePrice->getCustomerId()];
        }
        return [$customers];
    }
}
