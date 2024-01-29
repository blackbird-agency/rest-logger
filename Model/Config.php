<?php

/**
 * Config
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Model;

use Blackbird\RestLogger\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config implements ConfigInterface
{
    public function __construct(
        protected readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::IS_ENABLED_PATH);
    }

    public function getCleanupThreshold(): int
    {
        return (int)$this->scopeConfig->getValue(self::CLEANUP_LOGS_THRESHOLD_PATH);
    }

    public function shouldCleanupLogs(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::SHOULD_CLEANUP_LOGS_PATH);
    }

    public function getExcludedServices(): array
    {
        $value = $this->scopeConfig->getValue(self::EXCLUDED_SERVICES_PATH, );
        return $value !== null ? explode(',',$value) : [];
    }

    public function includeAuthorization(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::INCLUDE_AUTHORIZATION_PATH);
    }
}
