<?php

/**
 * CleanupLogs
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Cron;

use Blackbird\RestLogger\Api\CleanLogsInterface;
use Blackbird\RestLogger\Api\ConfigInterface;

class CleanupLogs
{
    public function __construct(
        protected CleanLogsInterface $cleanLogs,
        protected ConfigInterface $config
    ) {
    }

    public function execute(): void
    {
        try {
            if (!$this->config->shouldCleanupLogs()) {
                return;
            }
            $this->cleanLogs->execute($this->config->getCleanupThreshold());
        } catch (\Exception) {
            return;
        }
    }
}
