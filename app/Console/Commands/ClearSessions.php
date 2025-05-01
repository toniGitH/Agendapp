<?php
/**
 * This custom Artisan command allows you to delete all user sessions from the application,
 * regardless of whether the session driver is set to 'file', 'database', or 'cookie'.
 * 
 * - For 'file', it deletes all session files in the storage/framework/sessions directory.
 * - For 'database', it deletes all rows from the session table (default: 'sessions').
 * - For 'cookie', it displays a warning because the server cannot remove client-side sessions.
 * 
 * Before executing the deletion, the command asks for confirmation, unless the --force flag is used.
 * 
 * This command is useful for maintenance or to force logout all users at once.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ClearSessions extends Command
{
    protected $signature = 'app-sessions:clear {--force : Skip confirmation prompt}';
    protected $description = '🧹 Delete all user sessions (file, database, or cookie driver)';

    public function handle()
    {
        $driver = config('session.driver');
        $force = $this->option('force');

        $this->info("🔍 Session driver detected: {$driver}");

        switch ($driver) {
            case 'file':
                $files = File::files(storage_path('framework/sessions'));
                $count = count($files);
                $this->info("📁 Found {$count} session file(s).");

                if ($count === 0) {
                    $this->info('✅ No sessions to delete.');
                    return;
                }

                if ($force || $this->confirm("❓ Do you want to delete all file-based sessions?", false)) {
                    foreach ($files as $file) {
                        File::delete($file);
                    }
                    $this->info('✅ All file-based sessions have been deleted.');
                } else {
                    $this->info('❌ Operation cancelled.');
                }
                break;

            case 'database':
                $table = config('session.table', 'sessions');
                $count = DB::table($table)->count();
                $this->info("🗃️ Found {$count} session(s) in the database.");

                if ($count === 0) {
                    $this->info('✅ No sessions to delete.');
                    return;
                }

                if ($force || $this->confirm("❓ Do you want to delete all database sessions?", false)) {
                    DB::table($table)->delete();
                    $this->info("✅ All database sessions have been deleted.");
                } else {
                    $this->info('❌ Operation cancelled.');
                }
                break;

            case 'cookie':
                $this->warn('⚠️ Cannot delete cookie-based sessions from the server. They are stored in the user’s browser.');
                break;

            default:
                $this->error("❌ Session driver '{$driver}' is not supported by this command.");
                break;
        }

        $this->info('✅ Session cleanup complete.');
    }
}
