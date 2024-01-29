<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Controller\Adminhtml\Log;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Blackbird\RestLogger\Api\ConfigInterface;


class Index extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Blackbird_RestLogger::restcall_log';

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
    public function dispatch(RequestInterface $request)
    {
        if (!$this->config->isEnabled() && ($request->getActionName() !== 'noroute')) {
            $this->_forward('noroute');
        }

        return parent::dispatch($request);
    }

    /**
     * @inheritdoc
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Blackbird_RestLogger::restcall_log')
            ->addBreadcrumb(__('REST Api Logs'), __('List'));
        $resultPage->getConfig()->getTitle()->prepend(__('REST Api Logs'));

        return $resultPage;
    }
}
