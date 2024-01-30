<?php

/**
 * CleanupLogs
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Model\ResourceModel;

use Blackbird\RestLogger\Api\CleanLogsInterface;
use DateInterval;
use DateTimeImmutable;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\DateTime;

class CleanLogs implements CleanLogsInterface
{
    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        protected ResourceConnection $resourceConnection
    ) {
    }

    public function execute(int $dayThreshold): void
    {
        $threshold = $this->getDateFromThreshold($dayThreshold);

        $logTable = $this->resourceConnection->getTableName(Log::TABLE_NAME_LOG);
        $connection = $this->resourceConnection->getConnection();
        $connection->delete($logTable, ['created_at < ?' => $threshold]);
    }

    protected function getDateFromThreshold(int $dayThreshold): string
    {
        $now = new DateTimeImmutable();
        $interval = DateInterval::createFromDateString("$dayThreshold day");

        return ($now->sub($interval))->format('Y-m-d');
    }
}
