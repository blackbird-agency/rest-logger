<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Controller\Adminhtml\Log;

use Blackbird\RestLogger\Model\GetLogList;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Blackbird\RestLogger\Api\ConfigInterface;


class View extends Action implements HttpGetActionInterface
{
    /**.
     * @param Context $context
     * @param ConfigInterface $config
     */
    public function __construct(
        Context $context,
        protected ConfigInterface $config
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('REST Api Logs view'));
        return $resultPage;
    }
}
