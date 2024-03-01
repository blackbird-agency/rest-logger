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
        if($this->_request->getParam('id') === null) {
            return null;
        }
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(LogInterface::LOG_ID, $this->_request->getParam('id'))
            ->create();
        $result = $this->getLogList->execute($searchCriteria);
        $log = \current($result->getItems());

        return $log ?: null;
    }

    public function getFormattedJson(string $input): string
    {
        try {
            $decoded = json_decode($input, JSON_THROW_ON_ERROR);
            if ($decoded === null) {
                return $input;
            }
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) ?: $input;
        } catch (\Exception) {
            return $input;
        }
    }
}
