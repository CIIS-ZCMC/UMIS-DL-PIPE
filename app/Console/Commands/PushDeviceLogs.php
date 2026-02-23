<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\DeviceLogs;
use Carbon\Carbon;

class PushDeviceLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:push-device-logs';
    ///syncDeviceLogs
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushing to UMIS-DEVICELOGS';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line("<fg=cyan>Starting Log Sync to UMIS...</>");

        $api = "http://localhost:8000/api/syncDeviceLogs";
        // 1. Get total count for the progress bar
        $total = DeviceLogs::count();

        if ($total === 0) {
            $this->warn("No logs found to push.");
            return;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        DeviceLogs::whereMonth("dtr_date", $currentMonth)
            ->whereYear("dtr_date", $currentYear)
            ->chunk(100, function ($logs) use ($api, $bar) {
                try {
                    $response = Http::withHeaders([
                        'Accept' => 'application/json'
                    ])->post($api, [
                        'test' => "sync_batch",
                        'data' => $logs
                    ]);

                    if ($response->successful()) {
                        $bar->advance(count($logs));
                    } else {
                        $this->error("\nBatch failed with status: " . $response->status());
                    }
                } catch (\Exception $e) {
                    $this->error("\nConnection Error: " . $e->getMessage());
                    return false;
                }
            });

        $bar->finish();
        $this->line("\n<info>Sync Completed Successfully!</info>");
    }
}
