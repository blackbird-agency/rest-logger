<?php

/**
 * Payload
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Truncate extends Column
{
    const MAX_LENGHT = 150;

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $fieldName = $this->getData('name');
                if (isset($item[$fieldName])) {
                    $item[$fieldName . '_full'] = $item[$fieldName];
                    $item[$fieldName] = $this->truncate($item[$fieldName]);
                }
            }
        }
        return $dataSource;
    }

    protected function truncate(string $payload): string
    {
        return \strlen($payload) > self::MAX_LENGHT ?
            \substr($payload, 0, self::MAX_LENGHT) . ' ...' :
            $payload;
    }
}
