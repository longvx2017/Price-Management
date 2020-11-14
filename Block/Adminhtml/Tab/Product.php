<?php

namespace Shopstack\PriceManagement\Block\Adminhtml\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Directory\Model\Currency;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;
use Shopstack\PriceManagement\Helper\Data;

class Product extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Status
     */
    private $status;

    /**
     * @var Visibility
     */
    private $visibility;

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
     * @param Visibility|null              $visibility
     * @param Status|null                  $status
     */
    public function __construct(
        Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $collectionFactory,
        Data $helper,
        array $data = [],
        Visibility $visibility = null,
        Status $status = null
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->visibility = $visibility ?: ObjectManager::getInstance()->get(Visibility::class);
        $this->status = $status ?: ObjectManager::getInstance()->get(Status::class);
        $this->helper = $helper;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @throws FileSystemException
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('price_management_products');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    /**
     * @param Column $column
     *
     * @return $this|Product
     * @throws LocalizedException
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } elseif (!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare the columns
     *
     * @return Product
     */
    protected function _prepareCollection()
    {
        $this->setDefaultFilter(['in_product' => 1]);

        $collection = $this->collectionFactory->create()
            ->addAttributeToSelect(
                'name'
            )->addAttributeToSelect(
                'sku'
            )->addAttributeToSelect(
                'visibility'
            )->addAttributeToSelect(
                'status'
            )->addAttributeToSelect(
                'price'
            );

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return Product
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_product',
            [
                'type' => 'radio',
                'name' => 'in_product',
                'html_name' => 'in_product[]',
                'values' => $this->_getSelectedProducts(),
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
        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);
        $this->addColumn('sku', ['header' => __('SKU'), 'index' => 'sku']);
        $this->addColumn(
            'visibility',
            [
                'header' => __('Visibility'),
                'index' => 'visibility',
                'type' => 'options',
                'options' => $this->visibility->getOptionArray(),
                'header_css_class' => 'col-visibility',
                'column_css_class' => 'col-visibility'
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->status->getOptionArray()
            ]
        );

        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    Currency::XML_PATH_CURRENCY_BASE,
                    ScopeInterface::SCOPE_STORE
                ),
                'index' => 'price'
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
        return $this->getUrl('*/product/grid', ['_current' => true]);
    }

    /**
     * Get selected products
     *
     * @return array|null
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('selected_products');
        if ($products === null) {
            $schedulePrice = $this->helper->getSchedulePrice();
            if (empty($schedulePrice)) {
                return [];
            }

            return [$schedulePrice->getProductId()];
        }

        return [$products];
    }
}
