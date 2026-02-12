<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SwitchEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage:
     * php artisan env:local
     * php artisan env:ngrok
     */
    protected $signature = 'switch:env {target}';

    /**
     * The console command description.
     */
    protected $description = 'Switch between .env.local and .env.ngrok';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $target = $this->argument('target');
        $envFile = base_path(".env.{$target}");
        $mainEnv = base_path(".env");

        if (!File::exists($envFile)) {
            $this->error(".env.{$target} does not exist.");
            return Command::FAILURE;
        }

        File::copy($envFile, $mainEnv);
        $this->info("Switched to {$target} environment ✅");

        // Clear cache so Laravel picks up changes
        $this->call('optimize:clear');

        return Command::SUCCESS;
    }
}
