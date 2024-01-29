<?php

namespace Blackbird\RestLogger\Api;

interface ResolverInterface
{
    public function isAuthorizationRequest(): bool;
    public function isRequestExcluded(): bool;
}
