<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
                        
            // Set the character set to utf8mb4 and collation to utf8mb4_bin for full Unicode support, including emojis and special characters.
            // This resolves issues with databases using case-insensitive (ci) collations.
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_bin';
        
            $table->id();
            $table->string('name', 25);
            $table->string('username', 9)->unique();
            $table->boolean('is_admin')->default(false);
            $table->string('profile_img')->nullable()->default('images/profile1.png');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
