<?php

namespace Shopstack\PriceManagement\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Shopstack\PriceManagement\Controller\Adminhtml\PriceManagement;
use Shopstack\PriceManagement\Model\SchedulePrice;
use Shopstack\PriceManagement\Model\SchedulePriceFactory;
use Shopstack\PriceManagement\Model\SchedulePriceRepository;

class Save extends PriceManagement
{
    /**
     * @var SchedulePriceFactory
     */
    private $schedulePriceFactory;

    /**
     * @var SchedulePriceRepository
     */
    private $schedulePriceRepository;

    /**
     * Save constructor.
     *
     * @param Context                 $context
     * @param SchedulePriceFactory    $schedulePriceFactory
     * @param SchedulePriceRepository $schedulePriceRepository
     */
    public function __construct(
        Context $context,
        SchedulePriceFactory $schedulePriceFactory,
        SchedulePriceRepository $schedulePriceRepository
    ) {
        parent::__construct($context);
        $this->schedulePriceFactory    = $schedulePriceFactory;
        $this->schedulePriceRepository = $schedulePriceRepository;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = SchedulePrice::STATUS_ENABLED;
            }

            if (empty($data['schedule_price_customer_id'])) {
                $data['schedule_price_customer_id'] = null;
            }

            $id = $this->getRequest()->getParam('schedule_price_customer_id');

            try {
                if (!filter_var($data['price'], FILTER_VALIDATE_FLOAT)) {
                    throw new LocalizedException(
                        __('The Price was wrong format. Please enter it again!')
                    );
                }

                if (strtotime($data['start_date']) > strtotime($data['end_date'])) {
                    throw new LocalizedException(
                        __('The END DATE must be greater than START DATE!')
                    );
                }

                $model = $this->schedulePriceFactory->create();

                if ($id) {
                    try {
                        $model = $this->schedulePriceRepository->getById($id);
                    } catch (LocalizedException $e) {
                        $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                        return $resultRedirect->setPath('*/*/');
                    }
                }

                $model->setData($data);

                $this->schedulePriceRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the schedule price.'));
                return $resultRedirect->setPath('*/*/edit', ['schedule_price_customer_id' => $model->getId()]);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['schedule_price_customer_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
