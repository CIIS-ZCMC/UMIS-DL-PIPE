<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\DeviceController;
use App\Models\DeviceLogs;
use Carbon\Carbon;

class PullDTR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pull-device-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulling Device Logs';

    protected $deviceController;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Devices = DeviceController::ListofDevices();

        foreach ($Devices as $Device) {
            if ($tad = DeviceController::Connect($Device)) {

                $logs = $tad->get_att_log();
                $attendance = simplexml_load_string($logs);

                $pulled = 0;
                $already = 0;


                $bar = $this->output->createProgressBar($attendance->Row->count());
                $bar->start();

                foreach ($attendance->Row as $row) {
                    $Logged = DeviceLogs::firstOrCreate(
                        [
                            'biometric_id' => (string) $row->PIN,
                            'date_time' =>  Carbon::parse((string) $row->DateTime)->toDateTimeString(),
                        ],
                        [
                            'dtr_date' => Carbon::parse((string) $row->DateTime)->toDateString(),
                            'status' => (string) $row->Status,
                            'is_Shifting' => (string) $row->Verified,
                            'schedule' => (string) $row->WorkCode,
                            'active' => (string) $row->Verified,
                            'device_name' => $Device->device_name
                        ]
                    );

                    if ($Logged->wasRecentlyCreated) {
                        //     $this->line("Logged : " . $row->PIN . " to " . $Device->device_name);
                        $pulled++;
                        $bar->advance();
                    } else {
                        $already++;
                        //  $bar->advance($row);
                    }
                }

                $bar->finish();
                $this->line("\n<info>Sync Completed Successfully!</info>");
                if ($pulled > 0) {
                    $this->info("Pulled : " . $pulled);
                }
                if ($already > 0) {
                    $this->info("Already in Records : " . $already);
                }
            }
        }
    }
}
