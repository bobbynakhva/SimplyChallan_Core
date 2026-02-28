<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateLicense extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:generate {machine_id : The Machine ID from the client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a hardware-bound license key for a specific Machine ID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $machineId = $this->argument('machine_id');
        
        // Match the logic in LicenseService and former LicenseController
        $token = 'AppGrowth2026'; 
        $licenseKey = md5($machineId . $token);

        $this->info("----------------------------------");
        $this->info("Machine ID:  " . $machineId);
        $this->info("License Key: " . $licenseKey);
        $this->info("----------------------------------");
        $this->comment("Ask the user to add this to their .env file as APP_LICENSE_KEY");
    }
}
