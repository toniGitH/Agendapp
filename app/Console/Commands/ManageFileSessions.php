<?php

/**
 * This Laravel Artisan command lists and optionally deletes active file-based user sessions.
 *
 * It scans the session files stored in `storage/framework/sessions`, processes their contents 
 * (decrypting if needed), and extracts session data including:
 * - User identification (based on keys starting with "login_web_")
 * - Session ID
 * - User information (username and name)
 *
 * For each valid session, it displays the associated user's information and session details.
 * The command then prompts the user to optionally delete any of the listed sessions.
 *
 * ⚠️ IMPORTANT:
 * This command works with both SESSION_ENCRYPT=true and SESSION_ENCRYPT=false configurations.
 * When SESSION_ENCRYPT=true, it automatically decrypts the session contents before processing.
 * When SESSION_ENCRYPT=false, it directly reads the unencrypted session data.
 */

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;

class ManageFileSessions extends Command
{
    protected $signature = 'file-session:manage {--d|debug : Show more detailed debug information}';
    protected $description = '🔐 Show and manage active user sessions (works with both encrypted and unencrypted sessions)';

    public function handle()
    {
        $sessionsDir = storage_path('framework/sessions');
        $sessions = glob($sessionsDir . '/*');

        $activeSessions = [];
        $encryptionEnabled = config('session.encrypt');

        if ($this->option('debug')) {
            $this->info('Session encryption: ' . ($encryptionEnabled ? 'Enabled' : 'Disabled'));
        }

        $this->info('Found ' . count($sessions) . ' session files.');

        foreach ($sessions as $sessionFile) {
            $content = file_get_contents($sessionFile);
            $sessionData = null;

            // If sessions are encrypted, we need to decrypt them first
            if ($encryptionEnabled) {
                try {
                    // First try to decrypt with Laravel's method
                    $decrypted = Crypt::decrypt($content);
                    $sessionData = @unserialize($decrypted);
                } catch (\Exception $e) {
                    // If it fails, we try the alternative method
                    try {
                        // Get the application key for decryption
                        $key = $this->parseKey(config('app.key'));
                        $cipher = Config::get('app.cipher', 'AES-256-CBC');
                        
                        // Create an encrypter with the application key
                        $encrypter = new Encrypter($key, $cipher);
                        
                        // Decrypt the session content
                        $decrypted = $encrypter->decrypt($content);
                        $sessionData = @unserialize($decrypted);
                    } catch (\Exception $innerE) {
                        if ($this->option('debug')) {
                            $this->line("Error decrypting session: " . basename($sessionFile));
                        }
                        continue;
                    }
                }
            } else {
                // If they are not encrypted, we simply deserialize
                $sessionData = @unserialize($content);
            }

            if (!is_array($sessionData)) {
                continue; // Skip if it cannot be deserialized
            }

            // Show full session data structure when debugging
            if ($this->option('debug')) {
                $this->line("Estructura de la sesión " . basename($sessionFile) . ":");
                $this->line(print_r($sessionData, true));
            }

            // Find the authenticated user ID
            $userId = null;
            foreach ($sessionData as $key => $value) {
                if (strpos($key, 'login_web_') === 0) {
                    $userId = $value;
                    break;
                }
            }

            if ($userId) {
                $user = User::find($userId);

                if ($user) {
                    $activeSessions[] = [
                        'session_file' => $sessionFile,
                        'session_id' => basename($sessionFile),
                        'user_id' => $userId,
                        'user_name' => $user->username,
                        'name' => $user->name,
                    ];
                }
            }
        }

        if (count($activeSessions) > 0) {
            foreach ($activeSessions as $index => $session) {
                $this->line("[$index] Session ID: {$session['session_id']}");
                $this->line("     User: {$session['user_name']} ({$session['name']})");
                $this->line("----------------------------------------");
            }

            if ($this->confirm('🗑️ Do you want to delete any session?')) {
                $indexToDelete = $this->ask('🔢 Enter the number of the session you want to delete');

                if (isset($activeSessions[$indexToDelete])) {
                    $sessionToDelete = $activeSessions[$indexToDelete];
                    $this->info("⚠️ Deleting session of: {$sessionToDelete['user_name']}");

                    unlink($sessionToDelete['session_file']);

                    $this->info("✅ Session successfully deleted.");
                } else {
                    $this->error('❌ Invalid session number.');
                }
            } else {
                $this->info('🚫 No session has been deleted.');
            }

        } else {
            $this->info('🔍 No active sessions found.');
        }
    }

    /**
     * Parse the encryption key.
     *
     * @param  string  $key
     * @return string
     */
    protected function parseKey(string $key)
    {
        if (strpos($key, 'base64:') === 0) {
            $key = base64_decode(substr($key, 7));
        }

        return $key;
    }
}