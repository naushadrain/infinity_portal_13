<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Older DBs have Laravel's legacy password_resets (email, token, created_at): add the OTP columns.
        if (Schema::hasTable('password_resets')) {
            Schema::table('password_resets', function (Blueprint $table) {
                if (!Schema::hasColumn('password_resets', 'otp')) {
                    $table->string('otp', 6)->nullable()->after('email');
                }
                if (!Schema::hasColumn('password_resets', 'expires_at')) {
                    $table->timestamp('expires_at')->nullable()->after('token');
                }
                if (!Schema::hasColumn('password_resets', 'is_verified')) {
                    $table->boolean('is_verified')->default(false)->after('expires_at');
                }
            });

            return;
        }

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('otp', 6);
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};
