<?php

namespace Shopstack\PriceManagement\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Shopstack\PriceManagement\Controller\Adminhtml\PriceManagement;
use Shopstack\PriceManagement\Model\SchedulePriceRepository;

class Edit extends PriceManagement
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var SchedulePriceRepository
     */
    private $schedulePriceRepository;

    /**
     * Edit constructor.
     *
     * @param Context                 $context
     * @param SchedulePriceRepository $schedulePriceRepository
     * @param PageFactory             $resultPageFactory
     */
    public function __construct(
        Context $context,
        SchedulePriceRepository $schedulePriceRepository,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->schedulePriceRepository = $schedulePriceRepository;
        parent::__construct($context);
    }

    /**
     * Edit CMS block
     *
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('schedule_price_customer_id', null);

        $model = null;
        try {
            if ($id) {
                $model = $this->schedulePriceRepository->getById($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This schedule price no longer exists.'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            }
        } catch (\Exception $exception) {
            $model = null;
        }

        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Schedule Price') : __('New Price Management'),
            $id ? __('Edit Schedule Price') : __('New Price Management')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Price Management'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model && $model->getId() ? $model->getTitle() : __('New Price Management')
        );

        return $resultPage;
    }
}
