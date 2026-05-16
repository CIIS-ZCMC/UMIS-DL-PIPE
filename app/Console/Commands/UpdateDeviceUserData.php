<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDeviceUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-device-user-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {



        $running = true;
        while ($running) {

            $biometric_id = $this->ask('Please insert the biometric_id: ');
            $this->info('==== Sent to device ==== ' . $biometric_id);

            // Find Biometricid in UMIS database. take it then send to device


            $this->info('---------------------------------');
        }
    }
}
