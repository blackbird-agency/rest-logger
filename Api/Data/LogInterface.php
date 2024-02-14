<?php


namespace Blackbird\RestLogger\Api\Data;

interface LogInterface
{
    public const LOG_ID = 'log_id';
    public const HTTP_METHOD = 'http_method';
    public const ENDPOINT = 'endpoint';
    public const PAYLOAD = 'payload';
    public const CREATED_AT = 'created_at';
    public const RESPONSE_CODE = 'response_code';
    public const RESPONSE_BODY = 'response_body';

    /**
     * @return int|null
     */
    public function getLogId(): ?int;

    /**
     * @param int $id
     * @return void
     */
    public function setLogId(int $id): void;

    /**
     * @return string|null
     */
    public function getHttpMethod(): ?string;

    /**
     * @param string $method
     * @return void
     */
    public function setHttpMethod(string $method): void;

    /**
     * @return string|null
     */
    public function getEndpoint(): ?string;

    /**
     * @param string $endpoint
     * @return void
     */
    public function setEndpoint(string $endpoint): void;

    /**
     * @return string|null
     */
    public function getPayload(): ?string;

    /**
     * @param string $payload
     * @return void
     */
    public function setPayload(string $payload): void;

    /**
     * @return int
     */
    public function getResponseCode(): int;

    /**
     * @param int $responseCode
     * @return void
     */
    public function setResponseCode(int $responseCode): void;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;

    /**
     * @return string|null
     */
    public function getResponseBody(): ?string;

    /**
     * @param string $responseBody
     * @return void
     */
    public function setResponseBody(string $responseBody): void;

}
