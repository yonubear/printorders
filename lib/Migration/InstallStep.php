<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Migration;

use OCP\Migration\IRepairStep;
use OCP\Migration\IOutput;

class InstallStep implements IRepairStep 
{
    public function getName(): string 
    {
        return 'Install Print Orders app';
    }

    public function run(IOutput $output): void 
    {
        $output->info('Installing Print Orders app...');
    }
}