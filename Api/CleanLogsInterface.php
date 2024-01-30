<?php


namespace Blackbird\RestLogger\Api;

interface CleanLogsInterface
{
    public function execute(int $dayThreshold): void;
}
