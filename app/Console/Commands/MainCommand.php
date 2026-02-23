<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command to execute any process';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $running = true;
        $this->drawLogo();
        while ($running) {
            $options = [
                'Connect & Pull Logs',
                'Push DTR Logs',
                'Exit'
            ];

            $action = $this->choice('Select a process to execute', $options, 0);

            switch ($action) {
                case 'Connect & Pull Logs':
                    $this->call('app:run-connection-check');
                    break;

                case 'Push DTR Logs':
                    $this->call('app:push-device-logs');
                    break;

                case 'Exit':
                    $this->info('Shutting down UMIS CLI.');
                    $running = false; // This breaks the loop
                    break;
            }

            // Optional: Add a separator after each task finishes to keep it clean
            if ($running) {
                $this->line("\n" . str_repeat('-', 70) . "\n");
            }
        }
    }

    private function drawLogo()
    {
        $this->line("<fg=cyan>
    ====================================================
      _    _  __  __ _____  _____ 
     | |  | ||  \/  |_   _|/ ____|
     | |  | || \  / | | | | (___  
     | |  | || |\/| | | |  \___ \ 
     | |__| || |  | |_| |_ ____) |
      \____/ |_|  |_|_____|_____/ 
                                  
    User Management Information System
    ZAMBOANGA CITY MEDICAL CENTER
    < IMISS >
    ====================================================
    </>");
    }
}
