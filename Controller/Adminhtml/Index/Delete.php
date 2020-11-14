<?php

namespace Shopstack\PriceManagement\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Shopstack\PriceManagement\Controller\Adminhtml\PriceManagement;
use Shopstack\PriceManagement\Model\SchedulePriceRepository;

class Delete extends PriceManagement
{
    /**
     * @var SchedulePriceRepository
     */
    private $schedulePriceRepository;

    /**
     * Delete constructor.
     *
     * @param Context                 $context
     * @param SchedulePriceRepository $schedulePriceRepository
     */
    public function __construct(
        Context $context,
        SchedulePriceRepository $schedulePriceRepository
    ) {
        parent::__construct($context);
        $this->schedulePriceRepository = $schedulePriceRepository;
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('schedule_price_customer_id');
        if ($id) {
            try {
                $this->schedulePriceRepository->deleteById($id);

                $this->messageManager->addSuccessMessage(__('You deleted the Schedule Price.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['schedule_price_customer_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a Schedule Price to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
