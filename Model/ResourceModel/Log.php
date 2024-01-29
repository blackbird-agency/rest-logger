<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Blackbird\RestLogger\Api\Data\LogInterface;

class Log extends AbstractDb
{
    const TABLE_NAME_LOG = 'restlogger_log';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME_LOG, LogInterface::LOG_ID);
    }
}
