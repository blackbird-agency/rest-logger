<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Api\Data;

use \Magento\Framework\Api\SearchResultsInterface;

interface LogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get log list.
     *
     * @return \Blackbird\RestLogger\Api\Data\LogInterface[]
     * @since 100.4.0
     */
    public function getItems();

    /**
     * Set log list.
     *
     * @param \Blackbird\RestLogger\Api\Data\LogInterface[] $items
     * @return void
     * @since 100.4.0
     */
    public function setItems(array $items);
}
