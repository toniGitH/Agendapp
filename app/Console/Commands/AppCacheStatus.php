<?php

/**
 * This command shows the current status of the most relevant caches in Laravel:
 * - Whether the configuration is cached (bootstrap/cache/config.php)
 * - Whether the routes are cached
 * - Whether there are compiled views
 * - Displays the current environment (local, production, etc.)
 * 
 * Useful for quickly detecting if you're in an inconsistent state (e.g., config cached in local)
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class AppCacheStatus extends Command
{
    protected $signature = 'app-cache:status';
    protected $description = '🔍 Show application cache status and environment info';

    public function handle()
    {
        $this->info('🔍 Laravel Application Cache Status');
        $this->line('----------------------------------');

        // Current environment
        $this->info('🌍 Environment: ' . App::environment());

        // Check if the configuration is cached
        $configPath = base_path('bootstrap/cache/config.php');
        if (File::exists($configPath)) {
            // In local environment, show a warning
            if (App::environment('local')) {
                $this->warn('⚠️ This should not be cached in local! The configuration file is cached.');
            } else {
                $this->warn('⚠️ Configuration is cached.');
            }
        } else {
            $this->info('✅ Configuration is NOT cached.');
        }

        // Check if the routes are cached (routes.php file)
        $routesCachePath = base_path('bootstrap/cache/routes.php');
        if (File::exists($routesCachePath)) {
            // In local environment, show a warning
            if (App::environment('local')) {
                $this->warn('⚠️ This should not be cached in local! Routes are cached.');
            } else {
                $this->warn('⚠️ Routes are cached.');
            }
        } else {
            $this->info('✅ Routes are NOT cached.');
        }

        // Check for compiled views
        $compiledViews = File::allFiles(storage_path('framework/views'));
        if (count($compiledViews) > 0) {
            $this->warn('⚠️ Compiled views detected (' . count($compiledViews) . ' files).');
        } else {
            $this->info('✅ No compiled views detected.');
        }

        $this->line('----------------------------------');
        $this->info('✅ Status check complete.');
    }
}
