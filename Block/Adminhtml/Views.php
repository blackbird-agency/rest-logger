<?php

namespace Blackbird\RestLogger\Block\Adminhtml;

use Blackbird\RestLogger\Api\Data\LogInterface;
use Blackbird\RestLogger\Model\GetLogList;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use tubalmartin\CssMin\Utils;

class Views extends Template
{
    public function __construct(
        Template\Context $context,
        protected GetLogList $getLogList,
        protected SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getLogDetails(): ?LogInterface
    {
        if($this->_request->getParam('id') === null)
        {
            return null;
        }
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(LogInterface::LOG_ID, $this->_request->getParam('id'))
            ->create();
        $result = $this->getLogList->execute($searchCriteria);
        $log = \current($result->getItems());

        return $log ?: null;
    }

    public function getFormattedJson(string $json): string
    {
        $decoded = json_decode($json);
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            return $json;
        }

        $encoded = json_encode($decoded, JSON_PRETTY_PRINT);
        if ($encoded === false) {
            return $json;
        }

        return $encoded;
    }
}
