<?php

namespace Shopstack\PriceManagement\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;

abstract class PriceManagement extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Shopstack_PriceManagement::price_management';

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Shopstack_PriceManagement::price_management')
            ->addBreadcrumb(__('Catalog'), __('Catalog'))
            ->addBreadcrumb(__('Price Management'), __('Price Management'));
        return $resultPage;
    }
}
