<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Api;

use Blackbird\RestLogger\Api\Data\LogInterface;

interface SaveLogsInterface
{
    /**
     * Save logs.
     *
     * @param LogInterface[] $logs
     * @return void
     * @since 100.4.0
     */
    public function execute(array $logs): void;
}
