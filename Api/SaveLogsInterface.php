<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Api;

interface SaveLogsInterface
{
    /**
     * Save logs.
     *
     * @param \Blackbird\RestLogger\Api\Data\LogInterface[] $logs
     * @return void
     * @since 100.4.0
     */
    public function execute(array $logs): void;
}
