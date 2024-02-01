<?php

/**
 * CleanupLogs
 *
 * @copyright Copyright © 2024 Blackbird Agency. All rights reserved.
 * @author    sebastien@bird.eu
 */

declare(strict_types=1);

namespace Blackbird\RestLogger\Console\Command;

use Blackbird\RestLogger\Api\CleanLogsInterface;
use Blackbird\RestLogger\Api\ConfigInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Safe\DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanupLogs extends Command
{
    public const SUCCESS_CODE = 0;
    public const ERROR_CODE = 1;
    public const THRESHOLD_ARG  = 'days';
    public const ALL_ARG = "all";

    public function __construct(
        protected CleanLogsInterface                                  $cleaner,
        protected ConfigInterface                                     $config,
        protected State                                               $state,
        string                                                        $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Blackbird Rest Logger Cleanup');
        $this->addArgument(self::THRESHOLD_ARG, InputArgument::OPTIONAL, 'Cleanup before N days');
        $this->addOption(self::ALL_ARG, null,null,"Remove all of logs", null);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $timeStart = (new \DateTime())->format('Y-m-d H:i:s');
            $output->writeln("<info>[$timeStart] Starting cleanup job.</info>");
            $this->state->setAreaCode(Area::AREA_CRONTAB);
            $threshold = $input->getArgument(self::THRESHOLD_ARG) ?: $this->config->getCleanupThreshold();
            $this->cleaner->execute((int)$threshold);

            $timeEnd = (new \DateTime())->format('Y-m-d H:i:s');
            $output->writeln("<info>[$timeEnd] Ending cleanup job with success.</info>");

            // Remove all of logs if --all is active
            if ($input->getOption(self::ALL_ARG) == 1) {
                // How to remove all of logs ?
                $this->cleaner->execute(0);
                $output->writeln("<info>All of logs are removed.</info>");
            }
            return self::SUCCESS_CODE;
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return self::ERROR_CODE;
        }
    }
}
