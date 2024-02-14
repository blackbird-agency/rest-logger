<?php

/**
 * Log
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Model;

use Blackbird\RestLogger\Api\Data\LogInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Log extends AbstractExtensibleModel implements LogInterface
{
    public function getLogId(): ?int
    {
        $id = $this->getData(self::LOG_ID);
        return $id !== null ? (int)$id : null;
    }

    public function setLogId(int $id): void
    {
        $this->setData(self::LOG_ID, $id);
    }

    public function getHttpMethod(): ?string
    {
        return $this->getData(self::HTTP_METHOD);
    }

    public function setHttpMethod(string $method): void
    {
        $this->setData(self::HTTP_METHOD, $method);
    }

    public function getEndpoint(): ?string
    {
        return $this->getData(self::ENDPOINT);
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->setData(self::ENDPOINT, $endpoint);
    }

    public function getPayload(): ?string
    {
        return $this->getData(self::PAYLOAD);
    }

    public function setPayload(string $payload): void
    {
        $this->setData(self::PAYLOAD, $payload);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getResponseCode(): int
    {
        return (int)$this->getData(self::RESPONSE_CODE);
    }

    public function setResponseCode(int $responseCode): void
    {
        $this->setData(self::RESPONSE_CODE, $responseCode);
    }

    public function getResponseBody(): ?string
    {
        return $this->getData(self::RESPONSE_BODY);
    }

    public function setResponseBody(string $responseBody): void
    {
        $this->setData(self::RESPONSE_BODY, $responseBody);
    }
}
