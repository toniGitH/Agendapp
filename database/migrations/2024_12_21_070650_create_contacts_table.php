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
        Schema::create('contacts', function (Blueprint $table) {
            
            // Set the character set to utf8mb4 and collation to utf8mb4_bin for full Unicode support, including emojis and special characters.
            // This resolves issues with databases using case-insensitive (ci) collations.
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_bin';
        
            $table->id(); // Auto-incrementing 'id' field
            $table->string('first_name', 255); // 'first_name' field, required and max 255 characters
            $table->string('last_name_1', 255); // 'last_name_1' field, required and max 255 characters
            $table->string('last_name_2', 255)->nullable(); // 'last_name_2' field, optional and max 255 characters
            $table->string('image')->nullable(); // Image field, optional
            $table->char('mobile', 9)->nullable()->unique(); // 'mobile' field, 9 digits, optional, unique
            $table->char('landline', 9)->nullable(); // 'landline' field, 9 digits, optional
            $table->string('email', 100)->nullable()->unique(); // 'email' field, optional, unique and max 100 characters
            $table->string('city', 100); // 'city' field, required and max 100 characters
            $table->string('province', 100)->nullable(); // 'province' field, nullable and max 100 characters
            $table->string('country', 100); // 'country' field, required and max 100 characters
            $table->string('notes', 255)->nullable(); // 'notes' field, optional and max 255 characters
            $table->unsignedBigInteger('user_id'); // field used to relate this table whith users table
            $table->timestamps(); // 'created_at' and 'updated_at' fields

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict'); // foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
