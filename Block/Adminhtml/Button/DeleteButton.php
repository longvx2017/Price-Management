<?php

namespace Shopstack\PriceManagement\Block\Adminhtml\Button;

use Magento\Backend\Block\Template;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends Template implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $id = $this->getRequest()->getParam('schedule_price_customer_id', null);

        if (empty($id)) {
            return [];
        }

        return [
            'id' => 'delete',
            'label' => __('Delete'),
            'on_click' => "deleteConfirm('" . __('Are you sure you want to delete this category?') . "', '"
                . $this->getDeleteUrl() . "', {data: {}})",
            'class' => 'delete',
            'sort_order' => 10
        ];
    }

    /**
     * @param array $args
     * @return string
     */
    public function getDeleteUrl(array $args = [])
    {
        $params = array_merge($this->getDefaultUrlParams(), $args);
        return $this->getUrl('*/*/delete', $params);
    }

    /**
     * @return array
     */
    protected function getDefaultUrlParams()
    {
        return ['_current' => true, '_query' => ['isAjax' => null]];
    }
}
