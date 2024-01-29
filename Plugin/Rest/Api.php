<?php

/**
 * PayloadPlugin
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Plugin\Rest;

use Blackbird\RestLogger\Api\ConfigInterface;
use Blackbird\RestLogger\Api\Data\LogInterface;
use Blackbird\RestLogger\Api\Data\LogInterfaceFactory;
use Blackbird\RestLogger\Api\ResolverInterface;
use Blackbird\RestLogger\Api\SaveLogsInterface;
use Psr\Log\LoggerInterface;

class Api
{
    protected LogInterface|null $currentRequest;

    public function __construct(
        protected readonly ConfigInterface $config,
        protected LogInterfaceFactory $logFactory,
        protected SaveLogsInterface $saveLogs,
        protected ResolverInterface $resolver,
        protected LoggerInterface $logger
    ) {
    }

    public function aroundDispatch(
        \Magento\Webapi\Controller\Rest $subject,
        callable $proceed,
        \Magento\Framework\App\RequestInterface $request,
    ) {
        if (!$this->config->isEnabled() || $this->resolver->isRequestExcluded()) {
            return $proceed($request);
        }

        try {
            $log = $this->logFactory->create();
            $log->setHttpMethod($request->getMethod());
            $payload = $this->resolver->isAuthorizationRequest() ?
                'Sensitive info cannot be logged' :
                $request->getContent();
            $log->setPayload($payload ?? '{}');
            $log->setEndpoint($request->getRequestUri());

            $this->currentRequest = $log;
        } catch (\Exception $e) {
            $this->logger->warning(\sprintf("Error while logging REST request: %s", $e->getMessage()));
        }

        return $proceed($request);
    }

    public function afterSendResponse(
        \Magento\Framework\Webapi\Rest\Response $subject,
                                                $result
    ) {
        if (!$this->config->isEnabled() || $this->resolver->isRequestExcluded()) {
            return $result;
        }
        try {
            $this->currentRequest->setResponseCode((int)$subject->getStatusCode());
            $this->saveLogs->execute([$this->currentRequest]);
        } catch (\Exception $e) {
            $this->logger->warning(\sprintf("Error while logging REST request: %s", $e->getMessage()));
        }

        return $result;
    }
}
