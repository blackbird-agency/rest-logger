<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Model\ResourceModel\Log;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Blackbird\RestLogger\Model\Log;
use Blackbird\RestLogger\Model\ResourceModel\Log as LogResource;

class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Log::class, LogResource::class);
    }
}
