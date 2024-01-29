<?php


namespace Blackbird\RestLogger\Api;

interface ConfigInterface
{
    public const IS_ENABLED_PATH = 'restlogger/general/enabled';
    public const EXCLUDED_SERVICES_PATH = 'restlogger/general/excluded_services';
    public const INCLUDE_AUTHORIZATION_PATH = 'restlogger/general/include_authorization';
    public const SHOULD_CLEANUP_LOGS_PATH = 'restlogger/cleanup/enabled';
    public const CLEANUP_LOGS_THRESHOLD_PATH = 'restlogger/cleanup/threshold';

    public function isEnabled(): bool;

    public function getCleanupThreshold(): int;

    public function shouldCleanupLogs(): bool;

    public function getExcludedServices(): array;

    public function includeAuthorization(): bool;
}
