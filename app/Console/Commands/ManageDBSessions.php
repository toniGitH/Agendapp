<?php

/**
 * This Laravel Artisan command lists and optionally deletes active database-stored user sessions.
 *
 * It queries the sessions table in the database, processes the records, and extracts comprehensive 
 * session data including:
 * - User identification (extracted from payload)
 * - Last activity timestamp
 * - User agent information
 * - IP address
 *
 * For each valid session, it displays the associated user's information and session details.
 * The command then prompts the user to optionally delete any of the listed sessions.
 *
 * ⚠️ IMPORTANT:
 * This command works with both SESSION_ENCRYPT=true and SESSION_ENCRYPT=false configurations.
 * When SESSION_ENCRYPT=true, it automatically decrypts the session payload before processing.
 * When SESSION_ENCRYPT=false, it directly reads the unencrypted session data.
 * 
 * The command uses multiple methods to extract the user ID from sessions:
 * 1. Direct extraction from unencrypted payload
 * 2. Checking for user_id column in the sessions table
 * 3. Cross-referencing with authentication_log table based on IP address
 * 4. Extracting from encrypted payload as a fallback
 */

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ManageDBSessions extends Command
{
    protected $signature = 'db-session:manage {--d|debug : Show more detailed output}';
    protected $description = '🔐 Show and manage active user sessions (works with both encrypted and unencrypted sessions)';

    public function handle()
    {
        if ($this->option('debug')) {
            $this->info('🛠️ Debug mode enabled - showing detailed information');
            $this->info('📊 Querying sessions table in database...');
        }

        // Get all sessions from the database
        $sessions = DB::table('sessions')->get();
        
        if ($sessions->isEmpty()) {
            $this->info('🔍 No sessions found in database.');
            return;
        }

        $this->info('Found ' . $sessions->count() . ' sessions in database.');
        
        // Get all active users
        if ($this->option('debug')) {
            $this->info('👥 Loading user data for reference...');
        }
        $activeUsers = User::all()->keyBy('id');
        
        $encryptionEnabled = config('session.encrypt', false);
        
        if ($this->option('debug')) {
            $this->info('🔐 Session encryption: ' . ($encryptionEnabled ? 'Enabled ✅' : 'Disabled ❌'));
            $this->info('🔑 App key: ' . (config('app.key') ? '[PRESENT]' : '[MISSING]'));
            $this->info('🔒 Cipher: ' . Config::get('app.cipher', 'AES-256-CBC'));
            $this->info('📝 Processing each session...');
        }
        
        // Display session information
        foreach ($sessions as $index => $session) {
            $this->line("[$index] Session ID: {$session->id}");
            $this->line("     Last activity: " . date('Y-m-d H:i:s', $session->last_activity));
            
            if ($this->option('debug')) {
                $this->line("     📦 Payload size: " . strlen($session->payload) . " bytes");
                $this->line("     🔍 Attempting to extract user ID...");
            }
            
            // Try to extract the user_id from the session payload
            $userId = null;
            
            if (!$encryptionEnabled) {
                if ($this->option('debug')) {
                    $this->line("     🔓 Trying unencrypted payload extraction...");
                }
                
                // Try to directly extract user ID from unencrypted payload
                $userId = $this->extractUserIdFromUnencryptedPayload($session->payload);
                
                if ($userId && $this->option('debug')) {
                    $this->line("     ✅ User ID extracted directly from payload: $userId");
                } elseif ($this->option('debug')) {
                    $this->line("     ❌ Failed to extract user ID from unencrypted payload");
                }
            }
            
            // If we couldn't get the user ID from payload, try alternative methods
            if (!$userId) {
                if ($this->option('debug')) {
                    $this->line("     🔄 Trying alternative extraction methods...");
                }
                
                $userId = $this->extractUserIdFromSession($session);
                
                if ($userId && $this->option('debug')) {
                    $this->line("     ✅ User ID extracted from alternative methods: $userId");
                } elseif ($this->option('debug')) {
                    $this->line("     ❌ Failed to extract user ID from alternative methods");
                }
            }
            
            // If still no userId but encryption is enabled, try to decrypt the payload
            if (!$userId && $encryptionEnabled) {
                if ($this->option('debug')) {
                    $this->line("     🔐 Trying encrypted payload extraction...");
                }
                
                $userId = $this->extractUserIdFromEncryptedPayload($session->payload);
                
                if ($userId && $this->option('debug')) {
                    $this->line("     ✅ User ID extracted from encrypted payload: $userId");
                } elseif ($this->option('debug')) {
                    $this->line("     ❌ Failed to extract user ID from encrypted payload");
                }
            }
            
            if ($userId && $activeUsers->has($userId)) {
                $user = $activeUsers[$userId];
                $this->line("     👤 User: {$user->username} ({$user->name})");
                
                if ($this->option('debug')) {
                    $this->line("     📧 Email: {$user->email}");
                    $this->line("     🔢 User ID: {$user->id}");
                }
            } else {
                $this->line("     👤 User: Unknown or not logged in");
                
                if ($this->option('debug') && $userId) {
                    $this->line("     ⚠️ User ID $userId exists in session but not found in database");
                }
            }
            
            $this->line("     🌐 User agent: " . ($session->user_agent ?? 'Unknown'));
            $this->line("     🌍 IP address: " . ($session->ip_address ?? 'Unknown'));
            
            if ($this->option('debug') && isset($session->payload)) {
                $this->line("     🔍 Payload preview: " . substr($session->payload, 0, 50) . "...");
            }
            
            $this->line("----------------------------------------");
        }

        if ($this->confirm('🗑️ Do you want to delete any session?')) {
            $indexToDelete = $this->ask('🔢 Enter the number of the session you want to delete');

            if (isset($sessions[$indexToDelete])) {
                $sessionToDelete = $sessions[$indexToDelete];
                $this->info("⚠️ Deleting session with ID: {$sessionToDelete->id}");

                if ($this->option('debug')) {
                    $this->info("📝 Executing delete query on sessions table...");
                }

                // Delete the session from the database
                $result = DB::table('sessions')->where('id', $sessionToDelete->id)->delete();

                if ($this->option('debug')) {
                    $this->info("🔄 Delete operation result: " . ($result ? "Success" : "Failed"));
                }

                $this->info("✅ Session successfully deleted.");
            } else {
                $this->error('❌ Invalid session number.');
            }
        } else {
            $this->info('🚫 No session has been deleted.');
        }
        
        if ($this->option('debug')) {
            $this->info('🏁 Command execution completed.');
        }
    }
    
    /**
     * Try to extract the user ID from an unencrypted session payload
     *
     * @param string $payload
     * @return int|null
     */
    private function extractUserIdFromUnencryptedPayload($payload)
    {
        try {
            if ($this->option('debug')) {
                $this->line("     🔄 Attempting to unserialize payload...");
            }
            
            $data = @unserialize($payload);
            
            if (!is_array($data)) {
                if ($this->option('debug')) {
                    $this->line("     ❌ Payload is not a valid serialized array");
                }
                return null;
            }
            
            if ($this->option('debug')) {
                $this->line("     ✅ Payload unserialized successfully");
                $this->line("     🔍 Searching for login keys in session data...");
                $this->line("     🔑 Session keys: " . implode(', ', array_keys($data)));
            }
            
            // Look for login keys in the session data
            foreach ($data as $key => $value) {
                if (strpos($key, 'login_web_') === 0) {
                    if ($this->option('debug')) {
                        $this->line("     ✅ Found login_web_ key: $key with value: $value");
                    }
                    return $value;
                }
                
                // Also check "auth" key which might contain user info
                if ($key === 'auth' && is_array($value) && isset($value['id'])) {
                    if ($this->option('debug')) {
                        $this->line("     ✅ Found auth.id key with value: {$value['id']}");
                    }
                    return $value['id'];
                }
            }
            
            if ($this->option('debug')) {
                $this->line("     ❌ No user identification keys found in session data");
            }
        } catch (\Exception $e) {
            if ($this->option('debug')) {
                $this->error('     ❌ Error unserializing payload: ' . $e->getMessage());
                $this->error('     📚 Stack trace: ' . $e->getTraceAsString());
            }
        }
        
        return null;
    }
    
    /**
     * Try to extract the user ID from an encrypted session payload
     *
     * @param string $payload
     * @return int|null
     */
    private function extractUserIdFromEncryptedPayload($payload)
    {
        try {
            if ($this->option('debug')) {
                $this->line("     🔐 Attempting to decrypt payload using Crypt facade...");
            }
            
            // Try to decrypt using Laravel's Crypt facade
            $decrypted = Crypt::decrypt($payload);
            
            if ($this->option('debug')) {
                $this->line("     ✅ Payload decrypted successfully using Crypt facade");
            }
            
            return $this->extractUserIdFromUnencryptedPayload($decrypted);
        } catch (\Exception $e) {
            if ($this->option('debug')) {
                $this->line("     ❌ Crypt facade decryption failed: " . $e->getMessage());
                $this->line("     🔄 Trying alternative decryption method...");
            }
            
            try {
                // Alternative method: manual decryption
                $key = $this->parseKey(config('app.key'));
                $cipher = Config::get('app.cipher', 'AES-256-CBC');
                
                if ($this->option('debug')) {
                    $this->line("     🔑 Using cipher: " . $cipher);
                    $this->line("     🔐 Creating custom Encrypter instance...");
                }
                
                $encrypter = new Encrypter($key, $cipher);
                $decrypted = $encrypter->decrypt($payload);
                
                if ($this->option('debug')) {
                    $this->line("     ✅ Manual decryption successful");
                }
                
                return $this->extractUserIdFromUnencryptedPayload($decrypted);
            } catch (\Exception $innerE) {
                if ($this->option('debug')) {
                    $this->error('     ❌ Error during manual decryption: ' . $innerE->getMessage());
                    $this->error('     📚 Stack trace: ' . $innerE->getTraceAsString());
                }
                return null;
            }
        }
    }
    
    /**
     * Parse the encryption key.
     *
     * @param string $key
     * @return string
     */
    protected function parseKey(string $key)
    {
        if ($this->option('debug')) {
            $this->line("     🔑 Parsing encryption key...");
        }
        
        if (strpos($key, 'base64:') === 0) {
            if ($this->option('debug')) {
                $this->line("     🔄 Key is base64 encoded, decoding...");
            }
            $key = base64_decode(substr($key, 7));
        }

        if ($this->option('debug')) {
            $this->line("     ✅ Key parsing complete");
        }
        
        return $key;
    }
    
    /**
     * Try to extract the user ID from a session using alternative methods
     * 
     * @param object $session
     * @return int|null
     */
    private function extractUserIdFromSession($session)
    {
        // Method 1: Check if there is a user_id column in the sessions table
        if (isset($session->user_id)) {
            if ($this->option('debug')) {
                $this->line("     ✅ Found user_id column in session record: {$session->user_id}");
            }
            return $session->user_id;
        } else if ($this->option('debug')) {
            $this->line("     ❌ No user_id column found in session record");
        }
        
        // Method 2: Look for active users matching the IP
        // This is less precise but can give us a clue
        if (isset($session->ip_address)) {
            if ($this->option('debug')) {
                $this->line("     🔍 Checking authentication_log for IP address: {$session->ip_address}");
            }
            
            // Check if authentication_log table exists
            try {
                if (DB::getSchemaBuilder()->hasTable('authentication_log')) {
                    if ($this->option('debug')) {
                        $this->line("     ✅ authentication_log table exists");
                        $this->line("     🔍 Searching for recent logins with this IP...");
                    }
                    
                    // Get the most recent users who logged in with this IP
                    $recentLogin = DB::table('users')
                        ->join('authentication_log', 'users.id', '=', 'authentication_log.authenticatable_id')
                        ->where('ip_address', $session->ip_address)
                        ->where('login_at', '<=', date('Y-m-d H:i:s', $session->last_activity))
                        ->orderBy('login_at', 'desc')
                        ->select('users.id')
                        ->first();
                        
                    if ($recentLogin) {
                        if ($this->option('debug')) {
                            $this->line("     ✅ Found matching user in authentication_log: {$recentLogin->id}");
                        }
                        return $recentLogin->id;
                    } else if ($this->option('debug')) {
                        $this->line("     ❌ No matching user found in authentication_log");
                    }
                } else if ($this->option('debug')) {
                    $this->line("     ❌ authentication_log table does not exist");
                }
            } catch (\Exception $e) {
                if ($this->option('debug')) {
                    $this->error('     ❌ Error checking authentication_log table: ' . $e->getMessage());
                    $this->error('     📚 Stack trace: ' . $e->getTraceAsString());
                }
            }
        } else if ($this->option('debug')) {
            $this->line("     ❌ No IP address in session record");
        }
        
        // Method 3: As a last resort, try to extract the user ID from
        // the current active session if we are logged in
        if ($this->option('debug')) {
            $this->line("     🔍 Checking current authenticated user...");
        }
        
        if (Auth::check()) {
            if ($this->option('debug')) {
                $this->line("     ✅ Current user is authenticated: " . Auth::id());
            }
            return Auth::id();
        } else if ($this->option('debug')) {
            $this->line("     ❌ No authenticated user in current request");
        }
        
        if ($this->option('debug')) {
            $this->line("     ❌ All methods failed to identify the user");
        }
        
        return null;
    }
}