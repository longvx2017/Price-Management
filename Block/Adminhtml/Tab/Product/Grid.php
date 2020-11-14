<?php

namespace Shopstack\PriceManagement\Block\Adminhtml\Tab\Product;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Module\Manager;

class Grid extends Extended
{
    /**
     * @var Manager
     */
    protected $moduleManager;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Type
     */
    protected $_type;

    /**
     * @var Status
     */
    protected $_status;

    /**
     * @var Visibility
     */
    protected $_visibility;

    /**
     * Grid constructor.
     *
     * @param Context           $context
     * @param Data              $backendHelper
     * @param CollectionFactory $collectionFactory
     * @param Type              $type
     * @param Status            $status
     * @param Visibility        $visibility
     * @param Manager           $moduleManager
     * @param array             $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $collectionFactory,
        Type $type,
        Status $status,
        Visibility $visibility,
        Manager $moduleManager,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_type             = $type;
        $this->_status           = $status;
        $this->_visibility       = $visibility;
        $this->moduleManager     = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('product_filter');
    }

    /**
     * @inheritDoc
     */
    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create()
            ->addAttributeToSelect(
                'sku'
            )->addAttributeToSelect(
                'name'
            )->addAttributeToSelect(
                'attribute_set_id'
            )->addAttributeToSelect(
                'type_id'
            );

        $collection->addAttributeToSelect('price');
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');

        $this->setCollection($collection);

        $this->getCollection()->addWebsiteNamesToResult();

        parent::_prepareCollection();

        return $this;
    }

    /**
     * Prepare the columns
     *
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
            'name',
            [
                'header' => __('Name'),
                'index'  => 'name',
                'class'  => 'xxx',
            ]
        );

        $this->addColumn(
            'type',
            [
                'header'  => __('Type'),
                'index'   => 'type_id',
                'type'    => 'options',
                'options' => $this->_type->getOptionArray(),
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index'  => 'sku',
            ]
        );

        $store = $this->_getStore();
        $this->addColumn(
            'price',
            [
                'header'           => __('Price'),
                'type'             => 'price',
                'currency_code'    => $store->getBaseCurrency()->getCode(),
                'index'            => 'price',
                'header_css_class' => 'col-price',
                'column_css_class' => 'col-price',
            ]
        );

        $this->addColumn(
            'visibility',
            [
                'header'           => __('Visibility'),
                'index'            => 'visibility',
                'type'             => 'options',
                'options'          => $this->_visibility->getOptionArray(),
                'header_css_class' => 'col-visibility',
                'column_css_class' => 'col-visibility',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header'  => __('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => $this->_status->getOptionArray(),
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @inheritDoc
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/product/grid', ['_current' => true]);
    }

    /**
     * @inheritDoc
     */
    public function getRowUrl($row)
    {
        return '';
    }
}
