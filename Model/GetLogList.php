<?php

declare(strict_types=1);

namespace Blackbird\RestLogger\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Blackbird\RestLogger\Api\Data\LogSearchResultsInterface;
use Blackbird\RestLogger\Api\Data\LogSearchResultsInterfaceFactory;
use Blackbird\RestLogger\Api\GetLogsListInterface;
use Blackbird\RestLogger\Model\ResourceModel\Log\CollectionFactory;

/**
 * @inheritDoc
 */
class GetLogList implements GetLogsListInterface
{
    /**
     * @param CollectionFactory $logCollectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CollectionProcessorInterface $collectionProcessor
     * @param LogSearchResultsInterfaceFactory $logSearchResultsFactory
     */
    public function __construct(
        protected CollectionFactory $logCollectionFactory,
        protected SearchCriteriaBuilder $searchCriteriaBuilder,
        protected CollectionProcessorInterface $collectionProcessor,
        protected LogSearchResultsInterfaceFactory $logSearchResultsFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(SearchCriteriaInterface $searchCriteria): LogSearchResultsInterface
    {
        $collection = $this->logCollectionFactory->create();
        $searchCriteria = $searchCriteria ?: $this->searchCriteriaBuilder->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->logSearchResultsFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
