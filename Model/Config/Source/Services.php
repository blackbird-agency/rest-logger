<?php

/**
 * Services
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Webapi\Model\Config\Converter;

class Services implements ArrayInterface
{
    /**
     * @var array
     */
    protected $options;

    public function __construct(protected \Magento\Webapi\Model\Config $config)
    {}

    public function toOptionArray()
    {
        return $this->getOptionsArray($this->getOptions());
    }

    public function toArray()
    {
        return $this->getOptions();
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        if (!isset($this->options)) {
            $this->options = [];
            $this->options[(string)__('-- None --')] = '';
            $options = $this->config->getServices()[Converter::KEY_ROUTES];
            foreach ($options as $route => $methods) {
                $label = \ucwords(\trim(\preg_replace('/^\/([^\/]+)\/([^\/]+).*/', '$1 $2', $route)));
                $this->options[$label][$route] = trim($route, '/');
            }
        }

        return $this->options;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function getOptionsArray(array $options)
    {
        $optionArray = [];
        foreach ($options as $label => $value) {
            $optionArray[] = [
                'value' => is_array($value) ? $this->getOptionsArray($value) : $value,
                'label' => $label,
            ];
        }
        return $optionArray;
    }
}
