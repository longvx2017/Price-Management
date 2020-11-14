<?php

namespace Shopstack\PriceManagement\Block\Adminhtml\Tab\Customer;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class Grid extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context           $context
     * @param Data              $backendHelper
     * @param CollectionFactory $collectionFactory
     * @param array             $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customerGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('customer_filter');
    }

    /**
     * @inheritDoc
     */
    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create()->addNameToSelect();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return Grid
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header'           => __('ID'),
                'type'             => 'number',
                'index'            => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
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
     * @inheritDoc
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/customer/grid', ['_current' => true]);
    }

    /**
     * @inheritDoc
     */
    public function getRowUrl($row)
    {
        return '';
    }
}
