<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Model;

use Magento\Framework\Api\SearchResults;
use Blackbird\RestLogger\Api\Data\LogSearchResultsInterface;

/**
 * @inheritDoc
 */
class LogSearchResults extends SearchResults implements LogSearchResultsInterface
{
}
