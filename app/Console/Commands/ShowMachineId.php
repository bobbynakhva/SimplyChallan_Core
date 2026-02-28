<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowMachineId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:machine-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the unique Machine ID of the current computer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $machineId = \App\Services\LicenseService::getMachineId();
        
        $this->info("----------------------------------");
        $this->info("This PC's Machine ID: " . $machineId);
        $this->info("----------------------------------");
        $this->comment("Give this ID to the developer to generate your License Key.");
    }
}
