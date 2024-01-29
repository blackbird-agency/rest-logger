<?php

/**
 * Resolver
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Model\Service;

use Blackbird\RestLogger\Api\ConfigInterface;
use Blackbird\RestLogger\Api\ResolverInterface;
use Magento\Framework\App\RequestInterface;

class Resolver implements ResolverInterface
{
    protected array $processedRequests = [];

    public function __construct(
        protected ConfigInterface $config,
        protected RequestInterface $request
    ){
    }

    public function isRequestExcluded(): bool
    {
        if (!isset($this->request)) {
            return true;
        }
        if (isset($this->processedRequests[$this->request->getPathInfo()])) {
            return $this->processedRequests[$this->request->getPathInfo()];
        }
        if ($this->isAuthorizationRequest() && !$this->config->includeAuthorization()) {
            $this->processedRequests[$this->request->getPathInfo()] = true;
            return true;
        }

        // Remove everything before 'V1' in pathInfo to allow proper compare without '/rest/default/V1/'
        $formattedPathInfo = \strstr($this->request->getPathInfo(), 'V1');
        $requestPaths = explode('/', trim($formattedPathInfo ?: $this->request->getPathInfo(), '/'));

        foreach ($this->config->getExcludedServices() as $excludeService) {
            [$routeParts, $variables] = $this->getRoutePartsAndVariables($excludeService);
            if (count($requestPaths) !== count($routeParts)) {
                continue;
            }
            $matches = true;
            foreach ($requestPaths as $key => $value) {
                if (!array_key_exists($key, $routeParts)) {
                    $matches = false;
                    break;
                }
                $variable = $variables[$key] ?? null;
                if (!$variable && $value !== $routeParts[$key]) {
                    $matches = false;
                    break;
                }
            }
            if ($matches) {
                return $this->processedRequests[$this->request->getPathInfo()] = true;
            }
        }

        return $this->processedRequests[$this->request->getPathInfo()] = false;
    }

    /**
     * Split route by parts and variables
     * @param string $route
     * @return array
     */
    protected function getRoutePartsAndVariables(string $route): array
    {
        $result = [];
        $variables = [];
        $routeParts = explode('/', $route);
        foreach ($routeParts as $key => $value) {
            if ($value[0] === ':' && $value[1] !== ':') {
                $variables[$key] = substr($value, 1);
                $value = null;
            }
            $result[$key] = $value;
        }
        return [$result, $variables];
    }

    public function isAuthorizationRequest(): bool
    {
        return preg_match('/integration\/(admin|customer)\/token/', $this->request->getPathInfo()) !== 0;
    }
}
