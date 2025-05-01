<?php
/**
 * This custom Artisan command allows safely and completely clearing Laravel's configuration, routes, views, and compiled files cache.
 * It's useful for "preparing" the application after making changes to configuration files (.env or config/*.php),
 * without having to manually run each command separately.
 * 
 * In local environment (development), it avoids running 'config:cache' because caching the configuration in local
 * can cause issues like not reflecting changes in real-time. In production, it will cache.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class ClearAppCache extends Command
{
    protected $signature = 'app-cache:clear';
    protected $description = '🧹 Clear all application caches safely, depending on the environment';

    public function handle()
    {
        $this->info('🔧 Clearing application caches...');

        // Always clear first
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('optimize:clear');

        // Only in environments other than local, cache the configuration
        if (!App::environment('local')) {
            $this->call('config:cache');
            $this->info('✅ Configuration cached for production.');
        } else {
            $this->warn('⚠️ Skipping config:cache in local environment.');
        }

        $this->info('✅ All done. Your application is now clean and ready.');
    }
}
