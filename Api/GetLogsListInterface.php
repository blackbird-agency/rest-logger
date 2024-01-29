<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Blackbird\RestLogger\Api\Data\LogSearchResultsInterface;

interface GetLogsListInterface
{
    /**
     * Retrieve list of log entities.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return LogSearchResultsInterface
     * @since 100.4.0
     */
    public function execute(SearchCriteriaInterface $searchCriteria): LogSearchResultsInterface;
}
