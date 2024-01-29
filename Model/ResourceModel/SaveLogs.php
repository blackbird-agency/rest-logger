<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Blackbird\RestLogger\Api\SaveLogsInterface;

class SaveLogs implements SaveLogsInterface
{
    /**
     * @param ResourceConnection $resourceConnection
     * @param DateTime $dateTime
     */
    public function __construct(
        protected ResourceConnection $resourceConnection,
        protected DateTime $dateTime
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(array $logs): void
    {
        $logsData = [];
        foreach ($logs as $log) {
            if (!$log->getCreatedAt()) {
                $log->setCreatedAt($this->dateTime->gmtDate());
            }
            $logsData[] = $log->getData();
        }
        $logTable = $this->resourceConnection->getTableName(Log::TABLE_NAME_LOG);
        $connection = $this->resourceConnection->getConnection();
        $connection->insertMultiple($logTable, $logsData);
    }
}
