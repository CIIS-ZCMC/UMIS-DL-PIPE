<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DeviceController;

class RunConnectionCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-connection-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'running diagnostics on checking device connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Devices = DeviceController::ListofDevices();
        $device_count = count($Devices);
        $online_count = 0;
        $offline_count = 0;
        foreach ($Devices as $Device) {
            $this->line("Checking connection to " . $Device->ip_address . " ....");
            if (DeviceController::Connect($Device)) {
                $this->info("Online : " . $Device->ip_address . " || " . $Device->device_name);
                $online_count++;
            } else {
                $this->error("Offline : " . $Device->ip_address . " || " . $Device->device_name);
                $offline_count++;
            }
        }
        $this->line("\n\n");

        $this->line("Total Devices : " . $device_count);
        $this->info("Online Devices : " . $online_count);
        $this->warn("Offline Devices : " . $offline_count);

        $this->line("\n");

        if ($this->confirm('All connections checks are finished. Do you want to proceed with log pull? ', true)) {
            $this->call('app:pull-device-logs');
        }
    }
}
